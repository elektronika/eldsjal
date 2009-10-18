<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>
		<?php 
if( $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] < $application['imageadmin'] ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}?>
	<tr>
		<td valign="top" align="left">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>	
	
		<div class="boxLeft">
		<h3 class="boxHeader">
		senast inloggade:
		</h3>
		<h4 class="boxContent">
		<?php require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>
		</td>
	
	<?php 
if( $_GET['mode'] == "delete" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."gallery.php?message=Du är inte inloggad eller saknar rättighet att utföra detta kommando!" );
	}
	if( $_GET['imageid'] == "" ) {
		header( "Location: "."gallery.php?message=Ingen bild angedd!" );
	}
	if( $_SESSION['usertype'] < $application['imageadmin'] ) {
		$sql = "select imageid from images where uploadedby = ".$_SESSION['userid']." and imageid = ".intval( $_GET['imageid'] );
		$uploader = $conn->execute( $sql );
		if( !$uploader ) {
			header( "Location: "."gallery.php?message=Du är inte inloggad eller saknar rättighet att utföra detta kommando!" );
		}
	}
	$sql = "delete from images where imageid = ".intval( $_GET['imageid'] );
	$conn->execute( $sql );
	$sql = "delete from imageartlist where imageid = ".intval( $_GET['imageid'] );
	$conn->execute( $sql );
	$sql = "delete from imagescore where fkimageid = ".intval( $_GET['imageid'] );
	$conn->execute( $sql );

	$deleteFile = $application['galleryimagepath']."/".$_GET['imageid'].".jpg";
	if( file_exists( $deleteFile ) ) {
		unlink( $deleteFile );
	}
	$deleteFile = $application['galleryimagepath']."/tn_".$_GET['imageid'].".jpg";
	if( file_exists( $deleteFile ) ) {
		unlink( $deleteFile );
	}
	// $deleteFile = "c:\\web\\www.eldsjal.org\\images\\galleryImages\\original_".$_GET['imageid'].".jpg";
	// if( file_exists( $deleteFile ) ) {
	// 	unlink( $deleteFile );
	// }
	// $deleteFile = "c:\\web\\www.eldsjal.org\\images\\galleryImages\\tn_".$_GET['imageid'].".jpg";
	// if( file_exists( $deleteFile ) ) {
	// 	unlink( $deleteFile );
	// }
	// $deleteFile = "c:\\web\\www.eldsjal.org\\images\\galleryImages\\".$_GET['imageid'].".jpg";
	// if( file_exists( $deleteFile ) ) {
	// 	unlink( $deleteFile );
	// }
	if( $_GET['categoryid'] != "" ) {
		$message = "?categoryid=".$_GET['categoryid']."&message=Bild borttagen";
	}
	elseif( $_GET['userid'] != "" ) {
		$message = "?userid=".$_GET['userid']."&message=Bild borttagen";
	}
	else {
		$message = "?message=Bild borttagen!";
	}
	header( "Location: "."gallery.php".$message );
}
elseif( $_GET['mode'] == "reindex" ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_SESSION['usertype'] < 5 ) {
		header( "Location: "."main.php?message=Du &auml;r inte inloggad eller saknar r&auml;ttighet att utf&ouml;ra detta kommando!" );
	}
	print "Tar bort alla m&auml;rkta med 'Under Uppladdning'...<br>";
	$sql = "delete from images where imagename = 'under uppladdning'";
	$pumpit = $conn->execute( $sql );
	print "Alla 'Under Uppladdning' borttagna!<br><br>";
	print "Tar bort alla bilder som saknar kategori...<br>";
	$sql = "delete from images where imageid not in (select imageid from imageartlist)";
	$pumpit = $conn->execute( $sql );
	print "Alla bilder som inte finns representerade i imageArtList borttagna!<br><br>";
	print "Tar bort alla bilder som finns i kategorierna men inte i bildm&auml;ngden<br>";
	$sql = "delete from imageartlist where imageid not in (select imageid from images)";
	$pumpit = $conn->execute( $sql );
	print "Alla bilder i imageArtList som inte finns i images borttagna!<br><br>";
	print "Tar bort alla bilder som har betyg satta men inte l&auml;ngre finns i m&auml;ngden...<br>";
	$sql = "delete from imagescore where fkimageid not in (select imageid from images)";
	$pumpit = $conn->execute( $sql );
	print "Alla bilder med betyg som inte finns i images borttagna!<br><br>";
	$pumpit = null;
	print "<a href=image.tool.php class=a3>FORTS&Auml;TT!</a>";
}
elseif( $_GET['mode'] == "" ) {
	?>
	
	<td width="400" height="300" valign="top">
	Denna sida l&aring;ter dig ta bort bilder p&aring; deras ID-nummer, en och en. Den erbjuder &auml;ven dig att ta bort alla instanser av fall d&auml;r bilder saknas men finns refererade till i DB.
	<br>
	<br>
	<font color="RED"><?php   echo $_GET['message'];?></font>
	<form name="imageTool" action="image.tool.php" method="get">
		Bildid:&nbsp;<input type="text" name="imageid" ID="Text1">
		<input type="hidden" name="mode" value="delete">
		Vidare<input type="image" src="images/icons/arrows.gif" name="proceed">
		
	</form>
	
	<a href="image.tool.php?mode=reindex" class="a3">&Aring;terindexera bildm&auml;ngd</a>	
	</td>
		
	</tr>
	
<?php
}
?>
	
<?php require_once( 'bottomInclude.php' );?>
