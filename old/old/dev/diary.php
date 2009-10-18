<?php require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
<div class="column column-left grid_3 prefix_1">
<?php require_once( 'toolbox.applet.php' );

if( isset( $_GET['mode'] ) && $_GET['mode'] != "list" && $_GET['mode'] != "" ) {
	
require_once( 'addgbentry.applet.php' );

}

require_once( 'diarys.applet.php' );

if( $_SESSION['userid'] != "" ) {
	require_once( 'action.applet.php' );
}
require_once( 'calendar.php' );
require_once( 'wiseBox.applet.php' );
require_once( 'userHistory.applet.php' );require_once( 'image.applet.php' );?>
	</div>
	<div class="column column-middle grid_11">
<?php if( isset( $_GET['message'] ) ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "readDiary" ) {
	$sql = "select diary.userid, diary.diarytopic, diary.diarydate, diary.diary, users.username from diary inner join users on diary.userid = users.userid where diaryid = ".intval( $_GET['diaryid'] );
	$dbDiary = $conn->execute( $sql );
	if( !$dbDiary ) {
		header( "Location: "."main.php?message=Den tanken &auml;r borttagen!" );
	}
	$sql = "insert into diaryread (diaryid, userid, readdate) values (".intval( $_GET['diaryid'] ).", ".$_SESSION['userid'].", getdate())";
	$updateRead = $conn->execute( $sql );
	if( $_SESSION['userid'] != $dbDiary['userid'] ) {
		$sql = "update diary set diaryreads = diaryreads + 1 where diaryid = ".intval( $_GET['diaryid'] );
		$conn->execute( $sql );
	}
	$updateRead = null;

	//Logger

	if( $_SESSION['userid'] == $dbDiary['userid'] ) {
			$sql = "replace into history (action, userid, nick, message, [date], security) values ('diaryread',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." l&auml;ser sin egen tanke \"".$dbDiary['diarytopic']."\" ', getdate(), 0)";
	}
	else {
		$sql = "replace into history (action, userid, nick, message, [date], security) values ('diaryread',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." l&auml;ser ".$dbDiary['username']."s tanke \"".$dbDiary['diarytopic']."\" ', getdate(), 0)";
	}
	$result = $conn->execute( $sql );
	$result = null;
	print "<table border=1><a href=userPresentation.php?userid=".$dbDiary['userid']." class=a2>".$dbDiary['username']."'s presentation</a> - <a href=diary.php?userid=".$dbDiary['userid']." class=a2>visa alla ".$dbDiary['username']."'s tankar</a><br/>";

	//$dbDiarys = $dbDiary; foreach( $dbDiarys as $dbDiary)
	//{

	print "<tr><td class=diary><b>".rq( $dbDiary['diarytopic'] )."</b><div><a href=diary.php?userid=".$_GET['userid']." class=a2>&laquo; tillbaka</a></div></td></tr>";
	print "<tr><td class=diary>".rq( $dbDiary['diary'] )."</td></tr>";

	//    $dbDiary->moveNext;
	//}

	print "</table>";
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "writeAct" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?message=Du &auml;r inte inloggad, tryck bak&aring;t och kopiera texten om det blev knas" );
		exit();
	}
	
	$written = $conn->execute("select diaryid as did from diary where date(diarydate) = date(now()) and userid = ".$_SESSION['userid']);
	if($written) {
		header('diary.php?message=Du har redan skrivit dagens tanke!');
		exit();
	}
	
	$diarytext = CQ( $_POST['diary'] );
	$diarytopic = CQ( $_POST['diarytopic'] );
	$sql = "insert into diary (userid, diarydate, diarytopic, diary ) values (".$_SESSION['userid'].", getdate(), '".$diarytopic."', '".$diarytext."')";
	$conn->execute( $sql );

	header( "Location: "."diary.php?userid=".$_SESSION['userid'] );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "updateAct" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_POST['diaryid'] == "" ) {
		header( "Location: "."diary.php?message=Du &auml;r inte inloggad, tryck bak&aring;t och kopiera texten om det blev knas" );
	}
	$diarytext = CQ( $_POST['diary'] );
	$diarytopic = CQ( $_POST['diarytopic'] );
	$sql = "update diary set diarydate = getdate(), diarytopic = '".$diarytopic."', diary = '".$diarytext."' where userid = ".intval( $_SESSION['userid'] )." and diaryid = ".intval( $_POST['diaryid'] );

	$store = $conn->execute( $sql );
	$store = null;
	header( "Location: "."diary.php?userid=".$_SESSION['userid'] );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "write" || isset( $_GET['mode'] ) && $_GET['mode'] == "update" ) {
	?>

			<script language="javascript">
			<!--

			function CheckForm() {

			if (document.addDiary.diaryTopic.value == '') {
			alert("Du m&aring;ste ange en rubrik!");
			document.addDiary.diaryTopic.focus();
			return false;
			}
			return true;
			}
			
			-->
			</script>
<?php 
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?Message=Du &auml;r inte inloggad" );
	}
	if( isset( $_GET['mode'] ) && $_GET['mode'] == "update" ) {
		print "<form name=\"addDiary\" action=\"diary.php?mode=updateAct\" method=\"post\" ID=\"addDiary\" onSubmit=\"return CheckForm();\">";
		$sql = "select diarytopic, diary from diary where diaryid = ".intval( $_GET['diaryid'] )." and userid = ".$_SESSION['userid'];
		$diary = $conn->execute( $sql );
		$diaryTopic = RQform( $diary['diarytopic'] );
		$diaryText = RQform( $diary['diary'] );

		//Logger

		$sql = "replace into history (action, userid, nick, message, [date], security) values ('diaryupdate',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." skriver om sin tanke \"".$diary['diarytopic']."\" ', getdate(), 0)";
		$result = $conn->execute( $sql );
		$diary = null;
		$result = null;
	}
	else {
		print "<form name=\"addDiary\" action=\"diary.php?mode=writeAct\" method=\"post\" ID=\"addDiary\" onSubmit=\"return CheckForm();\">";

		//Logger
		$sql = "replace into history (action, userid, nick, message, [date], security) values ('diarynew',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." skriver en ny tanke', getdate(), 0)";
		$result = $conn->execute( $sql );
		$result = null;
	}
	print "Inl&auml;gg i din tankesamling den ".date('Y-m-d')."<br/>";
	?>
			<br/>
			<div style='border: dashed olive 2px; font-weight: bolder; top: 5px; bottom: 5px; padding: 5px; width: 350px;'>
			Skriv vad ditt hj&auml;rta s&auml;ger, men t&auml;nk p&aring; att det du skriver kommer l&auml;sas av och p&aring;verka andra. N&auml;r en tanke v&auml;l finns g&aring;r det inte att &aring;ngra sig, gamla tankar g&aring;r inte att radera. T&auml;nk ocks&aring; p&aring; att vissa saker passar b&auml;ttre i forumet, t ex fr&aring;gor och diskussions&auml;mnen.
			</div><br/>
			<b>Rubrik: </b>
			<input name="diarytopic" id="diaryTopic" size="40" class="forum" value="<?php   echo $diaryTopic;?>"/><br/>
			<textarea class="addGb" name="diary" id="diary" cols="76" rows="30"><?php   echo $diaryText;?></textarea><br/>
			Spara
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			<input name="diaryid" id="diaryid" type="hidden" value="<?php   echo $_GET['diaryid'];?>"/>
			</form>
