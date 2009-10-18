<?php
ini_set('display_errors', TRUE);
session_start();

require('config.php');
require('functions.php');

ob_start();

$conn = DB::mysql();

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

if(isset($_GET['dev']) && $_GET['dev'] == 'yesplease') { 
	DEV::get_dev();
	$devTemplate = new Smarty();
	$devTemplate->template_dir = '/var/www/eldsjal.org/Templates';
	$devTemplate->compile_dir = '/var/www/eldsjal.org/templates_c';
  	$devTemplate->register_function('time', 'smarty_function_time');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
	<link rel="stylesheet" href="alt_style/960.css" type="text/css"/>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<link rel="stylesheet" href="alt_style/style.css" type="text/css"/>
	<link rel="stylesheet" href="alt_style/dev.css" type="text/css"/>
	<link rel="stylesheet" href="calendar.css" typ="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Expires" content="<?php echo time( );?>"/>
	<meta http-equiv="Pragma" content="no-cache"/>
	<script type="text/javascript" src="/jquery.min.js"></script>
	<script type="text/javascript" src="/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
	<script type="text/javascript" src="/scripts.js"></script>	
</head>
<body>
	<div id="wrap">
<div id="header-wrap">
	<div id="header" class="container_16">
	<div class="grid_14 prefix_1">
		<h1><span>Eldsj&auml;l.org</span></h1>
		<div id="navbar">
			<div id="menuItems">
				<a href="main.php" title="Tillbaka till startsida med nyheter och statistik">Start</a>
				<a href="forum.php" title="Diskutera, fundera och spekulera fritt med andra eldsj&auml;lar *inl&auml;gg kr&auml;ver medlemskap*">Forum</a>
				<a href="members.php" title="H&auml;r finns alla v&aring;ra medlemmar!">Medlemmar</a>
				<a href="gallery.php" title="Underbara bilder med anknytning till alternativkonst fr&aring;n v&aring;ra medlemmar *uppladdning kr&auml;ver medlemskap*">Galleri</a>
				<a href="http://www.cby.se/" title="Camp Burn Yourselfs egna sida!" target="_blank">C.B.Y</a>
				<a href="board.php" title="Information om f&ouml;reningen">F&ouml;reningen</a>
			</div>
			<form id="quicksearch" action = "members.php?mode=listMembers" method = "post"> 
				<div>
				<input type = "text" class = "formButton" name = "username" id = "quicksearch-username"/> 
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
</div>
<?php } ?>