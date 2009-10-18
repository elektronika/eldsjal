<?php
class Util {
  private static $timediff_start;
  /* Lämnar tillbaka en array med svenska månadsnamn. */
  
  private function __construct() {
  }


  public static function se_months() {
    return Array('januari','februari','mars','april','maj','juni','juli','augusti','september','oktober','november','december');
  }
  
  /* Lämnar en hashtable med månadsnummer för svenska månadsnamn. */
  public static function se_months_num() {
    return array('januari'=>1,
		 'februari'=>2,
		 'mars'=>3,
		 'april'=>4,
		 'maj'=>5,
		 'juni'=>6,
		 'juli'=>7,
		 'augusti'=>8,
		 'september'=>9,
		 'oktober'=>10,
		 'november'=>11,
		 'december'=>12);
  }

  public static function users_online() {
  	return current(DB::mysql()->query("SELECT COUNT(*) FROM user WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastload)<600")->fetch_assoc());
  }
  
  	public static function get_all_users()  {
	   	$users = DB::mysql()->query("select uid from user where not deleted");
	    while($users && $user = $users->fetch_assoc())
			$uid[] = $user['uid'];
	    return $uid;
	}
	
	public static function get_all_privileges() {
		$result = DB::mysql()->query('SELECT name FROM privilege_type');
		while($result && $priv = $result->fetch_assoc())
			$privs[] = $priv['name'];
		return $privs;
	}
	
	public static function get_all_counties() {
		$result = DB::mysql()->query('SELECT county FROM county ORDER BY sortOrder ASC');
		while($result && $county = $result->fetch_assoc())
			$counties[] = $county['county'];
		return $counties;
	}  
  /* 
  Alerts-relaterade grejer har blivit flyttade till klassen Alert (/classes/alert.class.php) 
  Det här är bara rester av det gamla, som ska rensas bort när det inte används någonstans längre.
  Just nu finns det till och med ställen där add_alert() används. Det är rätt så old.
  */
  
  /* Räknar alerts av en viss typ eller hämtar alla. */
  public static function alert_count($type = null) {
    return Alert::count($type);
  }
 
  /* Lägger till alerts. $uid kan vara ett uid eller en array uid. */
  public static function alert_add($type, $uid, $id=null) {
    return Alert::add($type, $uid, $id);
  }
  
  /* Tar bort alerts. $id kan vara ett id eller en array med id*/
  public static function alert_remove($type, $id = null) {
  	return Alert::remove($type, $_SESSION['user']->uid, $id);
  }
  
  
  

  public static function timediff($t1=null, $t2=null) {
    if(self::$timediff_start == null) {
      self::$timediff_start = microtime();
      return;
    }
    if($t1 == null)
      $t1 = self::$timediff_start;
    if($t2 == null)
      $t2 = microtime();
    
    $t1=split(' ',$t1,2);
    $t2=split(' ',$t2,2);
    return $t2[0]+$t2[1]-$t1[0]-$t1[1];
  }
  
  /* 
  get_priv(), get_group() och update_privileges() borde tillhöra User-klassen tycker Johnny 
  Då som has_priv() och is_in_group().
  */
  
  public static function get_priv($priv,$important = false) {
    if($priv!='' && $important && !isset($_SESSION['privileges'][$priv]))
      throw new PrivilegeException($priv);
    if($priv=='')
      return true;

    return isset($_SESSION['privileges'][$priv]);
  }

  public static function get_group($grp,$important = null,$admin=null) {
    if($important && !isset($_SESSION['user']->groups[strtolower($grp)]))
      throw new PrivilegeException($grp);
    else if($important && $admin && !$_SESSION['user']->groups[strtolower($grp)]['admin'])
      throw new PrivilegeException($grp.' admin');
    if(isset($_SESSION['user']->groups[strtolower($grp)]))
      return $_SESSION['user']->groups[strtolower($grp)];
    else
      return null;
  }
  
