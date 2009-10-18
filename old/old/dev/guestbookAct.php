<?php
session_start( );





ob_start( );
$dont_display_header = TRUE;
require_once( 'header.php' );

if( $_SESSION['userid'] == "" ) {
	header( "Location: "."guestbook.php?message=".urlencode('Du har inte skrivr&auml;ttigheter utan att vara inloggad')."&userid=".$_GET['userid'] );
	exit();
}

if( $_GET['mode'] == "edit" ) {
	$sql = "update guestbook set message = '".cq( $_POST['guestbookEntry'] )."', unread = 1, date = getdate() where guestbookid = '".intval( $_POST['guestbookid'] )."'";
	$guestBook = $conn->execute( $sql );

	//$guestBook=mysql_fetch_array($guestBook_query);;
	$message = urlencode("Gästboksmeddelandet är nu ändrat!");
	header( "Location: "."guestbook.php?userid=".$_GET['userid']."&message=".$message );
}
elseif( $_GET['mode'] == "addEntry" ) {
	if( $_POST['redirect'] != "" ) {
		$formattext = "<b>Kommentar till bilden ".CQ( $_POST['imagename'] ).": </b><br/>".CQ( $_POST['guestbookentry'] );
	}
	else {
		$formattext = CQ( $_POST['guestbookentry'] );
	}
	$sql = "insert into guestbook (fromuserid, touserid, message, date, unread) values ('".$_SESSION['userid']."', '".$_POST['touserid']."', '".$formattext."', getdate(), 1)";
	$result = $conn->execute( $sql );

	//$result=mysql_fetch_array($result_query);;
	$sql = "select username from users where userid = ".intval( $_POST['touserid'] );
	$gbName = $conn->execute( $sql );

	//$gbName=mysql_fetch_array($gbName_query);;
	$sql = "replace into history (action, userid, nick, message, [date], security) values ('guestbookadd',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." skriver ett g&auml;stboksinl&auml;gg till ".$gbname['username']."', getdate(), 0)";
	$result = $conn->execute( $sql );

	//$result=mysql_fetch_array($result_query);;
	$result = null;
	if( $_POST['redirect'] != "" ) {
		header( "Location: "."viewPicture.php?message=".urlencode('Kommentaren införd')."&imageid=".$_POST['redirect'] );
	}
	else {
		header( "Location: "."guestbook.php?userid=".$_POST['touserid'] );
	}
}
elseif( $_GET['mode'] == "delete" ) {
	if( $_GET['guestbookid'] == "" ) {
		header( "Location: "."guestbook.php?message=".urlencode('Du har inte angett något meddelande att ta bort!')."&userid=".$_SESSION['userid'] );
	}
	$sql = "select * from guestbook where guestbookid = '".intval( $_GET['guestbookid'] )."'";
	$guestBook = $conn->execute( $sql );

	// //$guestBook=mysql_fetch_array($guestBook_query);;
	// $i = 0;
	// while( !( $guestBook == 0 ) ) {
	// 	$i = $i + 1;
	// 
	// 	//$guestBook=mysql_fetch_array($guestBook_query);
	// }
	if( !$guestBook ) {
		header( "Location: "."guestbook.php?message=".urlencode('Det finns inget gästboksmeddelande enligt vad du angett!')."&userid=".$_GET['userid'] );
	}
	$sql = "delete from guestbook where guestbookid = '".intval( $_GET['guestbookid'] )."'";
	$guestBook = $conn->execute( $sql );

	//$guestBook=mysql_fetch_array($guestBook_query);;
	$message = urlencode("Gästboksmeddelandet är nu borttaget!");
	header( "Location: "."guestbook.php?userid=".$_GET['userid']."&message=".$message );

	//Logger
	$sql = "replace into history (action, userid, nick, message, [date], security) values ('guestbookdelete',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." tar bort ett g&auml;stboksinl&auml;gg', getdate(), 0)";
	$conn->execute( $sql );

	//$guestBook=null;
}
else {
	header( "Location: "."guestbook.php?userid=".$_SESSION['userid']."message=".urlencode('Nu halkade du snett, börja om!') );
}
?>
