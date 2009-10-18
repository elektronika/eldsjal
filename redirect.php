<?php ob_start( );
$dont_display_header = TRUE;

//response.Expires = 10
// $Conn is of type "adodb.connection"
/*$a2p_connstr=$Application['eldsjaldb'];
$a2p_uid=strstr($a2p_connstr,'uid');
$a2p_uid=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$a2p_pwd=strstr($a2p_connstr,'pwd');
$a2p_pwd=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$a2p_database=strstr($a2p_connstr,'dsn');
$a2p_database=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$Conn=mysql_connect("localhost",$a2p_uid,$a2p_pwd);
mysql_select_db($a2p_database,$Conn);*/

require_once( 'topInclude.php' );
if( !isset( $_GET['linkid'] ) || $_GET['linkid'] == "" ) {
	header( "Location: "."links.php?message=Ingen l&auml;nk angedd..." );
}
$sql = "select url, clicks from links where linksid = ".intval( $_GET['linkid'] );
$url = $conn->execute( $sql );;
$clicks = $url['clicks'] + 1;
$sql = "update links set clicks = ".$clicks." where linksid = ".intval( $_GET['linkid'] );
$conn->execute( $sql );
header( "Location: ".$url['url'] );
?>
