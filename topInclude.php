<?php

ini_set('display_errors', TRUE);

session_register( "userid" );
session_register( "usertype" );
session_register( "username" );

$application = array(
	'userhistory'=>6,
	'systemnewsitems'=>2,
	'newsadmin'=>6,
	'systemforumcount'=>6,
	'newsadmin'=>6,
	'forumadmin'=>6,
	'linksadmin'=>3,
	'calendaradmin'=>3,
	'imageadmin'=>3,
	'wisdomadmin'=>3,
	'useradmin'=>2,
	'triviaadmin'=>2,
	'admin'=>10,
	'eldsjalDB'=>'omgwtf',
	'lastUpdate'=>'imorgon',
	'version'=>'2&frac12;',
	'versionname'=>'<a href="http://en.wikipedia.org/wiki/Mad_Hatter">Mad hatter</a> release',
	'loggedincount'=>'J&auml;ttem&aring;nga',
	'membercount'=>'Miljoners miljarders',
	'visitorcount'=>'En hel del',
	'originalimagepath'=>'original_images',
	'calendarimagepath'=>'uploads/calendar',
	'newsimagepath'=>'uploads/news',
	'galleryimagepath' => 'uploads/galleryImages',
	'userimagepath'=>'uploads/userImages',
	'imagepath'=>'upload',
	'userimageuri' => '/uploads/userImages/',
	'ripuser' => 1590
);

class MysqlConn {

	private $conn;
	public $type = 'mysql';

	public function __construct( ) {
		$this->conn = mysql_connect( 'localhost', 'eldsjal', 'wTYpSC9YRsPdp6U8' );
		// print phpversion();
		// mysql_set_charset('utf8');
		mysql_select_db( 'eldsjal', $this->conn );
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $this->conn);
	}

	public function execute( $sql ) {
		// print '<br>'.$sql.'<br>';
		$sql = str_replace('getdate()', 'now()', $sql);
		$sql = str_replace('[date]', 'date', $sql);
		$result = mysql_query( $sql, $this->conn );
		if( mysql_errno($this->conn) > 0 ) {
			print 'MySQL error ('.mysql_errno($this->conn).') '.mysql_error($this->conn);
			return false;
		}
		else {
			if( $result === TRUE ) 
				return TRUE;
			elseif( $result !== FALSE ) {
				if( mysql_num_rows( $result ) > 0 ) {
					while( $result && $row = mysql_fetch_assoc( $result ) ) 
						$rows[] = array_change_key_case($row);
					if( count( $rows ) == 1 ) 
						$rows = current( $rows );
					return $rows;
				}
				else 
					return 0;
			}
			else 
				return false;
		}
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->conn);
	}
	

	public function close( ) {
		mysql_close( $this->conn );
	}
	
	public function insert_id() {
		return mysql_insert_id( $this->conn );
	}
}


function makePager( $url, $numberOfItems, $currentPage = 1, $itemsPerPage = 15 ) {
	$numberOfPages = ceil( $numberOfItems / $itemsPerPage );
	if( $numberOfPages > 1 ) {
		print "<table border=\"0\" width=\"100%\"><tr>";
		if( $currentPage > 1 ) 
			print "<td width=\"100\" valign=\"top\" align=\"left\"><a href=\"".$url.( $currentPage - 1 )."\" class=\"a2\">&laquo; sidan innan</a></td>";
		else 
			print "<td width=\"100\">&nbsp;</td>";
		print "<td align=\"center\">".$currentPage." / ".$numberOfPages."</td>";
		if( $currentPage < $numberOfPages ) 
			print "<td width=\"100\" align=\"right\"><a href=\"".$url.( $currentPage + 1 )."\" class=\"a2\">n&auml;sta sida &raquo;</a></td>";
		else 
			print "<td width=\"100\">&nbsp;</td>";
		print "</tr></table>";
	}
}

function paginate( $items, $currentPage = 1, $itemsPerPage = 15 ) {
	return array_slice( $items, (( $currentPage - 1 ) * $itemsPerPage ), $itemsPerPage );
}

