<?php ob_start( );

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

// CLEAR THEM LOGINS THAT HAS INCORRECTLY LOGGED OUT

$sql = "select userid, lastlogin from users where online = 1 order by lastlogin desc";
$dbSet = $dbSet_query = mysql_query(( $sql ), $conn );
$dbSet = mysql_fetch_array( $dbSet_query );;
while( !( $dbSet == 0 ) ) {
	$logintime = $dateDiff['h'][$dbSet['lastlogin']][time( )];
	if( $loginTime > 3 ) {
		$sql = "update users set online = 0 where userid = ".$dbset['userid'];
		mysql_query(( $sql ), $conn );
	}
	$dbSet = mysql_fetch_array( $dbSet_query );
}
$sql = "select count(userid) as loggedin from users where online = 1";
$dbSet = $dbSet_query = mysql_query(( $sql ), $conn );
$dbSet = mysql_fetch_array( $dbSet_query );;
$application->Lock;
$application['loggedincount'] = $dbSet['loggedin'];
$application->UnLock;
$dbSet = null;
$conn = null;
?>
