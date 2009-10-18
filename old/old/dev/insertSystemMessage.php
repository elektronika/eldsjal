<?php
session_start( );






require_once( 'header.php' );

if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_SESSION['userid'] != 69 ) {
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
	$sql = "insert into systemmessages (topic, message, sender, systemmessagename) values ('".cq( $_POST['topic'] )."', '".cq( $_POST['message'] )."', 'kanzie [eldsj&auml;l crew]', 'rules')";

	//response.Write(sql)
	//response.end

	$pumpit = $conn->execute( $sql );
	print "Meddelande inf&ouml;rt i systemMessages<br/>";
	exit( );
}
?>
	
	<td width="600" height="300">
		
		<form action="insertSystemMessage.php?mode=send" method="post" id="Form1">
		<input class="inputBorder" name="topic" type="text" id="Text1"/><br/>
		<textarea class="inputBorder" name="message" cols="50" rows="100" wrap id="Textarea1"></textarea><br/>
		Vidare
		<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
		</form>

		</td>
	</tr>
<?php require_once( 'footer.php' );?>
