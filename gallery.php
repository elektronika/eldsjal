<?php
//  session_start();

session_register( "userid_session" );
session_register( "userType_session" );
session_register( "username_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
require( 'topInclude.php' );
?>
<?php require_once( 'topInclude.php' );?>
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
		senast inloggade:</h3>
		<h4 class="boxContent">
		<?php require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>
			
	</td>
		<script language="javascript">
		
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}

		function openImage(url,x,y,qs)
		{
		if (x > 800) 
			{ 
			x = 800;
			}
		if (y > 600)
			{
			y = 600;
			}
		window.open(url, 'galleryImage', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,directories=no,location=no,left=80,top=30,width=' + x + ',height=' + y);
		}
		</script>

				<!--
		Include this line in the javascript-function to have the automatic reload of gallery
		window.self.location='gallery.php?' + qs;
		-->
		
		
		<td height="190" valign="top"><?php if( isset( $_GET['message'] ) ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}

//SQL = "SELECT DISTINCT artList.artid, artList.artName, imageArtList.artid, imageArtList.imageid FROM artList INNER JOIN imageArtList ON imageArtList.artid = artList.artid INNER JOIN images ON imageArtList.imageid = images.imageid"

$sql = "select distinct imageartlist.artid, artlist.artname from imageartlist inner join artlist on artlist.artid = imageartlist.artid";
$categorys = $conn->execute( $sql );
?>		
		<!--<div class="plainText">
		Galleriet &auml;r v&aring;r stolthet som vi bygger tillsammans!
		<br>
		Detta galleri &auml;r uppdelat i flera kategorier som var f&ouml;r sig inneh&aring;ller bilder. Det &auml;r m&ouml;jligt att titta p&aring; bilder efter vilket betyg de f&aring;tt, slumpa fram bilder, se dem i en slideshow mm. Gl&ouml;m inte att r&ouml;sta p&aring; bilder s&aring; vi f&aring;r n&aring;gon ordning h&auml;r!
		</div>-->
		<?php 
if(!isset($_GET['mode']) && !isset($_GET['categoryid']) && !isset($_GET['userid'])) {
	$sql = "select images.uploadedby,images.width, images.height, images.imageid, images.imagename, images.filetype, images.clicks from images where private = 0 order by imageuploaddate desc limit 52";
	$dbImages = $conn->execute( $sql );
} else {

if( isset( $_GET['mode'] ) && $_GET['mode'] != "firstpage" || isset( $_GET['categoryid'] ) || isset( $_GET['userid'] ) ) {
	if( !isset( $_GET['categoryid'] ) && !isset( $_GET['userid'] ) ) {
		if( $_GET['mode'] == "all" ) {
			$sql = "select images.uploadedby,images.width, images.height, images.imageid, images.imagename, images.filetype, images.clicks from images where private = 0 order by imageuploaddate desc limit 120";
		}
		else {
			$sql = "select images.uploadedby,images.width, images.height, images.imageid, images.imagename, images.filetype, images.clicks from images where private = 0 order by imageuploaddate desc limit 52";
		}
		$dbImages = $conn->execute( $sql );
	}
	elseif( isset( $_GET['userid'] ) && $_GET['userid'] != "" ) {
		$sql = "select username from users where userid = ".intval( $_GET['userid'] );
		$dbusername = $conn->execute( $sql );
		$sql = "select distinct images.uploadedby,images.width, images.height, images.imageid, images.imagename, images.filetype, images.clicks, images.uploadedby from images inner join imageartlist on images.imageid = imageartlist.imageid where images.uploadedby = ".$_GET['userid']." order by images.imageid desc";
		$dbImages = $conn->execute( $sql );
		print "<a class=\"a2\" href=\"userPresentation.php?userid=".$_GET['userid']."\">&laquo; Tillbaka till ".$dbusername['username']."'s presentation</a><br>";
	}
	else {
		$sql = "select images.uploadedby,images.width, images.height, images.imageid, images.imagename, images.filetype, images.clicks from images inner join imageartlist on images.imageid = imageartlist.imageid where imageartlist.artid = ".$_GET['categoryid']." and private = 0";
		$dbImages = $conn->execute( $sql );
	}
}
else {
	$sql = "select images.uploadedby, images.width, images.height, images.imageid, images.imagename, images.filetype, images.clicks from images where approved = 1 order by imageuploaddate desc";
	$dbImages = $conn->execute( $sql );
}
}
if( !$dbImages && $_GET['userid'] == "" ) 
	print "<br>Inga bilder finns &auml;nnu i galleriet, ladda upp den f&ouml;rsta vettja!";
elseif( !$dbImages && $_GET['userid'] != "" ) 
	print "<br>Inga bilder finns &auml;nnu i ".$dbusername['username']."'s privata galleri, ladda upp den f&ouml;rsta vettja!";
else {
	print "<table border=\"0\"><tr>";
	$iCount = 0;

	//$dbImages = $dbImage;
	if(!is_array(current($dbImages)))
		$dbImages = array($dbImages);
	foreach( $dbImages as $dbImage ) {
		//print_r($dbImage);

		$iWidth = $dbImage['width'] + 50;
		$iWidth = 900;
		$iHeight = $dbImage['height'] + 50;
		$iHeight = 700;
		if( isset( $_GET['userid'] ) && $_GET['userid'] != '' ) {
			// print "<td class=\"galleryThumb\" onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$dbImage['imageid']."','".$iWidth."','".$iHeight."','reloadMode=user&userid=".$_GET['userid']."&'); \"><img class=\"galleryThumb\" src=\"uploads/galleryImages/tn_".$dbImage['imageid'].".".$dbImage['filetype']."\" border=\"0\" alt=\"".$dbImage['imagename']."\"></a><br>Antal klick: ".$dbImage['clicks'];
			print "<td class=\"galleryThumb\" onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$dbImage['imageid']."','".$iWidth."','".$iHeight."','reloadMode=user&userid=".$_GET['userid']."&'); \"><img class=\"galleryThumb\" src=\"uploads/galleryImages/tn_".$dbImage['imageid'].".".$dbImage['filetype']."\" border=\"0\" alt=\"".$dbImage['imagename']."\"></a>";
		}
		elseif( isset( $_GET['categoryid'] ) && $_GET['categoryid'] != "" ) {
			// print "<td class=\"galleryThumb\" onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$dbImage['imageid']."','".$iWidth."','".$iHeight."','categoryid=".$_GET['categoryid']."&'); \"><img class=\"galleryThumb\" src=\"uploads/galleryImages/tn_".$dbImage['imageid'].".".$dbImage['filetype']."\" border=\"0\" alt=\"".$dbImage['imagename']."\"></a><br>Antal klick: ".$dbImage['clicks'];
			print "<td class=\"galleryThumb\" onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$dbImage['imageid']."','".$iWidth."','".$iHeight."','categoryid=".$_GET['categoryid']."&'); \"><img class=\"galleryThumb\" src=\"uploads/galleryImages/tn_".$dbImage['imageid'].".".$dbImage['filetype']."\" border=\"0\" alt=\"".$dbImage['imagename']."\"></a>";
		}
		else {
			// print "<td class=\"galleryThumb\" onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$dbImage['imageid']."','".$iWidth."','".$iHeight."',''); \"><img class=\"galleryThumb\" src=\"uploads/galleryImages/tn_".$dbImage['imageid'].".".$dbImage['filetype']."\" border=\"0\" alt=\"".$dbImage['imagename']."\"></a><br>Antal klick: ".$dbImage['clicks'];
			print "<td class=\"galleryThumb\" onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$dbImage['imageid']."','".$iWidth."','".$iHeight."',''); \"><img class=\"galleryThumb\" src=\"uploads/galleryImages/tn_".$dbImage['imageid'].".".$dbImage['filetype']."\" border=\"0\" alt=\"".$dbImage['imagename']."\"></a>";
		}
		if(( $_SESSION['usertype'] >= $application['imageadmin'] ) || ( $_SESSION['userid'] == $dbImage['uploadedby'] ) ) {
			print "&nbsp;&nbsp;<a href=\"image.tool.php?mode=delete&userid=".$dbImage['uploadedby']."&imageid=".$dbImage['imageid']."\" onClick=\"return confirmSubmit('&Auml;r du s&auml;ker p&aring; att du vill ta bort denna bild, f&ouml;r evigt?');\"><img src=\"/images/icons/trashcan.gif\" border=\"0\"></a>";
		}
		print "</td>";

		//response.Write("<td class=""galleryThumb"" onmouseover=""this.style.background='#EDE8DC';"" onmouseout=""this.style.background='#cccc99';""><a href=""javascript:openImage('viewPicture.php?imageid=" & dbImage("imageid") & "','500','500'); ""><img class=""galleryThumb"" src=""uploads/galleryImages/" & dbImage("imageid") & "." & dbImage("fileType") & """ width=""100"" height=""70"" border=""0"" alt=""" & dbImage("imageName") & """></a></td>")
		////    $dbImage->moveNext;

		$iCount = $iCount + 1;
		if( $iCount == 4 ) {
			print "</tr><tr>";
			$iCount = 0;
		}
	}
	if( isset( $_GET['mode'] ) && $_GET['mode'] == "all" ) {
		print "<a class=a2 href=gallery.php>Visa senaste 50&raquo;</a>";
	}
	else {
		print "<a class=a2 href=gallery.php?mode=all>Visa alla &raquo;</a>";
	}
	print "</tr></table>";
}
?>
		</td>
		
		<td valign="top" align="right">
		
		<div class="boxRight" align="left">
		<h3 class="boxHeader">
		Gallerier</h3>
		<h4 class="boxContent">
		<?php
//print_r($categorys);

foreach( $categorys as $category ) {
	print "<a href=\"gallery.php?categoryid=".$category['artid']."\" class=\"a2\">".$category['artname']."</a><br>";

	////  $category->moveNext;
}
print "<hr>";
print "<a href=\"gallery.php?mode=firstpage\" class=\"a2\">F&ouml;rstasidebilder</a><br>";
print "<a href=\"gallery.php\" class=\"a2\">Senaste</a><br>";
print "<a href=\"gallery.php?mode=all\" class=\"a2\">Alla</a><br>";
?>
		</h4>
		</div>
		
		
		<div class="boxRight">
		<h3 class="boxHeader">
		Ladda upp bild</h3>
		<h4 class="boxContent">
		<?php 
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	print "<a href=\"javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\">Nu &aring;ker vi &raquo;&raquo;</a>";
}
else {
	print "<a class=a2 href=\"javascript:openImage('imageUpload.php','350','600','')\">Nu &aring;ker vi<img src=images/icons/arrows.gif border=0></a>";
}
?>
</h4>
		</div>
		
		<div class="boxRight">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar">
				<?php require_once( 'calendar.php' );?>
		</h4></div>
				
		</td>
	</tr>
	
	
<?php require( 'bottomInclude.php' );?>







