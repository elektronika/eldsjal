<?php
//session_start();

session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "boardMember_session" );
session_register( "eventMember_session" );
session_register( "intMember_session" );
session_register( "userid_session" );
?>
<?php require_once( 'topInclude.php' );?>

<!-- lite s&auml;kerhet -->
<?php
if( isset( $_GET['category'] ) ) {
	if( $_GET['category'] == 12 ) {
		if( $_SESSION['boardmember'] != 1 ) {
			header( "Location: "."forum.php?message=Nu gjorde du fel!" );
		}
	}
	elseif( $_GET['category'] == 14 ) {
		if( $_SESSION['boardmember'] != 1 && $_SESSION['eventmember'] != 1 ) {
			header( "Location: "."forum.php?message=Nu gjorde du fel!" );
		}
	}
}
?>
<!-- slut p&aring; s&auml;kerheten typ -->



<script LANGUAGE="JavaScript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}
	function CheckForm() {

	if (document.Topic.topicName.value == '') {
	alert("Please specify topic!");
	document.Topic.topicName.focus();
	return false;
	}
	return true;
	}
	
-->
</script>

	<tr>
		<td valign="top" align="left">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>	

<?php 
if( $_SESSION['userid'] != "" ) {
	?>
		<div class="boxLeft">
		<h3 class="boxHeader">
		just nu:</h3>
		<h4 class="boxContent">
		<?php require_once( 'action.applet.php' );?>
		</h4>
		</div>		
<?php
}?>

		<div class="boxLeft">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar">
				<?php require_once( 'calendar.php' );?>
		</h4></div>

		<div class="boxLeft">
		<h3 class="boxHeader">
		Visheter:</h3>
		<h4 class="boxContent">
			<?php require_once( 'wiseBox.applet.php' );?>
		</h4>
		</div>
				

		
		<div class="boxLeft">
		<h3 class="boxHeader">
		nya tankar:</h3>
		<h4 class="boxContent">
			<?php require_once( 'diarys.applet.php' );?>
		</h4>
		</div>		
		
		<div class="boxLeft">
		<h3 class="boxHeader">
		senast inloggade:
		</h3>
		<h4 class="boxContent">
		<?php require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>	

		
		<div class="boxLeft">
		<h3 class="boxHeader">
		Senaste bilder:</h3>
		<h4 class="boxContent">

			<?php require_once( 'image.applet.php' );?>
		</h4>
		</div>	
		</td>
		<td width="600" height="190" valign="top">
		<?php if( isset( $_GET['message'] ) && $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}

// Visa tr&aring;d

