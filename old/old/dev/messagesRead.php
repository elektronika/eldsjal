<?php
session_start( );






require_once( 'header.php' );?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );?>
		</div>
		</td>
	
		
		<td width="600" height="190">
<?php if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_SESSION['userid'] != intval( $_GET['userid'] ) ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
	$sql = "select messages.messagedate, messages.messagetopic, messages.messageid, messages.readmessage, messages.messagefrom, users.username from messages inner join users on messages.messagefrom = users.userid where messages.userid = ".$_SESSION['userid']." order by messagedate desc";
	$dbMessages = $conn->execute( $sql );
	$iCount = 0;
	print "<table marginwidth=0 marginheight=0 border=0><tr><td>&nbsp;</td><td width=150>Fr&aring;n</td><td width=600>Rubrik</td><td width=200>Skickat</td></tr>";
	$dbMessagess = $dbMessages;
	foreach( $dbMessagess as $dbMessages ) {
		$messageTopic = CQ( $dbMessages['messagetopic'] );
		if( $dbMessages['readmessage'] == false ) {
			$read = "*";
		}
		else {
			$read = "&nbsp;";
		}
		if( $iCount == 1 ) {
			print "<tr><td class=ForumTopic1>".$read."</td><td><a class=\"a2\" href=\"messages.php?mode=readMessage&messageid=".$dbMessages['messageid']."\"> ".$dbMessages['username']."</a></td><td><a href=messages.php?mode=readMessage&messageid=".$dbmessages['messageid']." class=a2>".$messageTopic."</a></td><td>".$dbMessages['messagedate']."</td></span></tr>";
			$iCount = 0;
		}
		else {
			print "<tr class=\"ForumTopic1\"><span style:background-color = \"#FF0000\"><td class=ForumTopic1>".$read."</td><td><a class=\"a2\" href=\"messages.php?mode=readMessage&messageid=".$dbMessages['messageid']."\"> ".$dbMessages['username']."</a></td><td><a href=messages.php?mode=readMessage&messageid=".$dbmessages['messageid']." class=a2>".$messageTopic."</a></td><td>".$dbMessages['messagedate']."</td></span></tr>";
			$iCount = 1;
		}

		//    $dbMessages->moveNext;
	}
	print "</table>";
	?>
		</td>
	</tr>
<?php require_once( 'footer.php' );?>} 

