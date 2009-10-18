<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
?>
<?php require_once( 'topInclude.php' );?>
<?php 
if( $_SESSION['usertype'] < 10 ) {
	header( "Location: "."main.php" );
}
if( $_GET['mode'] == "fixemail" && $_GET['username'] != "" ) {
	$sql = "update users set email = 'hugosson12@hotmail.com' where username = '".$_GET['username']."'";
	$conn->execute( $sql );
	print "Klar!";
}
else {
	print "Ingen tj&auml;nst beg&auml;rd!";
}
?>
