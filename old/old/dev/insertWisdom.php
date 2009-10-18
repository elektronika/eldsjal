<?php
session_start( );






require_once( 'header.php' );

if( isset( $_GET['message'] ) ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_SESSION['usertype'] < 1 ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );

if( isset( $_GET['mode'] ) && $_GET['mode'] == "save" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?message=Not logged in!" );
	}
	$sql = "insert into wisebox (wisdom, addeddate, addedbyid) values ('".cq( $_POST['message'] )."', getdate(), ".$_SESSION['userid'].")";
	$pumpit = $conn->execute( $sql );
	$pumpit = null;
	header( "Location: "."insertWisdom.php?message=Wisdom inserted" );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "update" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?message=Not logged in!" );
	}
	if( $_GET['id'] == "" ) {
		header( "Location: "."insertWisdom.php?message=No ID specified!" );
	}
	$sql = "update wisebox set wisdom = '".cq( $_POST['message'] )."', addeddate = getdate(), addedbyid = ".$_SESSION['userid']." where wiseboxid = ".intval( $_GET['id'] );
	$pumpit = $conn->execute( $sql );
	$pumpit = null;
	header( "Location: "."insertWisdom.php?message=Wisdom #".$_GET['id']." updated" );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "delete" ) {
	if( $_GET['id'] == "" ) {
		header( "Location: "."insertWisdom.php?message=No wisdomID specified" );
	}
	$sql = "delete from wisebox where wiseboxid = ".intval( $_GET['id'] );
	$conn->execute( $sql );
	header( "Location: "."insertWisdom.php?message=Wisdom deleted" );
}
print isset( $_GET['message'] ) ? $_GET['message'] : '';
?>
	
	<td width="200" height="300">
	<a href="insertWisdom.php" class="a2">New wisdom &raquo;</a><br/>
<?php if( isset( $_GET['id'] ) && $_GET['id'] != "" ) {
	$sql = "select wisebox.wisdom as wisdom, users.username as username, users.userid as userid from wisebox, users where wisebox.addedbyid = users.userid and wiseboxid = ".intval( $_GET['id'] );
	$result = $conn->execute( $sql );
	print "<form action=insertWisdom.php?mode=update&id=".$_GET['id']." method=post ID=Form1>";
	print "<textarea name=message class=inputBorder cols=25 rows=15 wrap ID=message>";
	if( $result ) {
		print RQForm( $result['wisdom'] );
		print "</textarea><br/>Inf&ouml;rd av: <a href=userPresentation.php?userid=".$result['userid']." class=a2>";
		print RQForm( $result['username'] );
		print "</a><br/>";
	}
	else {
		header( "Location: "."insertWisdom.php?message=No such ID exists" );
	}
	$result = null;
}
else {
	print "<form action=insertWisdom.php?mode=save method=post ID=Form1>";
	print "<textarea name=message class=inputBorder cols=25 rows=15 wrap ID=message>";
	print "</textarea><br/>";
}
?>
		Spara
		<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
		</form>

		</td>
		
		<td width="400">
		<table border=0>
<?php 
$sql = "select wisdom, wiseboxid from wisebox order by wiseboxid asc";
$wisdom = $conn->execute( $sql );
$i = 0;
$wisdoms = $wisdom;
foreach( $wisdoms as $wisdom ) {
	$cWisdom = substr( $wisdom['wisdom'], 0, 50 )."...";
	$i = $i + 1;
	print "<tr><td>".$i.":&nbsp;</td><td><a href=insertWisdom.php?id=".$wisdom['wiseboxid']." class=a3>".$cWisdom."</a></td><td><a href=insertWisdom.php?mode=delete&id=".$wisdom['wiseboxid']."><img src=images/icons/trashcan.gif border=0 alt=\"Delete wisdom\"></a></td></tr>";

	//  $wisdom->moveNext;
}
?>
		</table>
		</td>

	</tr>
<?php require_once( 'footer.php' );?>
