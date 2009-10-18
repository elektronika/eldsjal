<?php require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
<div class="column column-left grid_3 prefix_1">
<?php
require_once( 'toolbox.applet.php' );
require_once( 'wiseBox.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'userHistory.applet.php' );
require_once( 'image.applet.php' );?>
</div>
<div class="column column-middle grid_11">
<?php
	if( isset( $_GET['message'] ) ) 
	print "<div class=\"message\">".$_GET['message']."</div>";
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) 
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "readMessage" ) {
	if( $_SESSION['usertype'] != 0 ) {
		if( isset( $_GET['box'] ) && $_GET['box'] == "outbox" ) 
			$sql = "select messages.messagedate, messages.messagetopic, messages.messagefrom, messages.message, users.username, users.userid from messages inner join users on messages.userid = users.userid where messages.messagefrom = ".$_SESSION['userid']." and messageid = ".intval( $_GET['messageid'] );
		else 
			$sql = "select messages.messagedate, messages.messagetopic, messages.messagefrom, messages.message, users.username, users.userid from messages inner join users on messages.messagefrom = users.userid where messages.userid = ".$_SESSION['userid']." and messageid = ".intval( $_GET['messageid'] );
		$dbMessage = $conn->execute( $sql );
		if( !$dbMessage ) 
			header( "Location: "."messages.php?userid=".$_SESSION['userid']."&message=Det meddelandet finns inte eller &auml;r inte till dig!" );
		$sql = "update messages set readmessage = 1 where messageid = ".intval( $_GET['messageid'] )." and userid = ".$_SESSION['userid'];
		$updateRead = $conn->execute( $sql );
		$replyTo = substr( RQ( $dbMessage['messagetopic'] ), 0, 5 );
		if( $replyTo == "svar:" ) 
			$topic = RQ( $dbMessage['messagetopic'] );
		else 
			$topic = "svar: ".RQ( $dbMessage['messagetopic'] );
		print "<table border=0 class=showMessage><tr><td><a class=\"a2\" href=\"messages.php?mode=write&userid=".$dbMessage['userid']."&topic=".$topic."\">[svara]</td></tr><tr><td>";
		if( !is_array( current( $dbMessage ) ) ) 
			$dbMessage = array(
				$dbMessage,
			);
		$dbMessages = $dbMessage;
		if(!is_array(current($dbMessages)))
			$dbMessages = array($dbMessages);
		foreach( $dbMessages as $dbMessage ) 
			print "<a class=\"a2\" href=\"userPresentation.php?userid=".$dbMessage['userid']."\"><img src=\"images/userImages/tn_".$dbMessage['userid'].".jpg\" border=\"0\" width=\"50\"><br/>".$dbMessage['username']."</a></td><td><b>".RQ( $dbMessage['messagetopic'] )."</b><br/><br/>".RQ( $dbMessage['message'] )."</td></tr>";
	}
	else {
		$sql = "select messages.messagedate, messages.messagetopic, messages.messagefrom, messages.message, users.username, users.userid from messages inner join users on messages.messagefrom = users.userid where messages.userid = ".intval( $_SESSION['userid'] )." and messageid = ".intval( $_GET['messageid'] );
		$dbMessage = $conn->execute( $sql );
		$sql = "update messages set readmessage = 1 where messageid = ".intval( $_GET['messageid'] )." and userid = ".$_SESSION['userid'];
		$updateRead = $conn->execute( $sql );
		print "<table border=0 class=showMessage><tr><td><a class=\"a2\" href=\"messages.php?mode=write&userid=".$dbMessage['userid']."&topic=".$topic."\">[svara]</td></tr><tr><td>";
		if( !is_array( current( $dbMessage ) ) ) 
			$dbMessage = array(
				$dbMessage,
			);
		$dbMessages = $dbMessage;
		if(!is_array(current($dbMessages)))
			$dbMessages = array($dbMessages);
		foreach( $dbMessages as $dbMessage ) 
			print "<a class=\"a2\" href=\"userPresentation.php?userid=".$dbMessage['userid']."\"><img src=\"images/userImages/tn_".$dbMessage['userid'].".jpg\" border=\"0\" width=\"50\"><br/>".$dbMessage['username']."</a></td><td><b>".RQ( $dbMessage['messagetopic'] )."</b><br/><br/>".RQ( $dbMessage['message'] )."</td></tr>";
	}
	print '</table>';
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "love" ) {
	if( $_GET['userid'] == "" ) {
		header( "Location: "."main.php?message=Ingen medlem att fr&aring;ga!" );
	}
	if( $_SESSION['userid'] == "" ) {
		header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
	}
	$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".intval( $_GET['userid'] ).",'f&aring;r jag chans p&aring; dig!','du &auml;r min &ouml;gonsten och jag vill s&aring; g&auml;rna f&aring; chans p&aring; dig, det var v&auml;l allt jag ville f&ouml;r den h&auml;r g&aring;ngen! kramar!',0,getdate(), ".$_SESSION['userid'].")";
	$conn->execute( $sql );
	header( "Location: "."userPresentation.php?userid=".$_GET['userid']."&message=Nu har en chans skickats, h&aring;ll tummarna!" );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "writecalendar" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?Message=Du &auml;r inte inloggad" );
	}
	if( $_GET['eventid'] == "" ) {
		header( "Location: "."calendarview.php?message=Ingen aktivitet vald!" );
	}
	?>
			<script language="javascript">
			<!--
			function CheckForm2() {
			if (document.addMessage.messageTopic.value == '') {
			alert("Du m&aring;ste ange en rubrik!");
			document.addMessage.messageTopic.focus();
			return false;
			}
			return true;
			}
			-->
			</script>
			<table border="0" id="Table2">
