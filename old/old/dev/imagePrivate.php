<?php
session_start( );
ob_start( );

$dont_display_header = TRUE;
require('header.php');

if( $_SESSION['usertype'] < $application['imageadmin'] ) {
	header( "Location: "."main.php?message=Du har inte r&auml;ttigheter f&ouml;r att privatisera bild!" );
	exit();
}



if( $_GET['imageid'] == "" ) {
	header( "Location: "."main.php?message=Bilden finns inte" );
}
if( $_GET['mode'] == "private" ) {
	$sql = "update images set private = 1 where imageid = ".intval( $_GET['imageid'] );
	$conn->execute($sql);
	header( "Location: "."viewPicture.php?message=Bilden satt till privat!&imageid=".intval( $_GET['imageid'] ) );
}
elseif( $_GET['mode'] == "public" ) {
	$sql = "update images set private = 0 where imageid = ".intval( $_GET['imageid'] );
	$conn->execute($sql);
	header( "Location: "."viewPicture.php?message=Bilden satt till publik!&imageid=".intval( $_GET['imageid'] ) );
}
?>
