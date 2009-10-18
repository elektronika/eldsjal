<?php
session_start( );
ob_start( );

$dont_display_header = TRUE;
require('header.php');

if( $_SESSION['usertype'] < $application['imageadmin'] ) {
	header( "Location: "."main.php?message=Du har inte r&auml;ttigheter f&ouml;r att godk&auml;nna bild!" );
	exit();
}

if( $_GET['imageid'] == "" ) {
	header( "Location: "."main.php?message=Bilden finns inte" );
}
if( $_GET['mode'] == "approve" ) {
	$sql = "update images set approved = 1, approvedby = ".$_SESSION['userid']." where imageid = ".intval( $_GET['imageid'] );
	$conn->execute($sql);
	header( "Location: "."viewPicture.php?message=Bilden satt till godk&auml;nd!&imageid=".intval( $_GET['imageid'] ) );
}
elseif( $_GET['mode'] == "disapprove" ) {
	$sql = "update images set approved = 0, approvedby = ".$_SESSION['userid']." where imageid = ".intval( $_GET['imageid'] );
	$conn->execute($sql);
	header( "Location: "."viewPicture.php?message=Bilden satt till ej godk&auml;nd!&imageid=".intval( $_GET['imageid'] ) );
}
?>