<?php
		print "<form  name=\"addMessage\" action=\"messageAct.php?mode=writeselected\" method=\"post\" ID=\"addMessage\" onSubmit=\"return CheckForm2();\">";
	print "Meddelande till <b>flera mottagare</b><br/><br/>";
	$sql = "select users.username, joinactivity.userid from joinactivity inner join users on users.userid = joinactivity.userid where eventid = ".intval( $_GET['eventid'] )." order by users.username";
	$receive = $conn->execute( $sql );
	?>		
			<tr><td colspan="2">Som f&ouml;rval &auml;r alla deltagare markerade, du kan v&auml;lja bort en och en genom att h&aring;lla inne ctrl p&aring; ditt tangentbord. Detsamma g&auml;ller f&ouml;r att markera en och en.</td></tr>
			<tr><td>
			<b>Rubrik: </b>
			<input name="messageTopic" id="Text2" size="40" class="forum" value="<?php echo RQ( $_GET['topic'] );?>"/><br/>
			<textarea class="addMessage" name="message" id="Textarea2" cols="76" rows="30"></textarea><br/>
			Skicka
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			<input type="hidden" name="fromUser" value="<?php echo $_SESSION['userid'];?>" id="Hidden2" id="Hidden1"/>
			</td>
<?php
		
		if( $receive ) {
		print "<td><select name=mottagare multiple=1 size=14 class=selectBox>";
		$x = 0;
		if( $receive ) {
			$receives = $receive;
			foreach( $receives as $receive ) {
				$x = $x + 1;
				print "<option selected value=".$receive['userid'].">".$receive['username']."</option><br/>";

				//        $receive->moveNext;
			}
		}
		print "</td></select>";
	}
	?>
			</tr>
			</form>
			</table>
<?php
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "writeselected" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?Message=Du &auml;r inte inloggad" );
	}
	?>
			<script language="javascript">
			<!--
			function CheckForm2() {
			if (document.addMessage.messageTopic.value == '') {
			alert("Du m&aring;ste ange en rubrik!");
			document.addMessage.messageTopic.focus();
			return false;
			}
			return true;
			}
			-->
			</script>
			<table border="0" id="Table1">
<?php
		print "<form  name=\"addMessage\" action=\"messageAct.php?mode=writeselected\" method=\"post\" ID=\"addMessage\" onSubmit=\"return CheckForm2();\">";
	print "Meddelande till <b>flera mottagare</b><br/><br/>";
	$sql = "select friends.friend_id, users.username from friends inner join users on users.userid = friends.friend_id where friends.accepted = 1 and friends.user_id = ".$_SESSION['userid']." order by users.username";
	$friends = $conn->execute( $sql );
	$sql = "select friends.user_id, users.username from friends inner join users on users.userid = friends.user_id where friends.accepted = 1 and friends.friend_id = ".$_SESSION['userid']." order by users.username";
	$friends2 = $conn->execute( $sql );
	?>		
			<tr><td colspan="2">Som f&ouml;rval &auml;r alla dina slattar markerade, du kan v&auml;lja bort en och en genom att h&aring;lla inne ctrl p&aring; ditt tangentbord. Detsamma g&auml;ller f&ouml;r att markera en och en.</td></tr>
			<tr><td>
			<b>Rubrik: </b>
			<input name="messageTopic" id="Text1" size="40" class="forum" value="<?php echo isset( $_GET['topic'] ) ? RQ( $_GET['topic'] ) : '';?>"/><br/>
			<textarea class="addMessage" name="message" id="Textarea1" cols="76" rows="30"></textarea><br/>
			Skicka
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			<input type="hidden" name="fromUser" value="<?php echo $_SESSION['userid'];?>" id="Hidden4" id="Hidden1"/>
			</td>