if( isset( $_GET['mode'] ) && $_GET['mode'] == "readTopic" ) {
	// print "<a class=a2 href=\"forum.php?category=".$_GET['category']."\">&laquo; tillbaka</a>";

	if(( intval( $_GET['threadid'] == 122 ) ) ) {
		$sql = "select top 50 forumcategory.forumsecuritylevel, forumtopics.locked, forummessages.messageid,forummessages.posterid, forumtopics.topicname, forumtopics.topicid, users.username, users.hasimage, users.userid, forummessages.messagedate, forummessages.message from forummessages inner join users on users.userid = forummessages.posterid inner join forumtopics on forummessages.topicid = forumtopics.topicid inner join forumcategory on forumcategory.forumcategoryid = forumtopics.forumcategoryid where forummessages.topicid = ".intval( $_GET['threadid'] )." order by forummessages.messagedate desc";
	}
	else {
		$sql = "select forumcategory.forumsecuritylevel, forumtopics.locked, forummessages.messageid , forummessages.posterid, forumtopics.topicname, forumtopics.topicid, users.username, users.hasimage, users.userid, forummessages.messagedate, forummessages.message from forummessages inner join users on users.userid = forummessages.posterid inner join forumtopics on forummessages.topicid = forumtopics.topicid inner join forumcategory on forumcategory.forumcategoryid = forumtopics.forumcategoryid where forummessages.topicid = ".intval( $_GET['threadid'] )." order by forummessages.messageid asc";
	}
	$threads = $conn->execute( $sql );
	if( !is_array( current( $threads ) ) ) 
		$threads = array($threads);
	if( $_SESSION['userid'] != "" ) {

		//LOGGER

		$seclevel = 0;
		if( $threads[0]['forumsecuritylevel'] > 1 ) 
			$seclevel = 5;
		$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumpostview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." studerar tr&aring;den \"".$threads[0]['topicname']."\" i forumet', getdate(), ".$seclevel.")";
		$conn->execute( $sql );
	}
	$sql = "select locked from forumtopics where topicid = ".intval( $_GET['threadid'] );
	$locked = $conn->execute( $sql );

	//Get latest post-date for this post

	$sql = "select latestentry from forumtopics where topicid = ".intval( $_GET['threadid'] );
	$latestPostDate = $conn->execute( $sql );

	//Update cookie so that all up to this now() is read... complication if two posts with identical dates has been written

	if( isset( $_SESSION['userid'] ) && !empty( $_SESSION['userid'] ) ) 
		setcookie( "eldsjalForumRead".$_GET['category'], time( ), 0, "", "", 0 );
	if( isset( $_COOKIE['eldsjalForumRead'.$_GET['category']] ) && FALSE ) {
		if( strtotime( $_COOKIE['eldsjalForumRead'.$_GET['category']] ) < strtotime( $latestPostDate['latestentry'] ) ) {
			setcookie( "eldsjalForumRead".$_GET['category'], strtotime( $latestPostDate['latestentry'] ), 0, "", "", 0 );
		}
		else {
		}
		setcookie( "eldsjalForumRead".$_GET['category'], time(), 0, "", "", 0 );
	}
	$iCount = 0;
	$sql = "select forumcategoryname, forumcategoryid from forumcategory where forumcategoryid = ".intval( $_GET['category'] );
	$categoryName = $conn->execute( $sql );
	print "<h2><a href=forum.php>Forum</a> &raquo; <a href=forum.php?category=".$categoryName['forumcategoryid'].">".$categoryName['forumcategoryname']."</a> &raquo; ".$threads[0]['topicname']."</h2>";
	print "<table marginwidth=0 marginheight=0 cellspacing=0 cellpadding=3 border=0 width=600>";

	//response.Write("<table marginwidth=0 marginheight=0 border=0 width=600><tr><td colspan=""2""><b>" & thread("topicName") & "</b></td></tr>")

	$iCount = 1;

	//print_r($threads);

	foreach( $threads as $thread ) {
		$message = rq( $thread['message'] );
		if( $iCount >= 1 ) {
			$format = "ForumTopic1";
			$iCount = 0;
		}
		else {
			$format = "";
			$iCount = $iCount + 1;
		}
		print "<tr class=".$format."><td rowspan=2 valign=top><a class=\"a2\" href=\"userPresentation.php?userid=".$thread['posterid']."\">";
		if( $thread['hasimage'] == true ) {
			print "<img src=\"uploads/userImages/tn_".$thread['userid'].".jpg\" border=\"0\" width=\"50\"><br>".$thread['username']."</a></td>";
		}
		else {
			print "<img src=\"images/ingetfoto.gif\" border=\"0\" width=\"50\">  ".$thread['username']."</a></td>";
		}
		if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) || $_SESSION['userid'] == intval( $thread['posterid'] ) ) {
			print "<td align=right><a href=\"forum.php?mode=updatePost&threadid=".$_GET['threadid']."&category=".$_GET['category']."&messageid=".$thread['messageid']."\"><img src=images/icons/edit.gif border=0></a>&nbsp;<a href=forumAct.php?mode=deletePost&messageid=".$thread['messageid']."&category=".$_GET['category']."&threadid=".$_GET['threadid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort denna post?')\"><img src=images/icons/trashcan.gif border=0></a> ".timeSince(strtotime( $thread['messagedate'] ) )."<hr></td>";
		}
		else {
			print "<td align=\"right\"> ".timeSince(strtotime( $thread['messagedate'] ) )."<hr></td>";
		}
		print "</tr><tr class=".$format."><td valign=top>".$message."<br></td></tr>";

		//post separator

		print "<tr><td colspan=3>&nbsp;</td></tr>";

		////    $thread->moveNext;
	}
	print "</table>";
	if( $_SESSION['usertype'] >= $application['forumadmin'] || ( $locked['locked'] == false || $locked['locked'] == 0 ) ) {
		?>
						
			<form name="addReply" method="post" action="forumAct.php?mode=addReply&threadid=<?php     echo $_GET['threadid'];?>" ID="Form1">
			Kommentar<br>
			<textarea name="message" id="Textarea1" class="forum"></textarea>
			<div align="right">
			<input type="hidden" name="categoryid" id="categoryid" value="<?php     echo $_GET['category'];?>">
			Skicka
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			</div>
			</form>					
		<?php
	}
	else {
		print "<hr width=50% >Tr&aring;den l&aring;st!";
	}
}

// Uppdatera inl&auml;&auml;gg

elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "updatePost" ) {
	if( $_SESSION['usertype'] >= 1 ) {
		if( $_SESSION['usertype'] >= $application['forumadmin'] ) {
			$sql = "select forummessages.messagedate, forummessages.message, forummessages.posterid, forumtopics.topicname from forummessages inner join forumtopics on forummessages.topicid = forumtopics.topicid where messageid = ".intval( $_GET['messageid'] );
		}
		else {
			$sql = "select forummessages.messagedate, forummessages.message, forummessages.posterid, forumtopics.topicname from forummessages inner join forumtopics on forummessages.topicid = forumtopics.topicid where posterid = ".$_SESSION['userid']." and messageid  = ".intval( $_GET['messageid'] );
		}
		$resultss = $conn->execute( $sql );

		//LOGGER

		$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumpostupdate',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." &auml;ndrar sitt inl&auml;gg i \"".$resultss['topicname']."\" i forumet', getdate(), 0)";
		$conn->execute( $sql );
		if( !$resultss ) {
			header( "Location: "."forum.php?mode=readTopic&category=".$_GET['category']."&threadid = ".$_GET['threadid']."&message=No such message found, update aborted!" );
		}?>
				
			<form name="updateReply" method="post" action="forumAct.php?mode=updatePost&threadid=<?php     echo $_GET['threadid'];?>&category=<?php     echo $_GET['category'];?>" ID="Form2">
			<br>Reply<br>
			<textarea name="message" id="Textarea2" class="forum"><?php     echo rqForm( $resultss['message'] );?></textarea>
			<div align="right">
			<input type="hidden" name="messageid" id="Hidden1" value="<?php     echo $_GET['messageid'];?>">
			Post
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			</div>
			</form>
			
		<?php
	}
}

