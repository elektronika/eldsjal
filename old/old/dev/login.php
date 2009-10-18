<?php
session_start( );








$dont_display_header = TRUE;
require_once( 'header.php' );

ob_start( );
if( !isset( $_POST['username'] ) || empty( $_POST['username'] ) ) 
	header( "Location: "."main.php?message=Inget anv&auml;ndarnamn angett" );
	
$username = cq( $_POST['username'] );
$password = cq( $_POST['password'] );

$sql = "select * from users where username = '".$username."' and password = '".$password."'";

$login = $conn->execute( $sql );

if( !$login ) {
	header( "Location: "."main.php?message=".urlencode('Fel användarnamn eller lösenord!')."&username=".$username );
	exit();
}
$_SESSION['userid'] = $login['userid'];
$_SESSION['usertype'] = $login['usertype'];
$_SESSION['username'] = $login['username'];

$sql = "delete from pendingdelete where userid = ".$_SESSION['userid'];
$conn->execute( $sql );
$sql = "insert into loginhistory (userid, username, logintime, ip) values (".$_SESSION['userid'].",'".$_SESSION['username']."', getdate(), '".$_server['remote_addr']."')";
$conn->execute( $sql );

$sql = "update users set online = 1, lastlogin = getdate() where userid = ".$_SESSION['userid'];
$conn->execute( $sql );

$sql = "insert into seen (userid, lastseen) values (".$_SESSION['userid'].", getdate())";
$conn->execute( $sql );

// BOARD MEMBER
$sql = "select userid from board where rights = '10' and userid = ".$_SESSION['userid'];
$board = $conn->execute( $sql );
$_SESSION['boardmember'] = 0;
if( $board != 0 ) 
	$_SESSION['boardmember'] = 1;

//EVENT USER
$sql = "select userid from board where rights = '3' and userid = ".$_SESSION['userid'];
$myeventuser = $conn->execute( $sql );
$_SESSION['eventmember'] = 0;
if( $myeventuser != 0 ) {
	$_SESSION['eventmember'] = 1;
}

//INTERNATIONELLA USER
$sql = "select userid from board where rights = '4' and userid = ".$_SESSION['userid'];
$myintuser = $conn->execute( $sql );
$_SESSION['intmember'] = 0;
if( $myintuser != 0 ) 
	$_SESSION['intmember'] = 1;

//Elektronika user
$sql = "select userid from board where rights = '100' and userid = ".$_SESSION['userid'];
$elekuser = $conn->execute( $sql );
if( $elekuser != 0 ) {
	$_SESSION['intmember'] = 1;
	$_SESSION['boardmember'] = 1;
	$_SESSION['eventmember'] = 1;
}

if( $_POST['cookie'] == 1 ) {
	setcookie( "eldsjalUsername", $_SESSION['username'], 0, "", "", 0 );
} else {
	// Unsupported: Response.Cookie. expires = now ( )
}

if( !empty( $login['redirect'] ) ) {
	header( "Location: ".$login['redirect'] );
}

//Check f&ouml;r medlemskapsgodk&auml;nnande
//if session("userid") = 5122 then

$sql = "select * from user_years where userid = '".$_SESSION['userid']."' and year = '".date( 'y' )."'";
$user_year = $conn->execute( $sql );

//$useryear=$useryear_query=mysql_query(($sql),$conn);
//$useryear=mysql_fetch_array($useryear_query);

if(( $user_year == 0 ) ) {
	$sql = "update users set redirect = 'approve.php' where userid = '".$_SESSION['userid']."'";
	$conn->execute( $sql );

	//mysql_query(($sql),$conn);

	header( "Location: "."approve.php" );
}

//end if
//response.Redirect("userPresentation.php?userid=" & session("userid"))

header( "Location: "."main.php" );
$conn->close( );
?>
	</body>
</html>

