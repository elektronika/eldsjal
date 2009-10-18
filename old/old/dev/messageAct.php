<?php
session_start( );


$dont_display_header = TRUE;
require_once( 'header.php' );


//Check and validate user input
/*function cq($content)
{
extract($GLOBALS);

//content = Server.HTMLEncode(content)
$content=str_replace("\r\n","[br]",$content);
$content=str_replace("<br/>","[br]",$content);
htmlspecialchars(substr($content,0,1))
$content=str_replace(";","&#59;",$content);
$content=str_replace(",","&#44;",$content);
$content=str_replace("'","&#39;",$content);
$content=str_replace("\"","&#34;",$content);
$content=str_replace("<","[",$content);
$content=str_replace(">","]",$content);
$function_ret=$content;
return $function_ret;
} 
*/

if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	if( $_POST['message'] != "" ) {
		print "Du &auml;r inte inloggad och f&ouml;rs&ouml;kte skicka detta meddelande. V&auml;nligen kopiera det, logga in och skriv igen!<br/><br/>";
		print "<b>".$_POST['messagetopic']."</b><br/>".$_POST['message'];
		exit( );
	}
	else {
		header( "Location: "."userPresentation.php?userid=".$_POST['userid']."&Message=Du &auml;r inte inloggad" );
	}
}

/*
// $Conn is of type "adodb.connection"
$a2p_connstr=$Application['eldsjaldb'];
$a2p_uid=strstr($a2p_connstr,'uid');
$a2p_uid=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$a2p_pwd=strstr($a2p_connstr,'pwd');
$a2p_pwd=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$a2p_database=strstr($a2p_connstr,'dsn');
$a2p_database=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$Conn=mysql_connect("localhost",$a2p_uid,$a2p_pwd);
mysql_select_db($a2p_database,$Conn);
*/

if( $_GET['mode'] == "delete" ) {
	if( $_GET['messageID'] == "" ) {
		header( "Location: "."messages.php?message=Du försökte ta bort ett meddelande som inte finns!" );
	}
	$sql = "select messageid from messages where messageid = ".intval( $_GET['messageID'] )." and userid = ".$_SESSION['userid'];
	$validate = $conn->execute( $sql );

	//$validate=mysql_fetch_array($validate_query);;
	if(( $validate == 0 ) ) {
		header( "Location: "."messages.php?Message=Du är inte mottagare av detta meddelande, uppgiften avbruten (skurk)!" );
	}
	$sql = "delete from messages where messageid = ".intval( $_GET['messageID'] );
	$conn->execute( $sql );
	header( "Location: "."messages.php?Message=Meddelandet borttaget!" );
}
elseif( $_GET['mode'] == "writeselected" ) {
	if( $_SESSION['userid'] == "" ) {
		header( "Location: "."main.php?Message=Du &auml;r inte inloggad!" );
	}
	if(( strpos( $_POST['mottagare'], "," ) ? strpos( $_POST['mottagare'], "," ) + 1 : 0 ) > 0 ) {
		$mottagarArray = explode( ",", $_POST['mottagare'] );
	}
	elseif( $_POST['mottagare'] > 0 ) {
		$mottagarArray[0] = $_POST['mottagare'];
	}
	else {
		header( "Location: "."messages.php?Message=Ingen mottagare angedd" );
	}
	$formatText = CQ( $_POST['message'] );
	$formatTopic = CQ( $_POST['messagetopic'] );
	for( $i = 0; $i <= count( $mottagarArray ); $i = $i + 1 ) {
		$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('".cq( $_POST['messagetopic'] )."', '".$formattext."', 0, getdate(), ".$_SESSION['userid'].", ".$mottagararray[$i].")";

		//response.Write("<br/>" & SQL)

		$conn->execute( $sql );
	}
	$sql = "select username from users where ";
	for( $i = 0; $i <= count( $mottagarArray ); $i = $i + 1 ) {
		if( $i > 0 ) {
			$sql = $sql." OR ";
		}
		$sql = $sql."userid = ".$mottagarArray[$i];
	}
	$receipent = $conn->execute( $sql );

	//$receipent=mysql_fetch_array($receipent_query);;
	$reciepents = $receipent['username'];

	//$receipent=mysql_fetch_array($receipent_query);

	if( !( $receipent == 0 ) ) {
		while( !( $receipent == 0 ) ) {
			$reciepents = $reciepents.", ".$receipent['username'];

			//$receipent=mysql_fetch_array($receipent_query);
		}
	}
	$message = "Meddelande s&auml;nt till: ".$reciepents;
	header( "Location: "."messages.php?message=".$message );

	//mysql_close($conn);
}
else {
	if( $_POST['userid'] == "" ) {
		if( $_SESSION['userid'] != "" ) {
			header( "Location: "."messages.php?Message=Ingen mottagare angedd" );
		}
		header( "Location: "."main.php?Message=Du &auml;r inte inloggad!" );
	}
	$formatText = CQ( $_POST['message'] );
	$formatTopic = CQ( $_POST['messageTopic'] );
	$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('".$formatTopic."', '".$formatText."', 0, getdate(), ".$_SESSION['userid'].", ".$_POST['userid'].")";
	$pumpit = $conn->execute( $sql );

	//$pumpit=mysql_fetch_array($pumpit_query);
	//;  $pumpit  echo "";
	//  mysql_close($conn);
}
header( "Location: "."userPresentation.php?userid=".$_POST['userid'] );
?>
