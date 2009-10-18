<?php
session_start( );






require_once( 'header.php' );

if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['usertype'] < $application['useradmin'] ) {
	header( "Location: "."main.php?message=Du har inte r&auml;ttigheter att g&ouml;ra detta!" );
}?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );?>
		</div>
		</td>
<?php 
if( $_GET['mode'] == "send" ) {
	//Alla medlemmar

	$sql = "select users.userid, users.username from users where userid in (select userid from users where usertype >= ".$application['useradmin'].")";
	$users = $conn->execute( $sql );
	$userss = $users;
	foreach( $userss as $users ) {
		$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('".cq( $_POST['topic'] )."   *fadderpost*"."', '".cq( $_POST['message'] )."', 0, getdate(), ".$_SESSION['userid'].", ".$users['userid'].")";

		//response.end

		$pumpit = $conn->execute( $sql );
		print "Meddelande inf&ouml;rt i ".$users['username']."'s inkorg<br/>";

		//    $users->moveNext;
	}
}
?>
		<td width="600" height="300">
		
		<form action="sendParentmessage.php?mode=send" method="post">
		<input class="inputBorder" name="topic" type="text"/><br/>
		<textarea class="inputBorder" name="message" cols="50" rows="30" wrap id="Textarea1"></textarea><br/>
		Vidare
		<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
		</form>

		</td>
	</tr>
<?php require_once( 'footer.php' );?>
