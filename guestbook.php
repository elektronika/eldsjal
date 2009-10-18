<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
session_register( "usertype_session" );
?>
<?php require_once( 'topInclude.php' );?>
<?php 
if( $_SESSION['userid'] == intval( $_GET['userid'] ) ) {
	$sql = "update guestbook set unread = 0 where touserid = ".$_SESSION['userid'];
	$updated = $conn->execute( $sql );
}
?>
<tr>
<td valign="top">
	<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
	</div>	
	<div class="boxLeft">
		<h3 class="boxHeader">just nu:</h3>
		<h4 class="boxContent"><?php require_once( 'action.applet.php' );?></h4>
	</div>
	<div class="boxLeft">
		<h3 class="boxHeader">Visheter:</h3>
		<h4 class="boxContent"><?php require_once( 'wiseBox.applet.php' );?></h4>
	</div>
	<div class="boxLeft">
		<h3 class="boxHeader">nya tankar:</h3>
		<h4 class="boxContent"><?php require_once( 'diarys.applet.php' );?></h4>
	</div>
	<div class="boxLeft">
		<h3 class="boxHeader">senast inloggade:</h3>
		<h4 class="boxContent"><?php require_once( 'userHistory.applet.php' );?></h4>
	</div>
</td>
<script type="text/javascript" language="javascript">
function openInfo(url){
window.open(url, 'svar', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=auto,resizable=yes,directories=no,location=no,left=80,top=30,width=200,height=300');
}
</script>
<?php 
if( $_GET['userid'] != "" ) {
	$uID = $_GET['userid'];
}
if( $_SESSION['userid'] == "" ) {
	if( $uID != "" ) {
		header( "Location: "."userPresentation.php?userid=".$uID."&message=Du &auml;r inte inloggad" );
	}
	else {
		header( "Location: "."main.php?message=Du &auml;r inte inloggad" );
	}
}
$sessionid = $_SESSION['userid'];
$cpid = $_GET['userid'];
?>
<td height="190" valign="top">
<?php if( isset( $_GET['message'] ) ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}?>
<div class=presentationTop><?php require_once( 'userPageLocation.applet.php' );?></div>
<div class="presentationSub"> </div>
<span class="plainThead2">
<?php 
if( $_GET['userid'] == "" ) {
	print "<br><br><img src=\"images/urkult.jpg\" width=\"400\" height=\"209\"><br><br>";
	print "N&aring;got har blivit fett med knas nu, f&ouml;r jag fattar inte vems g&auml;stbok du vill smygtitta i. G&aring; tillbaka till personen du s&ouml;kers presentationssida och prova igen!<br><br>LYCKA TILL!<br><br><a class=\"a2\" href=\"members.php\">G&aring; till medlemssidan och s&ouml;k >></a></span>";
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "edit" ) {
	$sql = "select message,guestbookid from guestbook where guestbookid = '".intval( $_GET['guestbookid'] )."' and fromuserid = '".$_SESSION['userid']."'";
	$guestBook = $conn->execute( $sql );
	// $guestBooks = $guestBook;
	// 	foreach( $guestBooks as $guestBook ) {
		print "<form  name=\"editGuestbook\" action=\"guestbookAct.php?mode=edit&userid=".$_GET['userid']."\" method=\"post\" ID=\"editGuestbook\">";
		?>
<textarea class="addGb" name="guestbookEntry" ID="guestbookEntry" cols="74" rows="30"><?php     echo rqForm( $guestBook['message'] );?></textarea>
&Auml;ndra
<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
<input type="hidden" name="guestbookid" value="<?php     echo $guestBook['guestbookid'];?>" ID="Hidden1" ID="Hidden2">
</form>
<?php
		//    $guestBook->moveNext;
	// }

	//Logger

	$sql = "select touserid from guestbook where guestbookid = ".intval( $_GET['guestbookid'] );
	$guestbook = $conn->execute( $sql );
	$sql = "select username from users where userid = ".$guestbook['touserid'];

	//SQL = "SELECT userName FROM users WHERE userid = " & cpid

	$gbName = $conn->execute( $sql );
	$sql = "insert into history (action, userid, nick, message, [date], security) values ('guestbookedit',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." &auml;ndrar i sitt g&auml;stboksinl&auml;gg i ".$gbname['username']."s g&auml;stbok', getdate(), 0)";
	$conn->execute( $sql );
	$guestBook = null;
	$gbName = null;
}
else {
	if( isset( $_GET['page'] ) && $_GET['page'] != "" ) {
		$page = intval( $_GET['page'] );
	}
	else 
		$page = 1;
	$sql = "select users.username, users.hasimage, users.userid, guestbook.fromuserid, guestbook.touserid, guestbook.guestbookid, guestbook.date, guestbook.message from guestbook inner join users on guestbook.fromuserid = users.userid where guestbook.touserid = ".intval( $_GET['userid'] )." order by guestbook.date desc";
		

	//SQL = "SELECT top 512 * FROM guestbook INNER JOIN users ON guestbook.fromuserid = users.userid WHERE touserid = " & Cint(request.QueryString("userid")) & " ORDER BY date DESC"
	//response.Write(SQL)
	//SET guestBookList = conn.execute(SQL)
	// $guestBookList is of type "adodb.recordset"
	//guestBookList.MaxRecords = 20

	$guestBookList = $conn->execute( $sql );

	//print_r($guestBookList);
	//Logger

	if( intval( $_GET['userid'] ) == intval( $_SESSION['userid'] ) ) {
		$sql = "insert into history (action, userid, nick, message, [date], security) values ('guestbookuserview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." l&auml;ser sin g&auml;stbok', getdate(), 0)";
	}
	else {
		$sql = "select username from users where userid = ".intval( $_GET['userid'] );
		$username = $conn->execute( $sql );
		$sql = "insert into history (action, userid, nick, message, [date], security) values ('guestbookuserview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." kikar i ".$username['username']."s g&auml;stbok', getdate(), 0)";
			
		$userName = null;
	}
	$conn->execute( $sql );
	if(( $guestBookList == 0 ) ) {
		print "Tr&aring;kigt, ingen i heeeela eldsj&auml;l har skrivit ett endaste litet inl&auml;gg, bli f&ouml;rst nu!";
	}
	else {
		$itemCount = count( $guestBookList );
		makePager( 'guestbook.php?userid='.$_GET['userid'].'&page=', $itemCount, $page );
		print "<table border=0 cellspacing=0 cellpadding=2>";
		if( !is_array( current( $guestBookList ) ) ) 
			$guestBookList = array(
				$guestBookList,
			);
		$guestBookLists = paginate( $guestBookList, $page );
		foreach( $guestBookLists as $guestBookList ) {
			$gbDate = timeSince(strtotime( $guestBookList['date'] ) );

			//$FormatDateTime[$guestBookList['date']][$vbShortTime]." - ".$formatDateTime[$guestBookList['date']][$vbShortDate];

			print "<tr><td class=\"guestBookEntry\" valign=top><a class=\"a2\" href=\"userPresentation.php?userid=".$guestBookList['userid']."\">:: ".$guestBookList['username']."</a>";
			if( intval( $guestBookList['hasimage'] ) == true ) {
				print "<img class=\"gbImage\" src=\"uploads/userImages/tn_".$guestBookList['userid'].".jpg\">";
			}
			else {
				print "<img class=\"gbImage\" src=\"images/ingetfoto.gif\">";
			}
			print "</td><td colspan=2 class=\"guestBookEntry\" valign=top>";
			if( $_SESSION['userid'] == $guestBookList['touserid'] ) {
				print "[<a class=\"a2\" href=\"guestbook.php?userid=".$guestBookList['userid']."\">svara</a>] - <a class=\"a2\" href=\"guestbookAct.php?mode=delete&userid=".$_GET['userid']."&guestbookid=".$guestBookList['guestbookid']."\">"."\r\n"."<img src=images/icons/trashcan.gif border=0></a>"."\r\n";
			}
			if( $_SESSION['userid'] == $guestBookList['fromuserid'] ) {
				print "\r\n"." <a class=\"a2\" href=\"guestbookAct.php?mode=delete&userid=".$_GET['userid']."&guestbookid=".$guestBookList['guestbookid']."\">"."\r\n"."<img src=images/icons/trashcan.gif border=0></a> <a class=\"a2\" href=\"guestbook.php?mode=edit&userid=".$_GET['userid']."&guestbookid=".$guestBookList['guestbookid']."\">"."\r\n"."<img src=images/icons/edit.gif border=0></a>"."\r\n";
			}
			print " - ".$gbDate."<BR>"."\r\n".rq( $guestBookList['message'] )."\r\n"."</td></tr><tr><td colspan=3>&nbsp;</td></tr>"."\r\n";
		}
		print "</table";
		makePager( 'guestbook.php?userid='.$_GET['userid'].'&page=', $itemCount, $page );
	}
}
?>
</td>
<td width="145" height="109" valign="top" align="right">	
	<div class="boxRight" align="left">
		<h3 class="boxHeader">Grejsl&aring;dan</h3>
		<h4 class="boxContent"><?php require_once( 'grejsBox.applet.php' );?></h4>
	</div>
	<div class="boxRight">
		<h3 class="boxHeader">Skriv inl&auml;gg!</h3>
		<h4 class="boxContent"><?php require_once( 'addGBEntry.applet.php' );?></h4>
	</div>
	<div class="boxRight">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar"><?php require_once( 'calendar.php' );?></h4>
	</div>
	<div class="boxRight">
		<h3 class="boxHeader">Senaste bilder:</h3>
		<h4 class="boxContent"><?php require_once( 'image.applet.php' );?></h4>
	</div>	
</td>
</tr>
<?php require_once( 'bottomInclude.php' );?>