// Starta ny tr&aring;d

elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "newTopic" ) {
	//Trigger the add Topic form - call mode=regTopic
	//Check if logged in, if not throw them back with a warning

	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."forum.php?message=Du kan inte skapa tr&aring;dar utan att vara inloggad, logga in och f&ouml;rs&ouml;k igen!" );
	}

	// [unsupported] session.timeout=30;

	?>
	<script language="javascript">
	<!--
	function CheckForm() {

	if (document.newTopic.topic.value == '') {
	alert("Du m&aring;ste ange en rubrik!");
	document.newTopic.topic.focus();
	return false;
	}
	return true;
	}
	
	-->
	</script>
			<form name="newTopic" method="post" action="forumAct.php?mode=addEntry" onSubmit="return CheckForm();">
			Rubrik<br>
			<input type="text" name="topic" id="topic" class="forum">
			<br>Meddelande<br>
			<textarea name="message" id="message" class="forum"></textarea>
			<div align="right">
			<input type="hidden" name="categoryid" id="categoryid" value="<?php   echo $_GET['category'];?>">
			<input type="submit" name="submit" class="submit" id="submit" value="&raquo; &raquo;">
			</div>
			</form>
						
			<?php
	//LOGGER

	$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumpostnewthread',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." h&aring;ller p&aring; och skriva en ny forumtr&aring;d i forumet', getdate(), 0)";
	$conn->execute( $sql );
}

// L&aring;s tr&aring;d

elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "lockTopic" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."forum.php?message=You are not allowed to create threads since you are not a member!" );
	}
	$sql = "select locked, topicname from forumtopics where topicid = ".intval( $_GET['topicid'] );
	$locked = $conn->execute( $sql );
	if( intval( $locked['locked'] ) == 1 || $locked['locked'] == true ) {
		//LOGGER

		$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumthreadunlock',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." l&aring;ste just upp tr&aring;den \"".$locked['topicname']."\"', getdate(), 0)";
		$conn->execute( $sql );
		$sql = "update forumtopics set locked = 0 where topicid = ".intval( $_GET['topicid'] );
		$message = "Tr&aring;den uppl&aring;st!";
	}
	else {
		//LOGGER

		$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumthreadlock',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." l&aring;ste just tr&aring;den \"".$locked['topicname']."\"', getdate(), 0)";
		$conn->execute( $sql );
		$sql = "update forumtopics set locked = 1 where topicid = ".intval( $_GET['topicid'] );
		$message = "Tr&aring;den l&aring;st!";
	}
	$conn->execute( $sql );
	header( "Location: "."forum.php?category=".$_GET['category']."&message".$message );
}

// Uppdatera tr&aring;d

elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "editTopic" ) {
	//Trigger the add Topic form - call mode=regTopic
	//Check if logged in, if not throw them back with a warning

	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."forum.php?message=Du har inte r&auml;ttigheter att &auml;ndra detta" );
	}
	$sql = "select topicname, sticky, forumcategoryid from forumtopics where topicid = ".intval( $_GET['topicid'] );
	$topic = $conn->execute( $sql );
	if( !$topic ) {
		header( "Location: "."forum.php?message=Hittade ingen s&aring;dan tr&aring;d!" );
	}
	$sql = "select forumcategoryname, forumcategoryid from forumcategory";
	$category = $conn->execute( $sql );

	//LOGGER

	$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumthreadedit',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." h&aring;ller p&aring; och &auml;ndrar tr&aring;den \"".$topic['topicname']."\"', getdate(), 0)";
	$conn->execute( $sql );
	?>

			<form name="Topic" method="post" action="forumAct.php?mode=updateTopic&category=<?php   echo $_GET['category'];?>" onSubmit="return CheckForm();" ID="Form3">
			Topic<br>
			<input type="text" name="topicName" id="Text1" class="forum" value="<?php   echo rq( $topic['topicname'] );?>">
			<br><br>
			Category:<br><select class=selectBox name="categoryid" ID="Select1">
			<?php 
  $categorys = $category;
	foreach( $categorys as $category ) {
		print "<option value=".$category['forumcategoryid'];
		if( $topic['forumcategoryid'] == $category['forumcategoryid'] ) {
			print " selected ";
		}
		print ">".$category['forumcategoryname']."</option>";

		////    $category->moveNext;
	}
	?>
			</select>
			<br><br>Sticky: <input type="checkbox" name="sticky" value=1 <?php   if( $topic['sticky'] == 1 || $topic['sticky'] == true ) {
		print " checked ";
	}?> ID="Checkbox2">
			<br><br>
			<input type="hidden" name="topicid" value="<?php   echo $_GET['topicid'];?>" ID="Hidden2">
			<input type="submit" name="submit" class="submit" id="Submit1" value="&raquo; &raquo;">
			</form>
		<?php
}

