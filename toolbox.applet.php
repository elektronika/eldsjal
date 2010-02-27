<?php 
if( $_SESSION['userid'] != 0 || $_SESSION['userid'] != "" ) {
	//	 User is logged in, present user menu
	//$goto0;

	if( $_SESSION['userid'] != "" ) {
		$sql = "select count(unread) as gbentrys from guestbook where touserid = ".$_SESSION['userid']." and unread = 1";
		$guestBook = $conn->execute( $sql );
		$guestBookImage = "images/icons/guestbook.gif";

		//while not guestBook.eof

		$entrys = '';
		if( intval( $guestBook['gbentrys'] ) > 0 ) {
			$guestBookImage = "images/icons/guestbookanim.gif";
			$entrys = " (".$guestBook['gbentrys'].")";
		}
		$guestBook = null;

		////	guestBook.moveNext
		//	wend

		// $sql = "select newsid from newsnotify where userid = ".$_SESSION['userid'];
		// 		$newNews = $conn->execute( $sql );
		$newsImage = "";
		// if( count( $newNews ) > 0 ) {
		// 		$newsImage = $newNews['newsid'];
		// 	}
		// $newNews = null;
		$sql = "select accepted from friends where user_id = ".$_SESSION['userid']." and accepted = 0";
		$newFriends = $conn->execute( $sql );
		$friendsImage = "images/icons/friends.gif";
		if( $newFriends ) {
			$friendsImage = "images/icons/friendsanim.gif";
		}
		$newFriends = null;
		$sql = "select count(readmessage) as newmessages from messages where userid = ".$_SESSION['userid']." and readmessage = 0";
		$newMessage = $conn->execute( $sql );
		$MessageImage = "images/icons/msg.gif";
		$messageentrys = '';
		if( intval( $newMessage['newmessages'] ) > 0 ) {
			$messageImage = "images/icons/msg1.gif";
			$messageentrys = " (".$newMessage['newmessages'].")";
		}
		$newMessage = null;
		// $sql = "select count(calendarnotifyid) as notifications from calendarnotify where userid = ".$_SESSION['userid'];
		// $notify = $conn->execute( $sql );
		$notifyImage = "images/icons/juggler.gif";

		//response.Write(notify("notifications") & "<br>")

		// if( intval( $notify['notifications'] ) > 0 ) {
			// $notifyImage = "images/icons/juggleranim.gif";

			//notifications = "1"
			//notifications = "(" & notify("notifications") & ")"
		// }
		// $notify = null;
		// $trivias = "";
		// if( $_SESSION['usertype'] >= $application['triviaadmin'] ) {
		// 	$sql = "select count(*) as trivia from trivia where approvedby = 0";
		// 	$trivia = $conn->execute( $sql );
		// 	if( intval( $trivia['trivia'] ) > 0 ) {
		// 		$trivias = "(".$trivia['trivia'].")";
		// 	}
		// }
		// $trivia = null;
		$users = "";
		if( $_SESSION['usertype'] >= $application['useradmin'] ) {
			$sql = "select count(userid) as users from users where usertype = 0 and email <> '' and userid not in (select userid from pendingdelete)";
			$userList = $conn->execute( $sql );
			if( !$userList['users'] == 0 ) {
				$users = "(".$userList['users'].")";
			}
		}
		$fadder = 0;
		$parentTool = 0;

		//Om man har minst ett fadderbarn skall knappen synas
		//Om man har minst en f&ouml;rfr&aring;gan skall knappen synas med antal f&ouml;rfr&aring;gningar

		$sql = "select count(userid) as number from users where approvedby = ".$_SESSION['userid'];
		$parent = $conn->execute( $sql );
		if( $parent['number'] > 0 ) {
			$parentTool = 1;
		}
		$sql = "select count(pendingadoptionid) as count from pendingadoption where parentuserid = ".$_SESSION['userid'];
		$parent = $conn->execute( $sql );
		if( $parent['count'] > 0 ) {
			$fadder = $parent['count'];
		}
	}
	?>
		<h3 class="boxHeader">Din kruxl&aring;da!</h3>
		<h4 class="boxContent" class="plainText"> 
		<?php 
  if( $newsImage != "" ) {
		print "<font size=\"3\" color=\"red\">!<a href=\"news.php?newsID=".$newsImage."&db=yes\" class=\"a2\">&nbsp;&nbsp;&nbsp;Nyhet</a></font><br><br>";
	}?>
		 <a class="a2" href="userPresentation.php?userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/house.gif" border="0" height="10" width="13"> Hem </a><br>
		 <a class="a2" href="guestbook.php?userid=<?php   echo $_SESSION['userid'];?>"><img src="<?php   echo $guestBookImage;?>" border="0" height="10" width="13"> G&auml;stbok <?php   echo $entrys;?>&nbsp;&nbsp;</a><br>
		 <a class="a2" href="messages.php?userid=<?php   echo $_SESSION['userid'];?>"><img src="<?php   echo $MessageImage;?>" border="0"> Meddelanden <?php   echo $messageentrys;?></a><br>
		 <a class="a2" href="friends.php?userid=<?php   echo $_SESSION['userid'];?>"><img src="<?php   echo $friendsImage;?>" border="0" height="10" width="13"> Slattar</a><br>
		 <a class="a2" href="/thoughts"><img src="images/icons/diary.gif" border="0" height="10" width="13"> Tankar</a><br>
		 <a class="a2" href="/calendar"><img src="<?php   echo $notifyImage;?>" border="0" height="10" width="13"> Aktiviteter <?php
	/*echo $notifications;*/?></a><br>
		<?php 
  if( intval( $parentTool ) == 1 || intval( $fadder ) > 0 ) {
		?>
		 <a class="a2" href="parentHood.php"><img src="images/icons/fadder.gif" border="0" height="10" width="13"> Fadderbarn <?php     if( $fadder > 0 ) {
			print "(".$fadder.")";
		}?></a><br>
		<?php
	}
	?> 
		 <br>
		 <br>
		 <?php
	// Admin interface

	if( $_SESSION['boardmember'] == 1 ) {
		print "<a class=\"a2\" href=\"sendBoardMessage.php\"><img src=\"images/icons/mess.gif\" border=\"0\">&nbsp;Styrelsepost</a><br><br>";
	}
	// if( $_SESSION['usertype'] >= 1 && false ) {
	// 	print "<a class=\"a2\" href=\"triviaAdmin.php\"><img src=\"images/icons/vishetsadministration.gif\" border=\"0\">&nbsp;Trivia ".$trivias."</a><br>";
	// }

	// if session("userType") >= application("imageAdmin") then response.Write("<a class=a2 href=image.tool.php><img src=images/icons/bildhantering.gif border=0>&nbsp;Bildhantering</a><br>")

	if( $_SESSION['usertype'] >= $application['wisdomadmin'] ) {
		print "<a class=a2 href=insertWisdom.php><img src=images/icons/vishetsadministration.gif border=0>&nbsp;Visheter</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['forumadmin'] ) {
		print "<a class=a2 href=forumAdmin.php><img src=images/icons/forumadministration.gif border=0>&nbsp;Forumadmin</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['admin'] ) {
		print "<a class=a2 href=SystemMessages.php><img src=images/icons/systemmedelande.gif border=0>&nbsp;SysMeddelanden</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['admin'] ) {
		print "<a class=a2 href=sendMassMessage.php><img src=images/icons/massutskick.gif border=0>&nbsp;Massutskick</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['admin'] ) {
		print "<a class=a2 href=security.php><img src=images/icons/skiftnyckel.gif border=0>&nbsp;R&auml;ttigheter</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['newsadmin'] ) {
		print "<a class=a2 href=news.php?mode=add><img src=images/icons/nyhetsadministration.gif border=0>&nbsp;Nyhetsadmin</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['linksadmin'] ) {
		print "<a class=a2 href=linksAdmin.php><img src=images/icons/lankadministration.gif border=0>&nbsp;L&auml;nkadmin</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['useradmin'] ) {
		print "<a class=a2 href=userAdmin.php><img src=images/icons/medlemsadministration.gif border=0>&nbsp;Ny medlem ".$users."</a><br>";
	}
	if( $_SESSION['usertype'] >= $application['useradmin'] ) {
		print "_______________<br><a href=memberRegister.php?mode=addmemberinfo class=a2 onClick=\"window.alert('Detta f&aring;r du endast g&ouml;ra om du har explicit beh&ouml;righet att registrera f&ouml;reningsmedlemmar, om inte s&aring; l&aring;t detta vara.\\nR&auml;tt att registrera f&ouml;reningsmedlemmar erh&aring;lls av glemme');\">Medlemsreg. &raquo;</a><br>";
	}?>
		 
		 <br>
		 <br>
		 <a class="a2" href="userEdit.php?mode=editAccount&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/skiftnyckel.gif" border="0"> Inst&auml;llningar</a><br>
		 <a class="a2" href="logout.php"><img src="images/buttons/xbutton.gif" border="0"> Logga ut</a>
		</h4>
		
	
<?php
}
else {
	print "<h3 class=\"boxHeader\">Hoppa In</h3><h4 class=boxContent>";

	// User is not logged in, present form

	?>

<span class="plainTheadWhite">
<form id="login" action="login.php" method="post">
	Anv&auml;ndarnamn<br>
	<input class="formButton" type="text" tabindex="1" name="username" value="<?php   echo isset( $_COOKIE['eldsjalusername'] ) ? $_COOKIE['eldsjalusername'] : '';?>" ID="username">
	
	L&ouml;senord:<br>
	<input class="formButton" type="password" tabindex="2" name="password" ID="password">
	<br>
	<div align="right">
	<img src="images/icons/kort.gif">
	<input type="submit" value="LOGGA IN" name="submit" id="submit" class="formbutton">
	<img src="images/1x1.gif" width="31" height="1">
	</div>
	
	<div align="right" class="small">kom ih&aring;g mig
	<input type="checkbox" checked value="1" name="cookie" id="cookie">
	<br>
	<a class="a2" href="register.php">Bli medlem &raquo;</a><br>
	<a href="retrievePassword.php" class="a2">tappat l&ouml;sen? &raquo;</a>
	</div>
</FORM>
</span>
<?php
}
?>