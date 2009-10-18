<?php
session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "username_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
session_register( "usertype_session" );
?>
<?php
  require_once( 'topInclude.php' );
	if( !(isset($_SESSION['userid']) && !empty($_SESSION['userid'])) ) {
		header( "Location: "."main.php?message=inga rättigheter!" );
		exit();
	}
?>
<?php
  if( isset( $_GET['mode'] ) && $_GET['mode'] == "delete" ) {

	$sql = "select id from friends where id = ".intval( $_GET['id'] )." and (friend_id = ".$_SESSION['userid']." or user_id = ".$_SESSION['userid'].")";
	$result = $conn->execute( $sql );
	if( $result ) {
		$sql = "delete from friends where id = ".intval( $_GET['id'] );
		$conn->execute( $sql );
		$message = "Vänskapen borttagen!";
	}
	else {
		$message = "Ingen sådan relation finns";
	}
	header( "Location: "."friends.php?message=".$message );
}
else {
	?>

  <tr>
    <td valign="top" align="left">
    <div class="boxLeft">
    <?php
      require_once( 'toolbox.applet.php' );
	?>
    </div>  


<?php
      if( isset($_SESSION['userid']) && !empty($_SESSION['userid']) ) {
		?>
    <div class="boxLeft">
    <h3 class="boxHeader">
    just nu:</h3>
    <h4 class="boxContent">
    <?php
          require_once( 'action.applet.php' );
		?>
    </h4>
    </div>    
<?php
	}
	?>
    
    <div class="boxLeft">
    <h3 class="boxHeader">
    Visheter:</h3>
    <h4 class="boxContent">
      <?php
      require_once( 'wiseBox.applet.php' );
	?>
    </h4>
    </div>
        
    <div class="boxLeft">
    <h3 class="boxHeader">
    senast inloggade:</h3>
    <h4 class="boxContent">
    <?php
      require_once( 'userHistory.applet.php' );
	?>
    </h4>
    </div>

    <div class="boxLeft">
    <h3 class="boxHeader">
    nya tankar:</h3>
    <h4 class="boxContent">
      <?php
      require_once( 'diarys.applet.php' );
	?>
    </h4>
    </div>      
        
  </td>

<script language="javascript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
  return true ;
else
  return false ;
}
</script>
    
    <td height="190" valign="top">
    <?php
      if( $_GET['userid'] != "" ) {
		$userid = intval( $_GET['userid'] );
	}
	else {
		header( "Location: "."friends.php?userid=".$_SESSION['userid']."&message=".$_GET['message'] );
	}
	if( $userid == "" ) {
		header( "Location: "."main.php?message=Ingen anv&auml;ndare angedd" );
	}
	$sql = "select * from users where userid = ".$userid;
	$dbUser = $conn->execute( $sql );
	// $sql = "select top 5 * from loginhistory where userid = ".$userid." order by logintime desc";
	// $dbHistory = $conn->execute( $sql );
	$sql = "select count(userid) as count from loginhistory where userid = ".$userid;
	$dbLoginCount = $conn->execute( $sql );
	print isset( $_GET['message'] ) ? $_GET['message'] : '';
	?>
    
    
    
    <div class=presentationTop>
        
        
        
            <?php
	///////////// &Aring;ldersber&auml;kning ////////////////////

	$birthdate = mktime( 0, 0, 0, $dbUser['born_month'], $dbUser['born_date'], $dbUser['born_year'] );
	$diff = time( ) - $birthdate;
	$age = $diff / ( 3600 * 24 );
	$age = round( $age / 365, 1 );

	//////////////////////////////////////////////////

	if( $dbUser['first_name'] != $dbUser['username'] ) {
		print $dbUser['first_name']." <b>'".$dbUser['username']."'</b> ".$dbUser['last_name'].", ";
	}
	else {
		print "<b>".$dbUser['username']."</b> ".$dbUser['last_name'].", ";
	}
	if( $dbUser['gender'] == 0 ) {
		print "kille, ".$age." &aring;r";
	}
	else {
		print "tjej, ".$age." &aring;r";
	}

	//response.write(dbUser("city"))

	?>

        </div>
    
    
    
    
    
            <TABLE CELLPADDING="0" CELLSPACING="0">
        <TR VALIGN="middle" ALIGN="LEFT">
        <TD WIDTH="404" HEIGHT="22">
        
        <div class="newsText">
        <?php
      $sql = "select friends.id, friends.friend_id, friends.user_id, friends.date, friends.accepted,users.username, friendtypes.friendtypename from friends inner join users on users.userid = friends.friend_id inner join friendtypes on friendtypes.friendtypeid = friends.friendtype where user_id = ".$userid." and accepted = 0";
	$friendList = $conn->execute( $sql );
	// print_r($friendList);
	if( $_SESSION['userid'] == intval( $_GET['userid'] ) && $friendList ) {
		if( !is_array( current( $friendList ) ) ) 
			$friendList = array($friendList);
		$friendLists = $friendList;
		foreach( $friendLists as $friendList ) {
			print "<a class=a2 href=userPresentation.php?userid=".$friendList['friend_id'].">".$friendList['username']."</a> vill skapa relationen ".$friendList['friendtypename']." med dig!<br>Vad s&auml;ger du? <a class=a2 href=addFriend.php?mode=approve&id=".$friendList['id'].">Rocka fett</a> eller <a class=a2 href=addFriend.php?mode=dismiss&id=".$friendList['id'].">dissa</a>?<br><br>";
		}
	}
	$friendList = null;
	print "<hr width=75% align=center>";
	$sql = "select friends.id, users.online, friends.friend_id, friends.user_id, friends.date, friends.accepted,users.username, friendtypes.friendtypename from friends inner join users on users.userid = friends.friend_id inner join friendtypes on friendtypes.friendtypeid = friends.friendtype where user_id = ".$userid." and accepted = 1 order by friendtypes.friendtypeid";
	$friendList = $conn->execute( $sql );
	print "Vi har g&aring;tt &ouml;ver stock och sten f&ouml;r att bli ".$dbUser['username']."'s v&auml;n:<br>";
	if( $friendList ) {
		print "<table border=0>";
		if( !is_array( current( $friendList ) ) ) 
			$friendList = array($friendList);
		$friendLists = $friendList;
		foreach( $friendLists as $friendList ) {
			$online = $friendList['online'];
			if( $online == true ) {
				$online = "<font color=#00FF00>online</font>";
			}
			else {
				$online = "<font color=red>offline</font>";
			}
			print "<tr><td><a href=userPresentation.php?userid=".$friendList['friend_id']." class=a2>".$friendList['username']."</a> (<i>".$online."</i>) &auml;r <b>".$friendList['friendtypename']."</b></td>";
			if( $_SESSION['userid'] == intval( $_GET['userid'] ) ) {
				print "<td><a href=friends.php?mode=delete&id=".$friendList['id']."><img src=images/icons/trashcan.gif border=0 onClick=\"return confirmSubmit('&Auml;r du s&auml;ker p&aring; att du vill ta bort denna relation, f&ouml;r evigt?');\"></a></td>";
			}
			print "</tr>";

			//      $friendList->moveNext;
		}
		print "</table>";
	}
	else {
		print "Ingen &auml;r din v&auml;n!<br><br>Det h&auml;nde n&aring;gong&aring;ng<br>strax f&ouml;re ny&aring;r<br>jag stod p&aring; min balkong<br>&aring; titta ut<br><br>d&auml;rute s&aring; lyste<br>stj&auml;rnorna klara<br>dom str&aring;lade sitt ljus<br>ner &ouml;ver mig<br><br>Pl&ouml;tsligt fick jag h&ouml;ra, en viskning i mitt &ouml;ra<br>Jultomten, han &auml;r d&ouml;d!<br><br>ensammast i v&auml;rlden<br>vart tog du v&auml;gen?";
	}
	$friendList = null;
	print "<hr width=75% align=center>";
	$sql = "select distinct friends.id, users.online, friends.friend_id, friends.user_id, friends.date, friends.accepted, users.username, friendtypes.friendtypename from friends inner join users on friends.user_id = users.userid inner join friendtypes on friendtypes.friendtypeid = friends.friendtype where friend_id = ".$dbUser['userid']." and accepted = 1";
	$friendList = $conn->execute( $sql );
	print $dbUser['username']." har varit modig nog att bli v&auml;n med:<br>";
	if( $friendList ) {
		if( !is_array( current( $friendList ) ) ) 
			$friendList = array($friendList);
		$friendLists = $friendList;
		foreach( $friendLists as $friendList ) {
			print "<table border=0>";
			$online = $friendList['online'];
			if( $online == true ) {
				$online = "<font color=#00FF00>online</font>";
			}
			else {
				$online = "<font color=red>offline</font>";
			}
			print "<tr><td><a href=userPresentation.php?userid=".$friendList['user_id']." class=a2>".$friendList['username']."</a> (<i>".$online."</i>) &auml;r <b>".$friendList['friendtypename']."</b></td>";
			if( $_SESSION['userid'] == intval( $_GET['userid'] ) ) {
				print "<td><a href=friends.php?mode=delete&id=".$friendList['id']."><img src=images/icons/trashcan.gif border=0 onClick=\"return confirmSubmit('&Auml;r du s&auml;ker p&aring; att du vill ta bort denna relation, f&ouml;r evigt?');\"></a></td>";
			}
			print "</tr>";

			//      $friendList->moveNext;
		}
		print "</table>";
	}
	else {
		print $dbUser['username']." har inte f&ouml;rs&ouml;kt bli kompis med n&aring;gon, vad &auml;r det f&ouml;r liv? Kom igen nu!";
	}
	?>
        </div>
        </TD>
        </TR>
        </TABLE>
      
        </td>
    
    <td width="145" height="109" valign="top">
    
    
    <div class="boxRight" align="left">
    <h3 class="boxHeader">Grejsl&aring;dan</h3>
    <h4 class="boxContent">
    <?php
      require_once( 'grejsBox.applet.php' );
	?>
    </h4>
    </div>
    
    <div class="boxRight">
    <h3 class="boxHeader">Bli v&auml;n med!</h3>
    <h4 class="boxContent">
    <?php
      require_once( 'friends.applet.php' );
	?>
    </h4>
    </div>
    
    <div class="boxRight">
    <h3 class="boxHeader">Sysslar med</h3>
    <h4 class="boxContent">
    <?php
      $sql = "select * from artlist inner join userartlist on artlist.artid = userartlist.artid where userartlist.userid = ".$_GET['userid'];
	$artList = $conn->execute( $sql );
	$artLists = $artList;
	foreach( $artLists as $artList ) {
		print "<IMG SRC=images/icons/pluss.gif> ".$artList['artname']."<br>";

		//    $artList->movenext;
	}
	?>
    </h4>
      </div>

    <div class="boxRight">
    <h3 class="boxHeader">Aktiviteter</h3>
    <h4 class="boxContentCalendar">
        <?php
      require_once( 'calendar.php' );
	?>
    </h4></div>
    
    <div class="boxRight">
    <h3 class="boxHeader">
    Senaste bilder:</h3>
    <h4 class="boxContent">

      <?php
      require_once( 'image.applet.php' );
	?>
    </h4>
    </div>      
    
    </td>
  </tr>
  
  <tr>
    
  
    <td width="145" height="109" valign="top">
    
    
    

    </td>
  </tr>
<?php
      require_once( 'bottomInclude.php' );
	?>
<?php
}
?>