<?php
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "list" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."main.php?Message=Du &auml;r inte inloggad" );
	}
	$sql = "select diary.diaryreads, diary.diarytopic, diary.diarydate, diary.diaryid, users.username, users.userid from diary inner join users on diary.userid = users.userid order by diary.diarydate desc";
		
	$page = 1;
	if( isset( $_GET['page'] ) && $_GET['page'] != "" ) {
		$page = intval( $_GET['page'] );
	}

	$dbDiarys = $conn->execute( $sql );
	// print_r($dbDiarys);
	$iCount = 0;

	//Logger
	$sql = "replace into history (action, userid, nick, message, [date], security) values ('diarylistall',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." listar de senaste 50 tankarna', getdate(), 0)";
	
	$conn->execute( $sql );
	$iCount = 0;
	
	$itemCount = count($dbDiarys);
	makePager("diary.php?userid=".$_GET['userid']."&page=", $itemCount, $page);
	$dbDiaryss = paginate($dbDiarys, $page);
	if(!is_array(current($dbDiaryss)) )
		$dbDiaryss = array($dbDiaryss);
	// print_r($dbDiaryss);
		
	// print "<table marginwidth=0 marginheight=0 border=0>"."\r\n"."<tr><td colspan=3><b>tankar</b></td></tr><tr><td>f&ouml;rfattare</td><td width=600>Rubrik</td><td>l&auml;st</td><td width=150>Skrivet:</td></tr>";
	print "<table marginwidth=0 marginheight=0 border=0>"."\r\n"."<tr><td colspan=3><b>tankar</b></td></tr><tr><td>f&ouml;rfattare</td><td width=600>Rubrik</td><td width=150>Skrivet:</td></tr>";
	if($dbDiaryss) {
		foreach($dbDiaryss as $dbDiarys) {
			//SQL = "SELECT DISTINCT COUNT(userid) AS readCount FROM diaryRead WHERE diaryid = " & dbDiarys("diaryid")
			//	SET Count = conn.execute(SQL)

			$diaryTopic = CQ( $dbDiarys['diarytopic'] );

			//diaryText = CQ(dbDiarys("diary"))

			if( $iCount == 1 ) {
				// print "<tr><td><a href=userPresentation.php?userid=".$dbDiarys['userid']." class=a2>".$dbDiarys['username']."</a></td><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$dbDiarys['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".$dbDiarys['diaryreads']."</td><td>".$dbDiarys['diarydate']."</td></span></tr>";
				print "<tr><td><a href=userPresentation.php?userid=".$dbDiarys['userid']." class=a2>".$dbDiarys['username']."</a></td><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$dbDiarys['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".timeSince(strtotime($dbDiarys['diarydate']))."</td></span></tr>";
				$iCount = 0;
			}
			else {
				// print "<tr class=\"ForumTopic1\"><td><a href=userPresentation.php?userid=".$dbDiarys['userid']." class=a2>".$dbDiarys['username']."</a></td><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$dbDiarys['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".$dbDiarys['diaryreads']."</td><td>".$dbDiarys['diarydate']."</td></span></tr>";
				print "<tr class=\"ForumTopic1\"><td><a href=userPresentation.php?userid=".$dbDiarys['userid']." class=a2>".$dbDiarys['username']."</a></td><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$dbDiarys['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".timeSince(strtotime($dbDiarys['diarydate']))."</td></span></tr>";
				$iCount = 1;
			}
		}
	}
	makePager("diary.php?userid=".$_GET['userid']."&page=", $itemCount, $page);

	$iCount = 0;
	$dbDiarys = null;
	print "</table>";
}
else {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
	}
	if( isset( $_GET['message'] ) ) {
		print "<div class=\"message\">".$_GET['message']."</div>";
	}
	if( $_SESSION['userid'] == intval( $_GET['userid'] ) ) {
		$sql = "select diaryid as did from diary where date(diarydate) = date(now()) and userid = ".$_SESSION['userid'];	
		$written = $conn->execute( $sql );
		if( !$written ) {
			print "<a href=diary.php?mode=write class=a2>Skriv dagens tanke</a> ".date('Y-m-d')."<br/><br/>";
		}
		else {
			print "<a href=diary.php?mode=update&diaryid=".$written['did']." class=a2>Uppdatera dagens tanke</a><br/><br/>";
		}
	}

	//diary.diary,

	$sql = "select diary.diaryreads, diary.diarytopic, diary.diarydate, diary.diaryid, users.username, users.userid from diary inner join users on diary.userid = users.userid where diary.userid = ".$_GET['userid']." order by diary.diarydate desc";

	//SQL = "SELECT TOP 25 diary.diaryTopic, diary.diaryDate, diary.diary, diary.diaryid, users.userName, users.userid FROM diary INNER JOIN users ON diary.userid = users.userid WHERE diary.userid = " & request.QueryString("userid")  & " ORDER BY diaryDate DESC"
	//SET dbdiarys = conn.execute(sql)
	// $dbDiarys is of type "adodb.recordSet"

	$page = 1;
	if( isset( $_GET['page'] ) && $_GET['page'] != "" ) {
		$page = intval( $_GET['page'] );
	}
	$dbDiarys = $conn->execute( $sql );
	if( !$dbDiarys ) {
		print "h&auml;r &auml;r en till s&aring;dan d&auml;r historia...som aldrig tar slut...<br/>ty h&auml;r finns ingen b&ouml;rjan.<br/><br/><b>Anv&auml;ndaren har allts&aring; inte skrivit n&aring;gra tankar!</b>";
	}
	else {
		$itemCount = count($dbDiarys);
		makePager("diary.php?userid=".$_GET['userid']."&page=", $itemCount, $page);
		$dbDiaryss = paginate($dbDiarys, $page);
		if(!is_array(current($dbDiaryss)) )
			$dbDiaryss = array($dbDiaryss);

		$iCount = 0;
		$counter = 1;

		//Logger

		if( $_SESSION['userid'] != "" ) {
			if( $dbdiarys['userid'] = $_SESSION['userid'] ) {
				$sql = "replace into history (action, userid, nick, message, [date], security) values ('diarylistuser',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." listar alla sina tankar', getdate(), 0)";
			}
		}
		else {
			$sql = "replace into history (action, userid, nick, message, [date], security) values ('diarylistuser',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." listar alla tankar skrivna av \"".$dbDiaryss[0]['username']."\" ', getdate(), 0)";
		}
		$result = $conn->execute( $sql );
		$result = null;
	$iCount = 0;
	// print_r($dbDiaryss);
	// print "<table marginwidth=0 marginheight=0 border=0><tr><td colspan=3><b><a href=userPresentation.php?userid=".$dbDiaryss[0]['userid']." class=a2>".$dbDiaryss[0]['username']."'s</a> tankar</b></td></tr><tr><td>l&auml;st</td><td width=600>Rubrik</td><td width=150>Skrivet:</td></tr>";
	print "<table marginwidth=0 marginheight=0 border=0><tr><td colspan=3><b><a href=userPresentation.php?userid=".$dbDiaryss[0]['userid']." class=a2>".$dbDiaryss[0]['username']."'s</a> tankar</b></td></tr><tr><td width=600>Rubrik</td><td width=150>Skrivet:</td></tr>";
		// print_r($dbDiaryss);
	foreach( $dbDiaryss as $dbDiarys ) {
		//if not dbdiarys.eof then
		//SQL = "SELECT DISTINCT COUNT(userid) AS readCount FROM diaryRead WHERE diaryid = " & dbDiarys("diaryid")
		//SET Count = conn.execute(SQL)
		$diaryTopic = CQ( $dbDiarys['diarytopic'] );
		//diaryText = CQ(dbDiarys("diary"))
		if( $iCount == 1 ) {
			// print "<tr><td>".$dbDiarys['diaryreads']."</td><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$_GET['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".$dbDiarys['diarydate']."</td></span></tr>";
			print "<tr><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$_GET['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".timeSince(strtotime($dbDiarys['diarydate']))."</td></span></tr>";
			$iCount = 0;
		}
		else {
			// print "<tr class=\"ForumTopic1\"><td>".$dbDiarys['diaryreads']."</td><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$_GET['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".$dbDiarys['diarydate']."</td></span></tr>";
			print "<tr class=\"ForumTopic1\"><td><a class=\"a2\" href=\"diary.php?mode=readDiary&userid=".$_GET['userid']."&diaryid=".$dbDiarys['diaryid']."\"> ".$diaryTopic."</a></td><td>".timeSince(strtotime($dbDiarys['diarydate']))."</td></span></tr>";
			$iCount = 1;
		}
	}
	print "</table>";

	makePager("diary.php?userid=".$_GET['userid']."&page=", $itemCount, $page);
	}
}
?>
		
	</div>
	</div>
	</div>
<?php require_once( 'footer.php' );?>