function timeSince( $timestamp, $suffix = ' sedan', $hover = TRUE, $hoverDateFormat = 'Y-m-d H:i' ) {
	$timeDiff = time() - $timestamp;
	
	if( $timeDiff < 60 ) {
		$out = 'alldeles nyss';
		$suffix = $suffix == ' sedan' ? '' : $suffix;
	}
	elseif( $timeDiff < 7 * 60 )
		$out = 'n&aring;gra minuter';
	elseif( $timeDiff < 17 * 60 )
		$out = 'typ en kvart';
	elseif( $timeDiff < 27 * 60 )
		$out = 'n&auml;stan en halvtimme';
	elseif( $timeDiff < 40 * 60 )
		$out = 'lite mer &auml;n en halvtimme';
	elseif( $timeDiff < 55 * 60 )
		$out = 'n&auml;stan en timme';
	elseif( $timeDiff < 90 * 60 )
		$out = 'typ en timme';
	elseif( $timeDiff < 22 * 3600 )
		$out = round($timeDiff / 3600).' timmar';
	elseif( $timeDiff < 30 * 3600 )
		$out = 'ungefär en dag';
	elseif( $timeDiff < 6 * 24 * 3600 )
		$out = round($timeDiff / (24 * 3600)).' dagar';
	elseif( $timeDiff < 29 * 24 * 3600 )
		$out = round($timeDiff / (7 * 24 * 3600)).' veckor';
	elseif( $timeDiff < 360 * 24 * 3600 )
		$out = round($timeDiff / (30 * 24 * 3600)).' m&aring;nader';
	else
		$out = round($timeDiff / (365 * 24 * 3600)).' &aring;r';
	
	$out .= $suffix;
	
	if($hover)
		$out = '<span class="date" title="'.date($hoverDateFormat, $timestamp).'">'.$out.'</span>';
	
	return $out;
}

function age($timestamp) {
	$diff = time( ) - $timestamp;
	$age = $diff / ( 3600 * 24 );
	$age = floor( round($age / 365, 1) * 10 ) / 10;
	return $age;
}

function __autoload( $class ) {
	$class = strtolower( $class );
	if( file_exists('classes/'.$class.'.class.php') )
		require_once('classes/'.$class.'.class.php');
	else
		require_once( 'lib/'.$class.'/'.$class.'.class.php' );
}


function skapaNuDatum( ) {
	extract( $GLOBALS );
	$Y = strftime( "%Y", time( ) );
	$M = strftime( "%m", time( ) );
	if( strlen( $M ) == 1 ) {
		$M = "0".$M;
	}
	$D = $day[time( )];
	if( strlen( $D ) == 1 ) {
		$D = "0".$D;
	}
	$function_ret = $Y."-".$M."-".$D;
	return $function_ret;
}

// Dom två följande funktionerna är stulna från FluxBB, http://fluxbb.org

//
// Make hyperlinks clickable
//
function do_clickable($text)
{
	$text = ' '.$text;

	$text = preg_replace('#([\s\(\)])(https?|ftp|news){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2://$3\')', $text);
	$text = preg_replace('#([\s\(\)])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2.$3\', \'$2.$3\')', $text);

	return substr($text, 1);
}

//
// Truncate URL if longer than 55 characters (add http:// or ftp:// if missing)
//
function handle_url_tag($url, $link = '')
{
	$full_url = str_replace(array(' ', '\'', '`', '"'), array('%20', '', '', ''), $url);
	if (strpos($url, 'www.') === 0)			// If it starts with www, we add http://
		$full_url = 'http://'.$full_url;
	else if (strpos($url, 'ftp.') === 0)	// Else if it starts with ftp, we add ftp://
		$full_url = 'ftp://'.$full_url;
	else if (!preg_match('#^([a-z0-9]{3,6})://#', $url, $bah)) 	// Else if it doesn't start with abcdef://, we add http://
		$full_url = 'http://'.$full_url;

	// Ok, not very pretty :-)
	$link = ($link == '' || $link == $url) ? ((strlen($url) > 55) ? substr($url, 0 , 39).' &hellip; '.substr($url, -10) : $url) : stripslashes($link);

	return '<a href="'.$full_url.'">'.$link.'</a>';
}


//Check and validate user input

