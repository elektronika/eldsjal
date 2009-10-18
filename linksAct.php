<?php
  session_start( );
session_register( "userid_session" );
session_register( "userid_session" );
session_register( "userType_session" );
?>
<?php 
ob_start( );

//response.Expires = 10
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

// illegal entry

if( $_SESSION['userid'] == "" ) {
	header( "Location: "."links.php?message=Du &auml;r inte inloggad, s&aring; d&aring; f&aring;r du inte g&ouml;ra n&aring;tt kul!" );
}

//Check and validate user input

function cq( $content ) {
	extract( $GLOBALS );

	//content = Server.HTMLEncode(content)

	$content = str_replace( "\r\n", "[br]", $content );
	$content = str_replace( "<br>", "[br]", $content );
	htmlspecialchars( substr( $content, 0, 1 ) )$content = str_replace( ";", "&#59;", $content );
	$content = str_replace( ",", "&#44;", $content );
	$content = str_replace( "'", "&#39;", $content );
	$content = str_replace( "\"", "&#34;", $content );
	$content = str_replace( "<", "[", $content );
	$content = str_replace( ">", "]", $content );

	//Disabled to remove HTML-support in input
	//content= replace(content, "<", "&lt;")
	//content= replace(content, ">", "&gt;")

	$function_ret = $content;
	return $function_ret;
}

//reverse user input

function rq( $content ) {
	extract( $GLOBALS );
	$content = str_replace( "&#59;", ";", $content );
	$content = str_replace( "&#44;", ",", $content );
	$content = str_replace( "&#39;", "'", $content );
	$content = str_replace( "&#34;", "\"", $content );
	$content = str_replace( "&lt;", "<", $content );
	$content = str_replace( "&gt;", ">", $content );
	$content = str_replace( "\r\n", "<br>", $content );
	$content = str_replace( "[br]", "<br>", $content );
	$function_ret = $content;
	return $function_ret;
}
if( $_GET['mode'] == "addLink" ) {
	$URLDesc = CQ( $_POST['urldesc'] );
	$URL = CQ( $_POST['url'] );
	$sql = "insert into links (url, urldesc, posterid, regdate,clicks, categoryid) values ('".$url."', '".$urldesc."', ".$_SESSION['userid'].", getdate(), 0, ".intval( $_POST['categoryid'] ).")";
	mysql_query(( $sql ), $conn );
	$message = "L&auml;nken ".$URL." &auml;r nu intjoffad";
	header( "Location: "."links.php?message=".$message );
}
elseif( $_GET['mode'] == "editLink" ) {
	if( $_GET['linkid'] == "" ) {
		header( "Location: "."links.php?message=L&auml;nken finns inte!" );
	}
	if( $_SESSION['usertype'] < $application['linksadmin'] ) {
		$sql = "select posterid from links where linksid = ".intval( $_GET['linkid'] );
		$result = $result_query = mysql_query(( $sql ), $conn );
		$result = mysql_fetch_array( $result_query );;
		if(( $result == 0 ) ) {
			header( "Location: "."links.php?message=Du &auml;r varken moderator eller &auml;gare till denna l&auml;nk, d&auml;rf&ouml;r kan du inte ta bort den...tji fick du!!" );
		}
	}
	$sql = "update links set url = '".cq( $_POST['url'] )."', urldesc= '".cq( $_POST['urldesc'] )."', categoryid = ".$_POST['categoryid']." where linksid = ".intval( $_GET['linkid'] );
	mysql_query(( $sql ), $conn );
	header( "Location: "."links.php?message=L&auml;nken uppdaterad!" );
}
elseif( $_GET['mode'] == "deleteLink" ) {
	if( $_GET['linkid'] == "" ) {
		header( "Location: "."links.php?message=L&auml;nken finns inte!" );
	}
	if( $_SESSION['usertype'] < $application['linksadmin'] ) {
		$sql = "select posterid from links where linksid = ".intval( $_GET['linkid'] );
		$result = $result_query = mysql_query(( $sql ), $conn );
		$result = mysql_fetch_array( $result_query );;
		if(( $result == 0 ) ) {
			header( "Location: "."links.php?message=Du &auml;r varken moderator eller &auml;gare till denna l&auml;nk, d&auml;rf&ouml;r kan du inte ta bort den...tji fick du!!" );
		}
	}

	//remove post

	$sql = "delete from links where linksid = ".intval( $_GET['linkid'] );
	mysql_query(( $sql ), $conn );
	header( "Location: "."links.php?message=L&auml;nken borttagen!" );
}
else {
	header( "Location: "."links.php?message=Nu halkade du snett, b&ouml;rja om!" );
}
?>
