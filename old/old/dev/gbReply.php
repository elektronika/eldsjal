<?php
session_start( );






if( $_SESSION['userid'] == "" ) {
	?>
<script language="javascript">
window.self.close()
</script>
<?php
}
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
	header( "Location: "."guestbook.php?message=Du har inte skrivr&auml;ttigheter utan att vara inloggad&userid=".$_GET['userid'] );
}

//Check and validate user input

function cq( $content ) {
	extract( $GLOBALS );

	//content = Server.HTMLEncode(content)

	$content = str_replace( "\r\n", "[br]", $content );
	$content = str_replace( "<br/>", "[br]", $content );
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
?>
			<script language="javascript">
			<!--

			function CheckGB() {

			if (document.addGuestbook.guestbookEntry.value == '') {
			alert("Du m&aring;ste skriva n&aring;tt ju!");
			document.addGuestbook.guestbookEntry.focus();
			return false;
			}
			return true;
			}
			
			-->
			</script>
<?php 
if( $_GET['mode'] == "reply" ) {
	if( $_POST['touserid'] == "" ) {
		?>
<script language="javascript">
window.self.close()
</script>
<?php
	}
	$formatText = CQ( $_POST['guestbookentry'] );
	$sql = "insert into guestbook (fromuserid, touserid, message, date, unread) values ('".$_SESSION['userid']."', '".$_POST['touserid']."', '".$formatText."', getdate(), 1)";
	$gbName = $conn->execute($sql);
	// $result = $result_query = mysql_query(( $sql ), $conn );
	// 	$result = mysql_fetch_array( $result_query );;
	$sql = "select username from users where userid = ".intval( $_POST['touserid'] );
	$gbName = $conn->execute($sql);
	// $gbName = mysql_fetch_array( $gbName_query );;

	//Logger
	$sql = "replace into history (action, userid, nick, message, [date], security) values ('guestbookadd',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." skriver ett g&auml;stboksinl&auml;gg till ".$gbname['username']."', getdate(), 0)";
	$result = $conn->execute($sql);
	// $result = mysql_fetch_array( $result_query );;
	$result = null;
	?>
<script language="javascript">
window.self.close()
</script>
<?php
}
else {
	if( $_SESSION['userid'] != intval( $_GET['userid'] ) ) {
		print "<form  name=\"addGuestbook\" action=\"gbReply.php?mode=reply&userid=\"".$_GET['userid']." method=\"post\" ID=\"addGuestbook\" onSubmit=\"return CheckGB();\">";
		?>

<textarea class="addGb" name="guestbookentry" id="guestbookEntry" cols="16" rows="10"></textarea>
Skicka
<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
<input type="hidden" name="touserid" value="<?php     echo $_GET['userid'];?>" id="Hidden1" id="Hidden2"/>
<input type="hidden" name="toUserName" value="<?php     echo $_GET['username'];?>" id="Hidden3" id="Hidden1"/>
</form>
<?php
	}
	else {
		print "Du ska ju inte skriva till dig sj&auml;lv heller!?";
	}
}
?>