  public static function update_privileges() {
    $db = DB::mysql();
    $user = $_SESSION['user'];
    if(!$user)
      return;
    unset($_SESSION['privileges']);
    $privileges = $db->query("
    select distinct privilege_type.name
      from user
      natural join user_group
      natural left join `group`
      natural left join group_privilege
      join privilege_type on group_privilege.pid = privilege_type.name or
                             (pgid = user_group.gid and admin) or
                             user_group.gid = 1
      where user.uid='{$user->uid}' 
    union
    select name
      from privilege_type
      join user_privilege on privilege_type.name = user_privilege.pid and user_privilege.uid = '{$user->uid}';
    ");
    while($privilege = $privileges->fetch_assoc()) {
      $privs[$privilege['name']] = 1;
    }
    if($privs) {
      $_SESSION['privileges'] = $privs;
    }
    unset($_SESSION['user']->groups);
    $groups = $db->query("
    select group.gid,
           group.pgid,
           group.name,
           group.description,
           admin 
      from user_group
      join `group` on (user_group.gid = `group`.gid or (pgid = user_group.gid and admin) or user_group.gid = 1) and
                      uid = '{$_SESSION['user']->uid}'
      group by `group`.gid
      order by !isnull(pgid),name;
    ");
    while($groups && $group = $groups->fetch_assoc()) {
      $grps[strtolower($group['name'])] = $group;
      $gids[$group['gid']] = $group['name'];
      if($group['pgid'])
	$grps[strtolower($gids[$group['pgid']])]['subgroups'][] = $group['name'];
    }
    $_SESSION['user']->groups = $grps;
    alert_remove('privilege');
  }

  public static function get_groups() {
        // Hämta alla grupper.
        $g = DB::mysql()->query("select name as `group` from `group` order by name");
        while($g && $group = $g->fetch_assoc())
            $groups[] = $group['group'];

        return $groups;
  }
  
  public static function get_group_ids() {
        // Hämta alla gruppers ID'n.
        $g = DB::mysql()->query("select gid as `group` from `group` order by name");
        while($g && $group = $g->fetch_assoc())
            $groups[] = $group['group'];

        return $groups;
  }
  
  public static function get_system_message( $title ) {
  	$msg = Wiki::load_page($title, 'system');
  	return $msg['text'];
  }
  
  public static function make_utf8($string,$charset) {
    return html_entity_decode(htmlentities($string,ENT_QUOTES,strtolower(trim(str_replace('"','',$charset)))),ENT_QUOTES,'UTF-8');
  }

  public static function select_pages($pages, $current, $count) {
    if($pages<2) {
      $p[] = 1;
      return $p;
    }
    $lx1 = 0;
    $lx2 = 1;
    $c=0;
    if(!$current)
      $current = 1;
    $ps[$current] = $current;
    $f = $current<$count||$pages-$current<$count?1.2:2;

    while($c<$count/$f) { // hitta några fibonaccital
      $x = ($lx1);
      $lx1 = $lx2;
      $lx2 = $x+$lx1;
      $fib[$x] = $x;
      $c++;
    }
    $c=0;
    for($i =1;$i<=2;$i++) { // lägg till närmaste sidorna så man får en fin sekvens runt current iaf.
      if($current-$i>0) { // bakåt
	$ps[$current-$i]=$current-$i;
	$c++;
      }
      if($current+$i<=$pages) { // framåt
	$ps[$current+$i]=$current+$i;
	$c++;
      }
    }
    foreach($fib as $key => &$val) { // lägg till sidor med stegrande avstånd.
      $t = $current+floor(($pages-$current)*$val/$x);
      $q = floor(($current)*$val/$x);
      while($q<=$current) { // bakåt, om redan tillagd, ta nästa
	if(!isset($ps[$q]))
	  break;
	$q--;
      }
      while($t>=$current && $t<=$pages) { // framåt, om tillagd, ta nästa
	if(!isset($ps[$t]))
	  break;
	$t++;
      }
      if($count>$c && $q>0) { 
	$ps[$q] = $q;
	$c++;
      }
      if($count>$c && $t<=$pages) {
	$ps[$t] = $t;
	$c++;
      }
      if($c>=$count) // Sluta om vi gått över gränsen $count. 
	break;
    }
    sort($ps);
    return $ps;
  }

  public static function history_add($type, $id=null , $extra=null, $owner=null) {
    if(User::is_loggedin(false)) {
      $db = DB::mysql();
      if($extra && sizeof($extra)>1)
	$extras = implode('||',$extra);
      else 
	$extras = $extra;
      $extras = addslashes($extras);
      $db->query("insert into history_trail (uid,type,id,extra,owner) values ({$_SESSION['user']->uid},'{$type}',".($id?$id:'NULL').",'$extras',".($owner?$owner:'null').")");
    }
  }

  /* parsar webadresser ur $text och gör länkar av dem. */
  public static function findurls($text) {
    $text = preg_replace_callback('/([\s]+|^)([\w]+:\/\/)([\w-?&;#~=\.\@%+]+)(\/)?([:\w\-\?\&\;%+#~=\,\.\/\@]+[\w\/]?)?/i',array('Util','url_callback'), $text);
  $text = preg_replace("/(:\s)[\w-\.]+@(\w+[\w-]+\.){0,3}\w+[\w-]+\.[a-zA-Z]{2,4}\b/i"," <a href=\"mailto:$0\">$0</a>",$text);
  return $text;
}

  private static function url_callback($match) {
    if(!isset($match[5]))
        $match[5] = "";
    if(!isset($match[6]))
        $match[6] = "";
  
    return $match[1]."<a class='ext' href='".trim($match[0])."'>".$match[3].($match[5]?'/...':'')."</a>".$match[6];
  }

}
?>