function cq( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		//content = Server.HTMLEncode(content)

		$content = str_replace( "\r\n", "[br]", $content );
		$content = str_replace( "<br>", "[br]", $content );
		$content = str_replace( "<b>", "[b]", $content );
		$content = str_replace( "</b>", "[/b]", $content );
		htmlspecialchars( substr( $content, 0, 1 ) );
		$content = str_replace( ";", "&#59;", $content );
		$content = str_replace( ",", "&#44;", $content );
		$content = str_replace( "'", "&#39;", $content );
		$content = str_replace( "\"", "&#34;", $content );
		$content = str_replace( "<", "[", $content );
		$content = str_replace( ">", "]", $content );

		//Disabled to remove HTML-support in input
		//content= replace(content, "<", "&lt;")
		//content= replace(content, ">", "&gt;")
		//$function_ret=$content;
	}
	return $content;
}

function rqJS( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		//content = Server.HTMLEncode(content)

		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "\\'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );
		$content = str_replace( "\r\n", "<br>", $content );
		$content = str_replace( "[br]", "<br>", $content );
		$content = str_replace( "[b]", "<b>", $content );
		$content = str_replace( "[/b]", "</b>", $content );
		$content = str_replace( "\"", "", $content );

		//$function_ret=$content;
	}
	return $content;
}

//reverse user input

function rq( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );
		$content = str_replace( "\r\n", "<br>", $content );
		$content = str_replace( "<", "[", $content );
		$content = str_replace( "[br]", "<br>", $content );
		$content = str_replace( "[b]", "<b>", $content );
		$content = str_replace( "[/b]", "</b>", $content );
		$content = str_replace( "]", ">", $content );
		$content = str_replace( "[a ", "<a ", $content );
		$content = str_replace( "[/a>", "</a>", $content );
		$content = str_replace( "[3", "&lt;3", $content );
		$content = str_replace( ">.[", "&gt;.&lt;", $content );
		$content = do_clickable($content);
	}
	return $content;
}

//reverse user input in forms

function rqForm( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );

		//content= replace(content, vbCrlf, "<br>")

		$content = str_replace( "[br]", "\r\n", $content );

		//$function_ret=$content;
	}
	return $content;
}
// if(!ob_start("ob_gzhandler")) 
ob_start();

$conn = new MysqlConn();

if( $_SESSION['userid'] != "" ) {
	// print '<!-- online! -->';
	// $conn->execute("replace into seen (lastseen, userid) values (getdate(), ".$_SESSION['userid'].")"); // Ska bytas bort
	$conn->execute("update users set online = 1, lastseen = now() where userid = ".$_SESSION['userid']);
}

if( isset( $noredirect ) && $noredirect == 0 && $_SESSION['userid'] != "" ) {
	if( $_SESSION['usertype'] == 0 ) {
		header( "Location: "."inQueue.php" );
	}
	$sql = "select redirect from users where userid = ".$_SESSION['userid'];
	$redirect = $redirect_query = mysql_query(( $sql ), $conn );
	$redirect = mysql_fetch_array( $redirect_query );;
	if( $redirect['redirect'] != "" ) {
		header( "Location: ".$redirect['redirect'] );
	}
}

