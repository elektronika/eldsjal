<?php
  session_start( );
session_register( "userType_session" );
session_register( "userid_session" );
?>
<?php ob_start( );

//response.Expires = 10

if( $_SESSION['usertype'] < $application['imageadmin'] ) {
	header( "Location: "."main.php?message=Du har inte r&auml;ttigheter f&ouml;r att godk&auml;nna bild!" );
}

// $Conn is of type "adodb.connection"

$a2p_connstr = $Application['eldsjaldb'];
$a2p_uid = strstr( $a2p_connstr, 'uid' );
$a2p_uid = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
$a2p_pwd = strstr( $a2p_connstr, 'pwd' );
$a2p_pwd = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
$a2p_database = strstr( $a2p_connstr, 'dsn' );
$a2p_database = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
$Conn = mysql_connect( "localhost", $a2p_uid, $a2p_pwd );
mysql_select_db( $a2p_database, $Conn );
if( $_GET['imageid'] == "" ) {
	header( "Location: "."main.php?message=Bilden finns inte" );
}
if( $_GET['mode'] == "approve" ) {
	$sql = "update images set approved = 1, approvedby = ".$_SESSION['userid']." where imageid = ".intval( $_GET['imageid'] );
	mysql_query(( $sql ), $conn );
	header( "Location: "."viewPicture.php?message=Bilden satt till godk&auml;nd!&imageid=".intval( $_GET['imageid'] ) );
}
elseif( $_GET['mode'] == "disapprove" ) {
	$sql = "update images set approved = 0, approvedby = ".$_SESSION['userid']." where imageid = ".intval( $_GET['imageid'] );
	mysql_query(( $sql ), $conn );
	header( "Location: "."viewPicture.php?message=Bilden satt till ej godk&auml;nd!&imageid=".intval( $_GET['imageid'] ) );
}
?>