<?php
		
		if( $friends || $friends2 ) {
		print "<td><select name=mottagare multiple=1 size=14 class=selectBox>";
		if( $friends ) {
			$friendss = $friends;
			foreach( $friendss as $friends ) 
				print "<option selected value=".$friends['friend_id'].">".$friends['username']."</option><br/>";
		}
		if( $friends2 ) {
			$friends2s = $friends2;
			foreach( $friends2s as $friends2 ) 
				print "<option selected value=".$friends2['user_id'].">".$friends2['username']."</option><br/>";
		}
		print "</td></select>";
	}
	?>
			</tr>
			</form>
			</table>
<?php
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "write" ) {
	if( $_GET['userid'] == "" ) {
		header( "Location: "."main.php?Message=Ingen mottagare angedd" );
	}
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?Message=Du &auml;r inte inloggad" );
	}
	?>
			<script language="javascript">
			<!--
			function CheckForm() {
			if (document.addMessage.messageTopic.value == '') {
			alert("Du m&aring;ste ange en rubrik!");
			document.addMessage.messageTopic.focus();
			return false;
			}
			return true;
			}
			-->
			</script>
<?php
		print "<form  name=\"addMessage\" action=\"messageAct.php?mode=write\" method=\"post\" ID=\"addMessage\" onSubmit=\"return CheckForm();\">";
	$sql = "select username from users where userid = ".$_GET['userid'];
	$userName = $conn->execute( $sql );
	print "Meddelande till <b>".$userName['username']."</b><br/><br/>";
	?>		
			<b>Rubrik: </b>
			<input name="messageTopic" id="messageTopic" size="40" class="forum" value="<?php echo isset( $_GET['topic'] ) ? RQ( $_GET['topic'] ) : '';?>"/><br/>
			<textarea class="addMessage" name="message" id="message" cols="76" rows="30"></textarea><br/>
			Skicka
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			<input type="hidden" name="userid" value="<?php echo $_GET['userid'];?>" id="Hidden1" id="Hidden2"/>
			<input type="hidden" name="fromUser" value="<?php echo $_SESSION['userid'];?>" id="Hidden3" id="Hidden1"/>
			</form>
