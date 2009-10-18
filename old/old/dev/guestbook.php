<?php require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
	<div class="column column-left grid_3 prefix_1">

<?php if( $_SESSION['userid'] == intval( $_GET['userid'] ) ) {
	$sql = "update guestbook set unread = 0 where touserid = ".$_SESSION['userid'];
	$updated = $conn->execute( $sql );
}?>
<?php require_once( 'toolbox.applet.php' );
require_once( 'action.applet.php' );
require_once( 'wiseBox.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'userHistory.applet.php' );?>
	</div>
	<div class="column column-middle grid_8">
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
<?php if( isset( $_GET['message'] ) ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}?>
<div class=presentationTop><?php require_once( 'userPageLocation.applet.php' );?></div>
<div class="presentationSub"> </div>
<span class="plainThead2">
<?php 
if( $_GET['userid'] == "" ) {
	print "<br/><br/><img src=\"images/urkult.jpg\" width=\"400\" height=\"209\"><br/><br/>";
	print "N&aring;got har blivit fett med knas nu, f&ouml;r jag fattar inte vems g&auml;stbok du vill smygtitta i. G&aring; tillbaka till personen du s&ouml;kers presentationssida och prova igen!<br/><br/>LYCKA TILL!<br/><br/><a class=\"a2\" href=\"members.php\">G&aring; till medlemssidan och s&ouml;k >></a></span>";
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "edit" ) {
	$sql = "select message,guestbookid from guestbook where guestbookid = '".intval( $_GET['guestbookid'] )."' and fromuserid = '".$_SESSION['userid']."'";
	$guestBook = $conn->execute( $sql );
	// $guestBooks = $guestBook;
	// 	foreach( $guestBooks as $guestBook ) {
		print "<form  name=\"editGuestbook\" action=\"guestbookAct.php?mode=edit&userid=".$_GET['userid']."\" method=\"post\" ID=\"editGuestbook\">";
		?>
<textarea class="addGb" name="guestbookEntry" id="guestbookEntry" cols="74" rows="30"><?php     echo rqForm( $guestBook['message'] );?></textarea>
&Auml;ndra
<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
<input type="hidden" name="guestbookid" value="<?php     echo $guestBook['guestbookid'];?>" id="Hidden1" id="Hidden2"/>
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
	$sql = "replace into history (action, userid, nick, message, [date], security) values ('guestbookedit',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." &auml;ndrar i sitt g&auml;stboksinl&auml;gg i ".$gbname['username']."s g&auml;stbok', getdate(), 0)";
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
		$sql = "replace into history (action, userid, nick, message, [date], security) values ('guestbookuserview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." l&auml;ser sin g&auml;stbok', getdate(), 0)";
	}
	else {
		$sql = "select username from users where userid = ".intval( $_GET['userid'] );
		$username = $conn->execute( $sql );
		$sql = "replace into history (action, userid, nick, message, [date], security) values ('guestbookuserview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." kikar i ".$username['username']."s g&auml;stbok', getdate(), 0)";
			
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

			print "<tr><td class=\"guestBookEntry\"><a class=\"a2\" href=\"userPresentation.php?userid=".$guestBookList['userid']."\">:: ".$guestBookList['username']."</a>";
			if( intval( $guestBookList['hasimage'] ) == true ) {
				print "<img class=\"gbImage\" src=\"uploads/userImages/tn_".$guestBookList['userid'].".jpg\">";
			}
			else {
				print "<img class=\"gbImage\" src=\"images/ingetfoto.gif\">";
			}
			print "</td><td colspan=2 class=\"guestBookEntry\">";
			if( $_SESSION['userid'] == $guestBookList['touserid'] ) {
				print "[<a class=\"a2\" href=\"guestbook.php?userid=".$guestBookList['userid']."\">svara</a>] - <a class=\"a2\" href=\"guestbookAct.php?mode=delete&userid=".$_GET['userid']."&guestbookid=".$guestBookList['guestbookid']."\">"."\r\n"."<img src=images/icons/trashcan.gif border=0></a>"."\r\n";
			}
			if( $_SESSION['userid'] == $guestBookList['fromuserid'] ) {
				print "\r\n"." <a class=\"a2\" href=\"guestbookAct.php?mode=delete&userid=".$_GET['userid']."&guestbookid=".$guestBookList['guestbookid']."\">"."\r\n"."<img src=images/icons/trashcan.gif border=0></a> <a class=\"a2\" href=\"guestbook.php?mode=edit&userid=".$_GET['userid']."&guestbookid=".$guestBookList['guestbookid']."\">"."\r\n"."<img src=images/icons/edit.gif border=0></a>"."\r\n";
			}
			print " - ".$gbDate."<br/>"."\r\n".rq( $guestBookList['message'] )."\r\n"."</td></tr><tr><td colspan=3>&nbsp;</td></tr>"."\r\n";
		}
		print "</table";
		makePager( 'guestbook.php?userid='.$_GET['userid'].'&page=', $itemCount, $page );
	}
}
?>
	</div>
	<div class="column column-right grid_3">
<?php require_once( 'grejsBox.applet.php' );
require_once( 'addgbentry.applet.php' );
require_once( 'calendar.php' );
require_once( 'image.applet.php' );?>	
	</div>
	</div>
	</div>
<?php require_once( 'footer.php' );?>
