<?php
session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
$dont_display_header = TRUE;
require_once( 'topInclude.php' );
$tempUser = $_SESSION['userid'];
if( $tempUser == "" ) {
	$tempUser = 0;
}
print isset( $_GET['message'] ) ? $_GET['message'] : '';
// $sql = "select * from imagescore where userid = ".$tempUser." and imagescore.fkimageid = ".intval( $_GET['imageid'] );
// $voteCheck = $conn->execute( $sql );
// if( isset( $_GET['mode'] ) && $_GET['mode'] == "vote" ) {
// 	$sql = "delete from imagescore where userid = '".$_SESSION['userid']."' and fkimageid = '".intval( $_POST['imageid'] )."'";
// 	$deleteRow = $conn->execute($sql);
// 	$sql = "insert into imagescore (fkimageid, userid, score) values ('".intval( $_POST['imageid'] )."', '".$_SESSION['userid']."', '".intval( $_POST['score'] )."')";
// 	$vote = $conn->execute($sql);
// 	header( "Location: "."viewPicture.php?imageid=".$_POST['imageid']."&message=Po&auml;ngen inf&ouml;rd!&click=no" );
// }
// else 
{
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
		<link rel="stylesheet" href="style.css" TYPE="text/css">
		<meta name="GENERATOR" content="Microsoft Visual Studio.NET 7.0">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta name="Expires" content="<?php echo time( );?>">
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	</head>
	<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" bgcolor="#ffcc66">
	<br><div align="center">
<?php
	$sql = "select users.username, users.userid, images.imagename, images.imagedesc, images.imageid, images.imageuploaddate, images.uploadedby, images.filetype, images.clicks from images inner join users on images.uploadedby = users.userid where images.imageid = ".intval( $_GET['imageid'] );
	$imageInfo = $conn->execute( $sql );
	// print_r($imageInfo);
	if( !( $imageInfo == 0 ) ) {
		$sql = "select imageartlist.artid, imageartlist.imageid, artlist.artname from imageartlist left join artlist on imageartlist.artid = artlist.artid where imageartlist.imageid = ".$_GET['imageid'];
		$categorys = $conn->execute( $sql );
		// $sql = "select sum(imagescore.score) as score from imagescore where fkimageid = ".$_GET['imageid'];
		// $imageScore = $conn->execute( $sql );
		// $sql = "select count(*) as votes from imagescore where fkimageid = ".$_GET['imageid'];
		// $totalVotes = $conn->execute( $sql );
		if( !isset( $_GET['click'] ) || $_GET['click'] != "no" ) {
			$clickTest = $conn->execute( "select clicks FROM images WHERE imageid = ".intval( $_GET['imageid'] ) );
			if( !( $clickTest == 0 ) || $clickTest['clicks'] == 0 ) 
				$conn->execute( "UPDATE images SET clicks = clicks + 1 WHERE imageid = ".$_GET['imageid'] );
		}
		else {
			//$sql="INSERT INTO images (imageid, Clicks) VALUES (".intval($_GET['imageid']).", 1)";
			//$conn->execute($sql);
		}
	}
	if( is_array( current( $imageInfo ) ) ) 
		$imageInfo = current( $imageInfo );
	print "<div class=mediumBox><b><span class=plainThead>".$imageInfo['imagename']."</b></span><br><a href=uploads/galleryImages/original_".$imageInfo['imageid'].".".$imageInfo['filetype']."><img src=\"uploads/galleryImages/".$_GET['imageid'].".".$imageInfo['filetype']."\" border = 0></a><br><br><br>Uppladdad av: <a href=\"/user/".$imageInfo['userid']."\">".$imageInfo['username']."</a><br>Kategorier: ";
	if( $categorys ) {
		$kCount = 0;
		$categoryss = $categorys;
		if( !is_array( current( $categoryss ) ) ) 
			$categoryss = array(
				$categoryss,
			);
		foreach( $categoryss as $categorys ) {
			if( $kCount != 0 ) 
				print ", ";
			print $categorys['artname'];
			$kCount = $kCount + 1;
		}
	}
	else 
		print "Inga kategorier angivna p&aring; denna bild!";
	print "<br><b>Bildtext:<br>".rq( $imageInfo['imagedesc'] );
/*	if( $totalVotes['votes'] > 0 ) 
		$totalScore = round( $imageScore['score'] / $totalVotes['votes'], 1 );
	else 
		$totalScore = 0;
	print "Bilden har snittbetyg ".$totalScore." och ".$totalVotes['votes']."har r&ouml;stat!<br>";
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		print "<form action=\"\" method=\"post\" name=\"vote\" onSubmit=\"javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\">";
		$action = "\"javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\"";
	}
	else {
		print "<form action=\"viewPicture.php?mode=vote\" method=\"post\" name=\"vote\">";
		$action = "form.submit();";
	}
	if( $voteCheck ) 
		$scoreValue = $voteCheck['score'];
	else 
		$scoreValue = 0;
	$totalScore = round( $totalScore, 0 );
	?>	
	<input name="score" type="radio" onclick=<?php echo $action;?> value=1 <?php if( $totalScore <= 1 ) 
		print "checked ";?>>1
	<input name="score" type="radio" onclick=<?php echo $action;?> value=2 <?php if( $totalScore == 2 ) 
		print "checked ";?>>2 
	<input name="score" type="radio" onclick=<?php echo $action;?> value=3 <?php if( $totalScore == 3 ) 
		print "checked ";?>>3 
	<input name="score" type="radio" onclick=<?php echo $action;?> value=4 <?php if( $totalScore == 4 ) 
		print "checked ";?>>4 
	<input name="score" type="radio" onclick=<?php echo $action;?> value=5 <?php if( $totalScore == 5 ) 
		print "checked ";?>>5
	<input type="hidden" name="imageid" value="<?php echo $_GET['imageid'];?>">
	</form>
	*/ ?>
				<script language="javascript">
			<!--
			function CheckGB() {
			if (document.addGuestbook.guestbookEntry.value == '') {
			alert("Du m&aring;ste skriva n&aring;tt ju!");
			document.addGuestbook.guestbookEntry.focus();
			return false;
			}
			return true;
			}
			-->
			</script>
<?php
		
if(( $_SESSION['userid'] != "" ) && ( $_SESSION['userid'] != $imageInfo['userid'] )) {
		print "<form name=\"addGuestbook\" action=\"guestbookAct.php?mode=addEntry&userid=\"".$imageInfo['userid']." method=\"post\" ID=\"addGuestbook\" onSubmit=\"return CheckGB();\">";
		?>
Kommentera bilden i g&auml;stbok:<br>
<textarea class="addGb" style="" name="guestbookentry" ID="guestbookEntry" cols="30" rows="10"></textarea>
<br>Skicka
<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
<input type="hidden" name="touserid" value="<?php echo $imageInfo['userid'];?>" ID="Hidden1" ID="Hidden2">
<input type="hidden" name="tousername" value="<?php echo $imageInfo['username'];?>" ID="Hidden3" ID="Hidden1">
<input type="hidden" name="redirect" value="<?php echo $imageInfo['imageid'];?>" ID="Hidden3" ID="Hidden1">
<input type="hidden" name="imagename" value="<?php echo $imageInfo['imagename'];?>" ID="Hidden3" ID="Hidden1">
</form><?php
	if( $_SESSION['usertype'] >= $application['imageadmin'] ) {
			$approve = $conn->execute( "SELECT approved FROM images WHERE imageid = ".$imageInfo['imageid'] );
			if( $approve['approved'] == true ) 
				print "<a href=imageApprove.php?mode=disapprove&imageid=".$imageInfo['imageid'].">&Aring;ngra godk&auml;nd!</a>";
			else 
				print "<a href=imageApprove.php?mode=approve&imageid=".$imageInfo['imageid'].">Godk&auml;nn f&ouml;r f&ouml;rstasida</a>";
			print "&nbsp;|&nbsp;";
			$approve = $conn->execute( "SELECT private FROM images WHERE imageid = ".$imageInfo['imageid'] );
			if( $approve['private'] == true ) 
				print "<a href=imagePrivate.php?mode=public&imageid=".$imageInfo['imageid'].">Flytta till galleriet!</a>";
			else 
				print "<a href= imagePrivate.php?mode=private&imageid=".$imageInfo['imageid'].">Flytta till personen</a>";
		}
	}
}?>
</div>
</body>
<?php
/*
else
	print "Denna bild har inte konsekvent information i databasen, mest troligt pga. att uppladdaren gl&ouml;mt att kryssa i minst en kategori. D&auml;rf&ouml;r kan itne bilden visas och kommer att tas bort igen, hoppas uppladdaren f&ouml;rs&ouml;ker ladda upp igen!";
*/

?>
</html>