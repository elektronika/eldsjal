<?php
  session_start( );
session_register( "userid_session" );
?>
<?php
// illegal entry

if( $_SESSION['userid'] == "" ) {
	header( "Location: "."forum.php?message=Du har inte skrivr&auml;ttigheter utan att vara inloggad" );
}

function CQ( $inquery ) {
	extract( $GLOBALS );
	$tmp = $inquery;
	$tmp = str_replace( ",", "&#44;", $tmp );
	$tmp = str_replace( "'", "&#39;", $tmp );
	$tmp = str_replace( "\"", "&#34;", $tmp );
	$tmp = str_replace( "\r\n", "<br>", $tmp );
	$function_ret = $tmp;
	return $function_ret;
}
if( $_GET['mode'] == "addEntry" ) {
	$message = CQ( $_POST['message'] );
	$topic = CQ( $_POST['topic'] );
	$sql = "insert into forumtopics (topic, posterid, topicdate) values ('".$message."', '".$topic."', ".$_SESSION['userid'].", getdate()); select scope_identity() as sid";
	$storeTopic = $conn->execute( $sql );

	//topicID ligger nu i storeTopic("sid") i form av randomSeed-identity {F32GFDSFDS43GFDWSG43}

	$sql = "insert into forummessages (message, topicid, posterid, messagedate) values ('".$message."', '".$storetopic['sid']."', ".$_SESSION['userid'].", getdate())";
	$storeMessage = $conn->execute( $sql );
	$message = "Tr&aring;den ".$topic." &auml;r nu registrerad";
	header( "Location: "."forum.php?threadid=".$storeTopic['sid']."&message=".$message );
}
elseif( $_GET['mode'] == "addReply" ) {
	if( $_GET['threadid'] == "" ) {
		header( "Location: "."forum.php?message=Du har inte angett n&aring;gon tr&aring;d att skriva i!" );
	}
	$sql = "insert into forummessages (message, topicid, posterid, messagedate) values ('".$message."', '".$_GET['threadid']."', ".$_SESSION['userid'].", getdate())";
	$storeMessage = $conn->execute( $sql );
	$message = "Tr&aring;den ".$topic." &auml;r nu registrerad";
	header( "Location: "."forum.php?threadid=".$storeTopic['sid']."&message=".$message );
}
elseif( $_GET['mode'] == "updateTopic" ) {
}
elseif( $_GET['mode'] == "updatePost" ) {
}
elseif( $_GET['mode'] == "deleteTopic" ) {
}
elseif( $_GET['mode'] == "deleteMessage" ) {
}
else {
	header( "Location: "."forum.php?message=Nu halkade du snett, b&ouml;rja om!" );
}
?>
