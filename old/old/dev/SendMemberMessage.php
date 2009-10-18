<?php
session_start( );







require_once( 'header.php' );

if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}
if( $_SESSION['boardmember'] != 1 ) {
	header( "Location: "."Den h&auml;r funktinen g&auml;ller bara styrelsemedlemmar!" );
}?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );?>
		</div>
		</td>
<?php 
if( $_GET['mode'] == "send" ) {
	$sql = "select members.userid, users.username from members inner join users on members.userid = users.userid";
	$users = $conn->execute( $sql );
	$x = 0;
	$userss = $users;
	foreach( $userss as $users ) {
		$x = $x + 1;
		$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('".cq( $_POST['topic'] )."', '".cq( $_POST['message'] )."', 0, getdate(), ".$_SESSION['userid'].", ".$users['userid'].")";

		//response.end

		$pumpit = $conn->execute( $sql );
		print $x.": Meddelande inf&ouml;rt i ".$users['username']."'s inkorg<br/>";

		//end if
		//    $users->moveNext;
	}
}
?>
		<td width="600" height="300">
		
		<form action="sendmembermessage.php?mode=send" method="post">
		<input class="inputBorder" name="topic" type="text"/><br/>
		<textarea class="inputBorder" name="message" cols="50" rows="100" wrap id="Textarea1"></textarea><br/>
		Vidare
		<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
		</form>

		</td>
	</tr>
<?php require_once( 'footer.php' );?>