// Visa kategori

elseif( isset( $_GET['category'] ) ) {
	if( isset( $_GET['page'] ) && $_GET['page'] != "" ) 
		$page = intval( $_GET['page'] );
	else 
		$page = 1;
	$sql = "select forumcategoryname,forumcategoryid, forumsecuritylevel, forumwritelevel from forumcategory where forumcategoryid = ".intval( $_GET['category'] );
	$categoryName = $conn->execute( $sql );
	if( $categoryName ) {
		if( $_SESSION['userid'] != "" ) {
			//LOGGER
			$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumcategoryview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." kikar i forumkategorin \"".$categoryName['forumcategoryname']."\"', getdate(), ".$categoryName['forumsecuritylevel'].")";
			$conn->execute( $sql );
		}

		//response.Write(categoryName("forumSecurityLevel") & session("boardMember"))

		if( $categoryName['forumsecuritylevel'] == 2 && $_SESSION['boardmember'] != 1 ) {
			header( "Location: "."forum.php?message=Du har inte tillg&aring;ng till denna kategori eller s&aring; finns den inte!" );
		}
		if( $categoryName['forumsecuritylevel'] == 1 && $_SESSION['userid'] == "" ) {
			header( "Location: "."forum.php?message=Du har inte tillg&aring;ng till denna kategori eller s&aring; finns den inte!" );
		}

		// This is the threadview of the forum, listing topics

		$sql = "select forumtopics.locked, forumtopics.topicposterid, forumtopics.topicname, forumtopics.topicid, forumtopics.topicdate, forumtopics.latestentry, forumtopics.totalentrys, users.username, users.userid from forumtopics inner join users on users.userid = forumtopics.topicposterid where forumtopics.forumcategoryid = ".intval( $_GET['category'] )." and sticky = 1 order by latestentry desc";
		$sticky = $conn->execute( $sql );
		$sql = "select forumtopics.locked, forumtopics.topicposterid, forumtopics.topicname, forumtopics.topicid, forumtopics.topicdate, forumtopics.latestentry, forumtopics.totalentrys, users.username, users.userid from forumtopics inner join users on users.userid = forumtopics.topicposterid where forumtopics.forumcategoryid = ".intval( $_GET['category'] )." and sticky = 0 order by latestentry desc";

		// $topicList is of type "adodb.recordset"
		//topicList.MaxRecords = 20

		$topicLists = $conn->execute( $sql );

		//print_r($topicLists);
		//echo 30;
		//echo $page;

		print "<h2><a href=forum.php>Forum</a> &raquo; ".$categoryName['forumcategoryname']."</h2>";
		// print "<a class=a2 href=\"forum.php\">&laquo; tillbaka</a>&nbsp;&nbsp;&nbsp;";
		if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
			print "<a class=a2 href=\"forum.php\" onClick=\"javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\"> Skapa nytt inl&auml;gg!</a>";
		} elseif($_SESSION['usertype'] <= $categoryName['forumwritelevel']) {
			print 'Tyv&auml;rr, du kan inte skapa nya tr&aring;dar h&auml;r.';
		}
		else {
			print "<a class=a2 href=forum.php?mode=newTopic&category=".$_GET['category'].">Skapa nytt inl&auml;gg!</a>";
		}
		print " - <a href=\"forum.php?mode=search&category=".$_GET['category']."\" class=a2>S&ouml;k inl&auml;gg</a><br><br>";
		$itemCount = count( $topicLists );
		makePager( "forum.php?category=".$_GET['category']."&page=", $itemCount, $page, 30 );
		if( $_SESSION['userid'] != "" ) {
			if( isset( $_COOKIE['eldsjalForumRead'.$_GET['category']] ) ) {
				setcookie( "eldsjalForumRead".$_GET['category'], time( ), 0, "", "", 0 );
			}
		}
			if(( $topicLists == 0 ) && $sticky ) {
				print "Det finns inte n&aring;gra tr&aring;dar registrerade &auml;nnu!";
			}
			else {
				print "<table border=0 width=100% cellpadding=0 cellspacing=0>";
				print "<tr><td>&nbsp;</td><td width=250>&Auml;mne</td><td>&nbsp;</td><td align=center>senast svar</td><td align=center width=30>svar</td><td align=center>skapad av</td><td align=right width=75>skapad den</td></tr>";
				$iCount = 1;

				//This is the counter that makes it possible to color indifferently

				$stickys = $sticky;
				if( !empty( $stickys ) && !is_array( current( $stickys ) ) ) 
					$stickys = array(
						$stickys,
					);
				if( !empty( $stickys ) ) 
					foreach( $stickys as $sticky ) {
						if( intval( $sticky['locked'] ) == 1 || $sticky['locked'] == true ) 
							$unReadFlag = "<img src=/images/icons/locked_topic.gif>";
						else {
							if( isset( $_COOKIE['eldsjalForumRead'.$_GET['category']] ) ) {
								if( $_COOKIE['eldsjalForumRead'.$_GET['category']] < strtotime( $sticky['latestentry'] ) ) 
									$unReadFlag = "<img src=/images/icons/new_topic.gif>";
								else 
									$unReadFlag = "<img src=images/icons/folder.gif border=0>";
						}
						else 
							$unReadFlag = "<img src=images/icons/folder.gif border=0>";
					}

					// Lista sticky-tr&aring;dar

					if( $iCount == 1 ) {

						//This is the first row to be executed

						print "<tr class=ForumTopic1><span style:background-color = \"#FF0000\"><td class=ForumTopic1>".$unReadFlag."</td><td class=ForumTopic1><a class=a2 href=forum.php?mode=readTopic&category=".$_GET['category']."&threadid=".$sticky['topicid'].">".$sticky['topicname']."<td>&nbsp;";
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) ) {
							print "<a href=forum.php?mode=lockTopic&category=".$_GET['category']."&topicid=".$sticky['topicid']."><img src=images/icons/locked_topic.gif border=0></a>&nbsp;";
						}
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) ) {
							print "<a href=forum.php?mode=editTopic&category=".$_GET['category']."&topicid=".$sticky['topicid']."><img src=images/icons/edit.gif border=0></a>&nbsp;<a href=forumAct.php?mode=deleteTopic&topicid=".$sticky['topicid']."&category=".$_GET['category']." onClick=\"return confirmSubmit('Är du s&auml;ker p&aring; att du vill ta bort den h&auml;r tr&aring;den?')\"><img src=images/icons/trashcan.gif border=0></a>";
						}
						print "</td><td align=center>".timeSince(strtotime($sticky['latestentry']))."</td><td align=center><b>".$sticky['totalentrys']."</b></td><td align=middle><a class=a2 href=userPresentation.php?userid=".$sticky['userid'].">".$sticky['username']."</a></td><td align=right>".date( 'Y-m-d', strtotime( $sticky['topicdate'] ) )."</td></span></tr>";
						$iCount = 0;
					}
					else {

						//This is the second row to be executed

						print "<tr><td>".$unReadFlag."</td><td><a class=a2 href=forum.php?mode=readTopic&category=".$_GET['category']."&threadid=".$sticky['topicid'].">".$sticky['topicname']." </td><td>&nbsp;";
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) ) {
							print "<a href=forum.php?mode=lockTopic&category=".$_GET['category']."&topicid=".$sticky['topicid']."><img src=images/icons/locked_topic.gif border=0></a>&nbsp;";
						}
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) || $_SESSION['userid'] == intval( $sticky['topicposterid'] ) ) {
							print "<a href=forum.php?mode=editTopic&category=".$_GET['category']."&topicid=".$sticky['topicid']."><img src=images/icons/edit.gif border=0></a>&nbsp;<a href=forumAct.php?mode=deleteTopic&topicid=".$sticky['topicid']."&category=".$_GET['category']." onClick=\"return confirmSubmit('Är du s&auml;ker p&aring; att du vill ta bort den h&auml;r tr&aring;den?')\"><img src=images/icons/trashcan.gif border=0></a>";
						}
						print "</td><td align=center>".timeSince(strtotime($sticky['latestentry']))."</td><td align=center><b>".$sticky['totalentrys']."</b></td><td align=center><a class=a2 href=userPresentation.php?userid=".$sticky['userid'].">".$sticky['username']."</a></td><td align=right>".date( 'Y-m-d', strtotime( $sticky['topicdate'] ) )."</td></tr>";
						$iCount = $iCount + 1;
					}
				}
				$counter = 1;

				//$topicLists = array_slice($topicLists, 0, 30);

				if( !empty( $topicLists ) && !is_array( current( $topicLists ) ) ) 
					$topicLists = array(
						$topicLists,
					);
				$topicLists = paginate( $topicLists, $page, 30 );
				foreach( $topicLists as $topicList ) {
					$counter = $counter + 1;
					if(( $topicList['locked'] == true ) || ( intval( $topicList['locked'] ) ) == 1 ) 
						$unReadFlag = "<img src=/images/icons/locked_topic.gif>";

					//if(TRUE) {

					if( isset( $_COOKIE['eldsjalForumRead'.$_GET['category']] ) ) {
						if( $_COOKIE['eldsjalForumRead'.$_GET['category']] < strtotime( $topicList['latestentry'] ) ) 
							$unReadFlag = "<img src=/images/icons/new_topic.gif>";
						else 
							$unReadFlag = "<img src=images/icons/folder.gif border=0>";
					}
					else 
						$unReadFlag = "<img src=images/icons/folder.gif border=0>";

					//}
					//if (TRUE)
					//{
					// Lista vanliga tr&aring;dar

					if( !isset( $iCount ) ) 
						$iCount = 1;
					if( $iCount == 1 ) {

						//This is the first row to be executed

						print "<tr class=ForumTopic1><span style:background-color = \"#FF0000\"><td class=ForumTopic1>".$unReadFlag."</td><td class=ForumTopic1><a class=a2 href=forum.php?mode=readTopic&category=".$_GET['category']."&threadid=".$topicList['topicid'].">".$topicList['topicname']."<td>&nbsp;";
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) ) {
							print "<a href=forum.php?mode=lockTopic&category=".$_GET['category']."&topicid=".$topicList['topicid']."><img src=images/icons/locked_topic.gif border=0></a>&nbsp;";
						}
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) || ( intval( $_SESSION['userid'] ) == intval( $topicList['topicposterid'] ) ) ) {
							print "<a href=forum.php?mode=editTopic&category=".$_GET['category']."&topicid=".$topicList['topicid']."><img src=images/icons/edit.gif border=0></a>&nbsp;<a href=forumAct.php?mode=deleteTopic&topicid=".$topicList['topicid']."&category=".$_GET['category']." onClick=\"return confirmSubmit('Är du s&auml;ker p&aring; att du vill ta bort den h&auml;r tr&aring;den?')\"><img src=images/icons/trashcan.gif border=0></a>";
						}
						print "</td><td align=center>".timeSince(strtotime($topicList['latestentry']))."</td><td align=center><b>".$topicList['totalentrys']."</b></td><td align=middle><a class=a2 href=userPresentation.php?userid=".$topicList['userid'].">".$topicList['username']."</a></td><td align=right>".date( 'Y-m-d', strtotime( $topicList['topicdate'] ) )."</td></span></tr>";
						$iCount = 0;
					}
					else {

						//This is the second row to be executed

						print "<tr><td>".$unReadFlag."</td><td><a class=a2 href=forum.php?mode=readTopic&category=".$_GET['category']."&threadid=".$topicList['topicid'].">".$topicList['topicname']." </td><td>&nbsp;";
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) ) {
							print "<a href=forum.php?mode=lockTopic&category=".$_GET['category']."&topicid=".$topicList['topicid']."><img src=images/icons/locked_topic.gif border=0></a>&nbsp;";
						}
						if( intval( $_SESSION['usertype'] ) >= intval( $application['forumadmin'] ) || $_SESSION['userid'] == intval( $topicList['topicposterid'] ) ) {
							print "<a href=forum.php?mode=editTopic&category=".$_GET['category']."&topicid=".$topicList['topicid']."><img src=images/icons/edit.gif border=0></a>&nbsp;<a href=forumAct.php?mode=deleteTopic&topicid=".$topicList['topicid']."&category=".$_GET['category']." onClick=\"return confirmSubmit('Är du s&auml;ker p&aring; att du vill ta bort den h&auml;r tr&aring;den?')\"><img src=images/icons/trashcan.gif border=0></a>";
						}
						print "</td><td align=center>".timeSince(strtotime($topicList['latestentry']))."</td><td align=center><b>".$topicList['totalentrys']."</b></td><td align=center><a class=a2 href=userPresentation.php?userid=".$topicList['userid'].">".$topicList['username']."</a></td><td align=right>".date( 'Y-m-d', strtotime( $topicList['topicdate'] ) )."</td></tr>";
						$iCount = $iCount + 1;
					}

					//}
				}
				print "</table>";
				makePager( "forum.php?category=".$_GET['category']."&page=", $itemCount, $page, 30 );
			}
		// }
	}
	else {
		header( "Location: "."forum.php?message=Det finns inget s&aring;nt forum eller s&aring; saknar du r&auml;ttigheter att se det!" );
	}
}

