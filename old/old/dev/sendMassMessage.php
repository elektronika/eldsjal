<?php
session_start( );






require_once( 'header.php' );

if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_SESSION['usertype'] < $application['useradmin'] ) {
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
	//Alla medlemmar
	//SQL = "Select userid, userName FROM users"
	//Salzas specialare
	//SQL = "select users.username, users.userid from messages, users where messageTopic = 'Tjoho! kalas! 22/4!' and messages.userid = users.userid order by username"
	//sql = "select joinActivity.userid, users.userName from joinActivity INNER JOIN users ON joinActivity.userid = users.userid WHERE joinActivity.eventID = 265"
	//SQL = "SELECT userid, userName FROM users WHERE userType >=4"

	$users = $conn->execute( $sql );
	$x = 0;
	$userss = $users;
	foreach( $userss as $users ) {
		//SQL = "select users.userName, users.userid FROM cbyMember INNER JOIN members ON cbyMember.memberID = members.memberID INNER JOIN users ON members.userid = users.userid WHERE users.userid = " & users("userid")
		//SET valid = conn.execute(sql)

		$x = $x + 1;

		//if valid.eof then

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
		
		<form action="sendmassmessage.php?mode=send" method="post">
		<input class="inputBorder" name="topic" type="text"/><br/>
		<textarea class="inputBorder" name="message" cols="50" rows="100" wrap id="Textarea1"></textarea><br/>
		Vidare
		<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
		</form>

		</td>
	</tr>
<?php require_once( 'footer.php' );?>