<?php
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "outbox" ) {
	print "<a href=messages.php?mode=writeselected class=a2>< MASSMEDDELANDE ></a><a href=messages.php?userid=".$_SESSION['userid']." class=a2>< INKORG ></a>";
	$sql = "select messages.messagedate, messages.messagetopic, messages.messageid, messages.readmessage, messages.messagefrom, users.username from messages inner join users on messages.userid = users.userid where messages.messagefrom = ".$_SESSION['userid']." order by messagedate desc";
	$page = 1;
	if( isset( $_GET['page'] ) && $_GET['page'] != "" ) 
		$page = intval( $_GET['page'] );
	$dbMessages = $conn->execute( $sql );
	$itemCount = count( $dbMessages );
	makePager( 'messages.php?mode=outbox&page=', $itemCount, $page );
	$iCount = 0;
	$dbMessagess = $dbMessages;
	if( !is_array( current( $dbMessagess ) ) ) 
		$dbMessagess = array(
			$dbMessagess,
		);
	$dbMessagess = paginate( $dbMessagess, $page );
	print "<table marginwidth=0 marginheight=0 border=0><tr><td>&nbsp;</td><td width=150>Till</td><td width=600>Rubrik</td><td width=200>Skickat</td></tr>";
	foreach( $dbMessagess as $dbMessages ) {
		$messageTopic = CQ( $dbMessages['messagetopic'] );
		if( $dbMessages['readmessage'] = false ) 
			$read = "<font color=RED><b>!</b></font>";
		else 
			$read = "&nbsp;";
		if( $iCount == 1 ) {
			print "<tr><td class=ForumTopic1>".$read."</td><td><a class=\"a2\" href=\"messages.php?mode=readMessage&box=outbox&messageid=".$dbMessages['messageid']."\"> ".$dbMessages['username']."</a></td><td><a href=messages.php?mode=readMessage&box=outbox&messageid=".$dbMessages['messageid']." class=a2>".$messageTopic."</a></td><td>".timeSince(strtotime($dbMessages['messagedate']))."</td></span></tr>";
			$iCount = 0;
		}
		else {
			print "<tr class=\"ForumTopic1\"><span style:background-color = \"#FF0000\"><td class=ForumTopic1>".$read."</td><td><a class=\"a2\" href=\"messages.php?mode=readMessage&box=outbox&messageid=".$dbMessages['messageid']."\"> ".$dbMessages['username']."</a></td><td><a href=messages.php?mode=readMessage&box=outbox&messageid=".$dbMessages['messageid']." class=a2>".$messageTopic."</a></td><td>".timeSince(strtotime($dbMessages['messagedate']))."</td></span></tr>";
			$iCount = 1;
		}
	}
	print '</table>';
	makePager( 'messages.php?mode=outbox&page=', $itemCount, $page );
}
else {
	print "<a href=messages.php?mode=writeselected class=a2>< MASSMEDDELANDE ></a><a href=messages.php?userid=".$_SESSION['userid']."&mode=outbox class=a2>< UTKORG ></a>";
	$sql = "select messages.messagedate, messages.messagetopic, messages.messageid, messages.readmessage, messages.messagefrom, users.username from messages inner join users on messages.messagefrom = users.userid where messages.userid = ".$_SESSION['userid']." order by messagedate desc";
	$page = 1;
	if( isset( $_GET['page'] ) && $_GET['page'] != "" ) 
		$page = intval( $_GET['page'] );
	$dbMessages = $conn->execute( $sql );
	if(!is_array(current($dbMessages)))
		$dbMessages = array($dbMessages);
	$itemCount = count( $dbMessages );
	makePager( 'messages.php?page=', $itemCount, $page );
	$iCount = 0;
	print "<table marginwidth=0 marginheight=0 border=0><tr><td>&nbsp;</td><td width=150>Fr&aring;n</td><td width=600>Rubrik</td><td>&nbsp;</td><td width=200>Skickat</td></tr>";
	$dbMessagess = $dbMessages;
	$dbMessagess = paginate( $dbMessagess, $page );
	foreach( $dbMessagess as $dbMessages ) {
		$messageTopic = CQ( $dbMessages['messagetopic'] );
		if( $dbMessages['readmessage'] == false ) 
			$read = "<font color=RED><b>!</b></font>";
		else 
			$read = "&nbsp;";
		if( $iCount == 1 ) {
			print "<tr><td class=ForumTopic1>".$read."</td><td><a class=\"a2\" href=\"messages.php?mode=readMessage&messageid=".$dbMessages['messageid']."\"> ".$dbMessages['username']."</a></td><td><a href=messages.php?mode=readMessage&messageid=".$dbMessages['messageid']." class=a2>".$messageTopic."</a></td><td><a href=messageAct.php?mode=delete&messageID=".$dbMessages['messageid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort detta meddelande?');\"><img src=images/icons/trashcan.gif border=0></td><td>".timeSince(strtotime($dbMessages['messagedate']))."</td></span></tr>";
			$iCount = 0;
		}
		else {
			print "<tr class=\"ForumTopic1\"><span style:background-color = \"#FF0000\"><td class=ForumTopic1>".$read."</td><td><a class=\"a2\" href=\"messages.php?mode=readMessage&messageid=".$dbMessages['messageid']."\"> ".$dbMessages['username']."</a></td><td><a href=messages.php?mode=readMessage&messageid=".$dbMessages['messageid']." class=a2>".$messageTopic."</a></td><td><a href=messageAct.php?mode=delete&messageID=".$dbMessages['messageid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort detta meddelande?');\"><img src=images/icons/trashcan.gif border=0></td><td>".timeSince(strtotime($dbMessages['messagedate']))."</td></span></tr>";
			$iCount = 1;
		}
	}
	makePager( 'messages.php?mode=outbox&page=', $itemCount, $page );
}
?>
	</div>
	</div>
	</div>	
<?php  require_once( 'footer.php' );?>