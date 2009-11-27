<?php

ini_set('display_errors', TRUE);

session_register( "userid" );
session_register( "usertype" );
session_register( "username" );

require('config.php');
require('functions.php');

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
	<link rel="stylesheet" href="/style.css" type="text/css"/>
	<link rel="stylesheet" href="/alt_style/style.css?3" type="text/css"/>
	<link rel="stylesheet" href="/calendar.css" type="text/css"/>
<?php /*	<link rel="shortcut icon" href="images/icons/favicon.ico"/>
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
				<a href="main.php" title="Tillbaka till startsida med nyheter och statistik">Start</a>
				<a href="forum.php" title="Diskutera, fundera och spekulera fritt med andra eldsj&auml;lar *inl&auml;gg kr&auml;ver medlemskap*">Forum</a>
				<a href="members.php" title="H&auml;r finns alla v&aring;ra medlemmar!">Medlemmar</a>
				<a href="gallery.php" title="Underbara bilder med anknytning till alternativkonst fr&aring;n v&aring;ra medlemmar *uppladdning kr&auml;ver medlemskap*">Galleri</a>
				<a href="http://www.cby.se/" title="Camp Burn Yourselfs egna sida!" target="_blank">C.B.Y</a>
				<a href="board.php" title="Information om f&ouml;reningen">F&ouml;reningen</a>
				<a style="font-weight: bold" href="/betainfo/" title="Beta-versionen utav nya eldsjal.org">BETA</a>
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
