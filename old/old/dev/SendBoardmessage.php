<?php
session_start( );






require_once( 'header.php' );

if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['boardmember'] != 1 ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );?>
		</div>
		</td>
<?php 
if( $_GET['mode'] == "send" ) {
	//SQL = "SELECT userid FROM users WHERE city = 178"
	//SQL = "SELECT userid,userName FROM users WHERE register_date > '2003-05-14'"
	// K&auml;rngrupp 1
	//SQL = "select userid, username FROM users where username = 'kiwi' or username = 'at' or username = 'arvo' or username = 'serpen' or username = 'akroman' or username = 'nisse&agnes' or username = 'annaeva' or username = 'chesterfield' or username = 'm&aring;ndotter' or userName = 'zeetee' or userName = 'glemme'"
	//Alla medlemmar

	$sql = "select users.userid, users.username from users where userid in (select userid from board where rights = '10' and userid <> ".$_SESSION['userid'].")";
	$users = $conn->execute( $sql );
	$userss = $users;
	foreach( $userss as $users ) {
		//SQL = "INSERT INTO messages (messageTopic, message, readMessage, messageDate, messageFrom, userid) VALUES ('" & request.Form("topic") & "', '" & request.Form("message") & "', 0, '" & now() & "', " & session("userid") & ", " & users("userid") & ")"
		//SQL = "UPDATE systemmessages SET topic = '" & request.Form("topic") & "', message= '" & request.Form("message") & "', sender = 'Christian [Kanzie] Nilsson - eldsj&auml;l Crew' WHERE systemMessageid = 1"

		$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('".cq( $_POST['topic'] )."   *styrelsepost*"."', '".cq( $_POST['message'] )."', 0, getdate(), ".$_SESSION['userid'].", ".$users['userid'].")";

		//response.end

		$pumpit = $conn->execute( $sql );
		print "Meddelande inf&ouml;rt i ".$users['username']."'s inkorg<br/>";

		//    $users->moveNext;
	}

	//SQL = "INSERT INTO messages (messageTopic, message, readMessage, messageDate, messageFrom, userid) VALUES ('" & CQ(request.Form("topic")) & "', '" & CQ(request.Form("message")) & "', 0, '" & now() & "', " & session("userid") & ", 69)"
	//SET pumpit = conn.execute(SQL)
	//response.Write("Meddelande inf&ouml;rt i kanzie's inkorg<br/>")
	//response.Redirect("messages.php?userid=" & session("userid"))
}
?>
		<td width="600" height="300">
		
		<form action="sendBoardmessage.php?mode=send" method="post">
		<input class="inputBorder" name="topic" type="text"/><br/>
		<textarea class="inputBorder" name="message" cols="50" rows="30" wrap id="Textarea1"></textarea><br/>
		Vidare
		<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
		</form>

		</td>
	</tr>
<?php require_once( 'footer.php' );?>