if( !isset( $dont_display_header ) || $dont_display_header === FALSE ) {
if( isset($_SESSION['alt_style']) && $_SESSION['alt_style'] == 1 || TRUE ) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
<?php /*	<link rel="stylesheet" href="/style.css" type="text/css"/> */ ?>
	<link rel="stylesheet" href="/alt_style/style.css?<?php echo filemtime('alt_style/style.css');?>" type="text/css"/>
<?php /*	<link rel="stylesheet" href="/calendar.css" type="text/css"/>
	<link rel="shortcut icon" href="images/icons/favicon.ico"/>
	<link rel="icon" type="image/ico" href="images/icons/favicon.ico"/> */ ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Expires" content="<?php echo time( );?>"/>
	<meta http-equiv="Pragma" content="no-cache"/>
</head>
<body>
	<div id="wrap">
<div id="header-wrap">
	<div id="header">
		<h1><span>Eldsj&auml;l.org</span></h1>
		<div id="navbar">
			<div id="menuItems">
				<a href="/main" title="Tillbaka till startsida med nyheter och statistik">Start</a>
				<a href="/forum" title="Diskutera, fundera och spekulera fritt med andra eldsj&auml;lar *inl&auml;gg kr&auml;ver medlemskap*">Forum</a>
				<a href="/calendar" title="Se vad som händer runtomkring i världen!">Kalender</a>
				<a href="/people" title="H&auml;r finns alla v&aring;ra medlemmar!">Medlemmar</a>
				<a href="/gallery" title="Underbara bilder med anknytning till alternativkonst fr&aring;n v&aring;ra medlemmar *uppladdning kr&auml;ver medlemskap*">Galleri</a>
				<a href="http://www.cby.se/" title="Camp Burn Yourselfs egna sida!" target="_blank">C.B.Y</a>
				<a href="/board" title="Information om f&ouml;reningen">F&ouml;reningen</a>
			</div>
			<form id="quicksearch" action = "/people/search" method = "get"> 
				<div>
				<input type = "text" class = "formButton" name = "query" id = "quicksearch-username"/> 
				<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
				</div>
			</form>	
				<?php if( isset($_SESSION['userid']) && isset( $_SESSION['username'] ) && $_SESSION['username'] != "" ) { 
				//print $_SESSION['username']; 
			} else { 
				//print "Inte inloggad!"; 
			} ?>
			<div class="clear"> </div>
		</div>
	</div>
</div>
<div id="content-wrap">
	<table border="0" cellpadding="0" cellspacing="0" width="732" id="content">
<?php	
} else { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
<link rel="stylesheet" href="/style.css" TYPE="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<meta name="Expires" content="<?php echo time( );?>">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<Script type="text/javascript" language="javascript">
function openWindow(windowName,url)
{
window.open(url, windowName, 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=auto,resizable=yes,directories=no,location=no,left=0,top=0,width=800,height=600');
}
</script>
<script type="text/javascript" src="overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<br><div align="center">
<table border="0" cellpadding="0" cellspacing="0" width="732" ID="Table1">
<tr>
<td height="148" valign="top"><img src="images/logo.gif" width="125" height="115"><br><br>
<?php if( isset($_SESSION['userid']) && isset( $_SESSION['username'] ) && $_SESSION['username'] != "" ) { 
		print $_SESSION['username']; 
	} else { print "Inte inloggad!"; } ?>
</td>
<td colspan="2" width="598" height="147" valign="top">
	<img src="images/top.gif" width="601" height="118">
	<br><nobr><a href="main.php"><img src="images/buttons/button_1_start.gif" border="0" alt="Tillbaka till startsida med nyheter och statistik"></a><a href="forum.php"><img src="images/buttons/button_2_forum.gif" border="0" alt="Diskutera, fundera och spekulera fritt med andra eldsjälar *inlägg kräver medlemskap*"></a><a href="members.php"><img src="images/buttons/button_3_members.gif" border="0" alt="Här finns alla våra medlemmar!"></a><a href="gallery.php"><img src="images/buttons/button_4_gallery.gif" border="0" alt="Underbara bilder med anknytning till alternativkonst från våra medlemmar *uppladdning kräver medlemskap*"></a><a class=a2 href="http://www.cby.se/" target="_blank"><img src="images/buttons/button_6_cby.gif" border="0" alt="Camp Burn Yourselfs egna sida!"></a><a href="board.php"><img src="images/buttons/button_8_club.gif" border="0" alt="Information om f&ouml;reningen"></a><img src="images/buttons/button_blank.gif" border="0" height="26" width="198">
<?php /* <a href="http://mail.eldsjal.org">
		<img src="images/buttons/button_7_email.gif" border="0" alt="Här hittar du din epostlåda om du är medlem! *kräver medlemskap*">
	</a> */ ?>	<?php /* <a href="links.php">
		<img src="images/buttons/button_5_links.gif" border="0" alt="Bibliotek av länkar till matnyttiga sajter">
	</a> */ ?>
	<?php /* <a href="contact.php">
		<img src="images/buttons/button_9_contact.gif" border="0" alt="Kontakta administratören av eldsjal.org">
	</a> */ ?></nobr></td>
</tr>
<?php
	}
}?>