// S&ouml;k i kategorin

elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "search" ) {
	print "<form name=forumSearch action=forum.php?mode=searchResult method=post>";
	print "H&auml;r kan du g&ouml;ra enklare s&ouml;kningar f&ouml;r att hitta en tr&aring;d eller ett inl&auml;gg som du s&ouml;ker!<br>V&auml;nligen f&ouml;rs&ouml;k g&ouml;ra s&ouml;kningarna tydliga f&ouml;r att skona databasen!<br>Endast hela ord p&aring; minst fem tecken tas emot idag!<br>";
	print "S&ouml;kord: <input name=word type=text><br>";
	?>
		<select class=selectBox name="crBeforeY" size="1" ID="Select2">
					<?php 

    $beforeYear = 2003;
	while( intval( $beforeYear ) <= strftime( "%Y", time( ) ) ) {
		print "<option value=".$beforeYear;
		if( intval( $beforeYear ) == strftime( "%Y", time( ) ) ) {
			print " selected ";
		}
		print ">".$beforeYear."</option>";
		$beforeYear = $beforeYear + 1;
	}
	?>
				</select>
				<select name="crBeforeM" class=selectBox size="1" ID="Select3">
				<?php 
    $mm = strftime( "%m", time( ) );
	?>
					<option value="01" <?php     if( $mm == 1 ) {
		print " selected ";
	}?>>Januari</option>
					<option value="02" <?php     if( $mm == 2 ) {
		print " selected ";
	}?>>Februari</option>
					<option value="03" <?php     if( $mm == 3 ) {
		print " selected ";
	}?>>Mars</option>
					<option value="04" <?php     if( $mm == 4 ) {
		print " selected ";
	}?>>April</option>
					<option value="05" <?php     if( $mm == 5 ) {
		print " selected ";
	}?>>Maj</option>
					<option value="06" <?php     if( $mm == 6 ) {
		print " selected ";
	}?>>Juni</option>
					<option value="07" <?php     if( $mm == 7 ) {
		print " selected ";
	}?>>Juli</option>
					<option value="08" <?php     if( $mm == 8 ) {
		print " selected ";
	}?>>Augusti</option>
					<option value="09" <?php     if( $mm == 9 ) {
		print " selected ";
	}?>>September</option>
					<option value="10" <?php     if( $mm == 10 ) {
		print " selected ";
	}?>>Oktober</option>
					<option value="11" <?php     if( $mm == 11 ) {
		print " selected ";
	}?>>November</option>
					<option value="12" <?php     if( $mm == 12 ) {
		print " selected ";
	}?>>December</option>
				</select>
				<select name="crBeforeD" class=selectBox size="1" ID="Select4">
					<option value="01" selected>01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
				</select>
				<br><br>
				<select class=selectBox name="crAfterY" size="1" ID="Select5">
					<?php 

    $crAfterY = 1900;
	while( intval( $crAfterY ) <= strftime( "%Y", time( ) ) ) {
		print "<option value=".$crAfterY;
		if( intval( $crAfterY ) == strftime( "%Y", time( ) ) ) {
			print " selected ";
		}
		print ">".$crAfterY."</option>";
		$crAfterY = $crAfterY + 1;
	}
	?>
				</select>
				<select name="crAfterM" class=selectBox size="1" ID="Select6">
				<?php 
    $mm = strftime( "%m", time( ) );
	?>
					<option value="01" <?php     if( $mm == 1 ) {
		print " selected ";
	}?>>Januari</option>
					<option value="02" <?php     if( $mm == 2 ) {
		print " selected ";
	}?>>Februari</option>
					<option value="03" <?php     if( $mm == 3 ) {
		print " selected ";
	}?>>Mars</option>
					<option value="04"> <?php     if( $mm == 4 ) {
		print " selected ";
	}?>April</option>
					<option value="05" <?php     if( $mm == 5 ) {
		print " selected ";
	}?>>Maj</option>
					<option value="06" <?php     if( $mm == 6 ) {
		print " selected ";
	}?>>Juni</option>
					<option value="07" <?php     if( $mm == 7 ) {
		print " selected ";
	}?>>Juli</option>
					<option value="08" <?php     if( $mm == 8 ) {
		print " selected ";
	}?>>Augusti</option>
					<option value="09" <?php     if( $mm == 9 ) {
		print " selected ";
	}?>>September</option>
					<option value="10" <?php     if( $mm == 10 ) {
		print " selected ";
	}?>>Oktober</option>
					<option value="11" <?php     if( $mm == 11 ) {
		print " selected ";
	}?>>November</option>
					<option value="12" <?php     if( $mm == 12 ) {
		print " selected ";
	}?>>December</option>
				</select>
				<select name="crAfterD" class=selectBox size="1" ID="Select7">
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30" selected>30</option>
					<option value="31">31</option>
				</select>
				<br><br>
		<?php
	//response.Write("Postare: <input name=poster type=text><br>")

	print "<img src=\"images\\1x1.gif\" width=\"50\" height=\"1\">S&ouml;k<input type=\"image\" src=\"images\\icons\\arrows.gif\" name=\"search\" class=\"proceed\">";
	print "<input type=hidden name=category value=".$_GET['category'].">";
	print "</form>";

	//LOGGER
	$sql = "insert into history (action, userid, nick, message, date, security) values ('forumsearch',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." s&ouml;ker i forumet', getdate(), 0)";
		
	$conn->execute( $sql );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "searchResult" ) {
	if( strlen( $_POST['word'] ) < 2 ) {
		header( "Location: "."forum.php?category=".$_POST['category']."&message=S&ouml;kordet m&aring;ste vara l&auml;ngre &auml;n tv&aring; tecken&mode=search" );
	}
	$crAfter = $_POST['crbeforey']."-".$_POST['crbeforem']."-".$_POST['crbefored'];
	$crBefore = $_POST['craftery']."-".$_POST['crafterm']."-".$_POST['crafterd'];
	if( !$isDate[$crAfter] || !$isDate[$crbefore] ) {
		header( "Location: "."forum.php?category=".$_POST['category']."&message=N&aring;got knas med datumen, kontrollera&mode=search" );
	}

	// Disabled since I changed the dateroutine to drop-downs
	//if crAfter > request.Form("crBefore") then response.Redirect("forum.php?category=" & request.Form("category") & "&message=Skapat innan-datumet &auml;r efter skapat efter-datumet, kontrollera!&mode=search")

	$word = CQ( $_POST['word'] );
	$sql = "select distinct forumtopics.topicdate, forumtopics.totalentrys, forumtopics.topicposterid, forummessages.topicid, forumtopics.topicname, users.username, users.userid, forumcategory.forumcategoryname from forummessages inner join forumtopics on forummessages.topicid = forumtopics.topicid inner join users on forumtopics.topicposterid = users.userid inner join forumcategory on forumcategory.forumcategoryid = ".intval( $_POST['category'] )." where forummessages.message like '%".$word."%' and forumtopics.forumcategoryid = ".intval( $_POST['category'] )." and forummessages.messagedate >= '".$crafter."' and forummessages.messagedate <= '".$crbefore."'";

	//Not complete, need additional SQL-code above
	//if request.Form("poster") <> "" then SQL = SQL & " and forum

	$sql .= ' ORDER BY forumTopics.topicDate DESC';

	//response.Write(SQL)
	//response.End

	$results = $conn->execute( $sql );
	if( !$results ) 
		header( "Location: "."forum.php?category=".$_POST['category']."&message=Inga inl&auml;gg med det ordet hittades!&mode=search" );
	else {
		print "<a href=forum.php?mode=search class=a2>Ny s&ouml;kning &raquo;</a><br><br><table border=0 cellspacing=2><tr><td colspan=4>Du s&ouml;kte p&aring;: \"<b>".$word."</b>\", i kategorin <b>".$result['forumcategoryname']."</b> detta &auml;r de tr&aring;dar som har inl&auml;gg med det ordet!</td></tr>";
		print "<tr><td><b>Tr&aring;d</b></td><td><b>Skapat den:</b></td><td><b>Postare</b></td><td><b>Antal inl&auml;gg</b></td></tr>";
		foreach( $results as $result ) {
			print "<tr><td><a href=forum.php?mode=readTopic&category=".$_POST['category']."&threadid=".$result['topicid']." class=a2>".$result['topicname']."</td><td>".$formatDateTime[$result['topicdate']][$vbShortDate]."</td><td><a href=userPresentation.php?userid=".$result['userid']." class=a2>".$result['username']."</a></td><td>".$result['totalentrys']."</td></tr>";

			////        $result->moveNext;
		}
		print "</table>";
	}
}

