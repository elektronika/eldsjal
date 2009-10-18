<?php 
ob_start( );

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
print "Konverterar bilder...<BR>";
$sql = "select username,userid from users where hasimage = 1";
$pictures = $pictures_query = mysql_query(( $sql ), $conn );
$pictures = mysql_fetch_array( $pictures_query );;

// $picMan is of type "scripting.FileSystemObject"

while( !( $pictures == 0 ) ) {
	$userName = strtolower( $pictures['username'] );
	if( file_exists( $DOCUMENT_ROOT."images/userImages/".$userName.".jpg" ) && !file_exists( $DOCUMENT_ROOT."images/userImages/".$pictures['userid'].".jpg" ) ) {
		rename( $DOCUMENT_ROOT."images/userImages/".$userName.".jpg" );
		print "Konverterat ".$pictures['username'].".jpg till ".$pictures['userid'].".jpg<br>";
	}
	else {
		print "Filen ".$pictures['username'].".jpg finns inte - skulle ha varit ".$pictures['userid']."<br>";
	}
	if( file_exists( $DOCUMENT_ROOT."images/userImages/tn_".$userName.".jpg" ) && !file_exists( $DOCUMENT_ROOT."images/userImages/tn_".$pictures['userid'].".jpg" ) ) {
		rename( $DOCUMENT_ROOT."images/userImages/tn_".$userName.".jpg" );
		print "Konverterat tn_".$pictures['username'].".jpg till tn_".$pictures['userid'].".jpg<br>";
	}
	else {
		print "Filen tn_".$pictures['username'].".jpg finns inte - skulle ha varit ".$pictures['userid']."<br>";
	}
	$pictures = mysql_fetch_array( $pictures_query );
}
?>
