<?php
$dont_display_header = TRUE;
require_once( 'topInclude.php' );

//session_start();

session_register( "userid_session" );
session_register( "userid_session" );
?>
<?php ob_start( );

print "Loggar ut!!!";
// if( $_SESSION['userid'] != "" ) {
	$sql = "update users set online = 0 where userid = ".$_SESSION['userid'];
	$results = $conn->execute( $sql );;
	$sql = "delete from seen where userid = ".$_SESSION['userid'];
	$conn->execute( $sql );

	// Initialize the session.
	// If you are using session_name("something"), don't forget it now!

	session_start( );

	// Unset all of the session variables.

	$_SESSION = array( );

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!

	if( isset( $_COOKIE[session_name( )] ) ) {
		setcookie( session_name( ), '', time( ) - 42000, '/' );
	}

	// Finally, destroy the session.

	session_destroy( );
// }
if( $_GET['redirect'] == "" ) {
	header( "Location: "."/main?message=Utloggad och klar!" );
}
else {
	header( "Location: ".$_GET['redirect'] );
}

//mysql_close($conn);

?>