//}

else {
	//this is the deafult view, listing categorys

	if( $_SESSION['userid'] != "" ) {
		//LOGGER
		$sql = "insert into history (action, userid, nick, message, [date], security) values ('forumcategories',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." bligar &ouml;ver forumkategorierna', getdate(), 0)";
		$conn->execute( $sql );
	}
	print '<h2>Forum</h2>';
	print "<table border=0 width=600 cellpadding=3 cellspacing=3>";
	print "<tr><td>&nbsp;</td><td width=50>Kategori</td><td width=300 align=center>Beskrivning</td><td align=center width=30>Tr&aring;dar</td><td align=right>Senaste inl&auml;gg</td></tr>";
	if( $_SESSION['boardmember'] == 1 && $_SESSION['userid'] != "" ) {
		$sql = "select * from forumcategory order by forumcategorysortorder ";
	}
	elseif( $_SESSION['eventmember'] == 1 && $_SESSION['userid'] != "" ) {
		$sql = "select * from forumcategory where forumsecuritylevel in (3,1,0) order by forumcategorysortorder";
	}
	elseif( $_SESSION['intmember'] == 1 && $_SESSION['userid'] != "" ) {
		$sql = "select * from forumcategory where forumsecuritylevel in (4,1,0) order by forumcategorysortorder";
	}
	elseif( $_SESSION['userid'] != "" ) {
		$sql = "select * from forumcategory where forumsecuritylevel <= 1 order by forumcategorysortorder";
	}
	else {
		$sql = "select * from forumcategory where forumsecuritylevel = 0 order by forumcategorysortorder ";
	}
	$categorys = $conn->execute( $sql );

	//print_r($categorys);

	foreach( $categorys as $category ) {
		if( isset( $_SESSION['userid'] ) && !empty( $_SESSION['userid'] ) && isset( $_COOKIE['eldsjalForumRead'.$_GET['category']] ) ) {
			if( $_COOKIE['eldsjalForumRead'.$category['forumcategoryid']] < strtotime( $category['forumcategorylatestpost'] ) ) 
				$unReadFlag = "<img src=/images/icons/new_topic.gif>";
			else 
				$unReadFlag = "<img src=images/icons/folder.gif border=0>";
		}
		else 
			$unReadFlag = "<img src=images/icons/folder.gif border=0>";

		//This is the first row to be executed

		print "<tr class=ForumTopic1 onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#e0d1bc';\"><span style:background-color = \"#e0d1bc\"><td class=ForumTopic1>".$unReadFlag."</td><td class=ForumTopic1><a class=a2 href=forum.php?category=".$category['forumcategoryid'].">".$category['forumcategoryname']."</a></td><td><a class=a3 href=forum.php?category=".$category['forumcategoryid'].">".$category['forumcategorydesc']."</a></td><td align=center><b>".$category['forumcategorythreads']."</b></td><td align=right>".timeSince(strtotime( $category['forumcategorylatestpost'] ) )."</td></span></tr>";

		////      $category->moveNext;
	}
	$category = null;
	print "</td></tr></table>";
}

//}

?>
		
		</td>	
	</tr>
	
<?php require_once( 'bottomInclude.php' );?>