<?php
session_start( );
session_register( "userid_session" );
$dont_display_header = TRUE;
require_once( 'topInclude.php' );
?>

<?php ob_start( );

set_time_limit( 300 );

if( $_SESSION['userid'] == "0" || $_SESSION['userid'] == "" ) {
	print "<script language=javascript>window.close();</script>";
}

$strUploadPath = $application['originalimagepath'];
$originalImagePath = $application['originalimagepath'];

if( !in_array( $_FILES['file1']['type'], array( 'image/gif', 'image/jpg', 'image/jpeg', 'image/png', 'image/bmp' ) ) ) {
	header( "Location: "."imageUpload.php?message=Du får bara ladda upp bilder av typerna: BMP, JPG, PNG, GIF, PNG och TIFF" );
	exit( );
}
chmod( $_FILES['file1']['tmp_name'], 0777 );
/*
print $strUploadPath;

print '<br>';
if( file_exists( $_FILES['file1']['tmp_name'] ) ) 
	print 'filen finns<br>';
else 
	print 'filen finns inte<br>';
if( is_readable( $_FILES['file1']['tmp_name'] ) ) 
	print 'filen &auml;r l&auml;sbar<br>';
else 
	print 'filen &auml;r inte l&auml;sbar<br>';
if( is_writeable( $strUploadPath ) ) 
	print 'mappen &auml;r skrivbar<br>';
else 
	print 'mappen &auml;r inte skrivbar<br>';
*/
if( move_uploaded_file( $_FILES['file1']['tmp_name'], strtolower($strUploadPath.'/'.$_FILES['file1']['name']) ) ) {
	$file = $_FILES['file1'];
	$file['path'] = $struploadpath.'/'.$file['name'];
	$file['extension'] = end( explode( '.', $file['name'] ) );
} else {
	header("Location: "."imageUpload.php?message=Ingen bild blev uppladdad, försök igen");
	exit();
}
// pint_r( $file );
// exit( );
$sql = "insert into images (imagename, imagedesc, imageuploaddate, filetype, uploadedby) values ('under uppladdning', 'ingen beskrivning finns!', getdate(), 'jpg', '".$_SESSION['userid']."')";
$insertImage = $conn->execute( $sql );
$sql = "select max(imageid) as imageid from images";
$imageName = $conn->execute( $sql );
$originalImagePath = $application['originalimagepath']."/".$imageName['imageid'].'.'.strtolower($file['extension']);
rename($application['originalimagepath'].$file['path'], $originalImagePath);

$imageTransform = new ImageTransform();
$imageTransform->sourceFile = $originalImagePath;
// "Stor" version
$imageTransform->targetFile = 'uploads/galleryImages/'.$imageName['imageid'].'.jpg';
$imageTransform->resizeToHeight = 800;

if(!$imageTransform->resize()) {
	print_r($imageTransform->error);
} else {
	// print 'stor version skapad';
}
// print_r($imageTransform);

// Thumbnail
$imageTransform->targetFile = 'uploads/galleryImages/tn_'.$imageName['imageid'].'.jpg';
$imageTransform->resizeToWidth = 100;

if(!$imageTransform->resize()) {
	print_r($imageTransform->error);
} else {
	// print 'thumbnail skapad';
}

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
	<script language="javascript">
	<!--
	function CheckForm() {

	if (document.regInfo.imageName.value == '') {
	alert("Du m&aring;ste ange ett bildnamn!");
	document.regInfo.imageName.focus();
	return false;
	}
	return true;
	}
	
	-->
	</script>
	</head>

	<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" bgcolor="#ffcc66">
	<table border=0 ID="Table2">
<tr><td>
<img border=1 src="uploads/galleryImages/tn_<?php echo $imageName['imageid'];?>.jpg"> 
</td>
<td valign="top">
	<form action="imageUpload.php?mode=regInfo" method="post" name="regInfo" ID="Form1" onSubmit="return CheckForm();">
	<div class=plainText>
	Bildnamn: 
	<input type="text" name="imagename" class="formbutton" ID="Text1">
	<br>
	<input type="checkbox" name="private" value="1"> Bilden &auml;r privat!
	</div>
</td></tr><tr>
<?php 
$sql="select artlist.artid, artlist.artname from artlist";
$categorys = $conn->execute($sql);
?>
<td bgcolor="#ffcc66" colspan="2">	
	<div class=plainText>Kategori:<P>
H&auml;r p&aring; eldsjal.org kan du fritt ladda upp bilder. V&aring;rt bildgalleri &auml;r avsett att inneh&aring;lla bilder som visar alternativkonst enligt de definitioner som finns att v&auml;lja ovan. Fundera p&aring; om din bild faller under n&aring;gon av dessa kategorier. Om den inte g&ouml;r det eller du &auml;r os&auml;ker s&aring; kan du g&ouml;ra den privat. D&aring; kommer den att synas i ditt privata galleri, men inte i det gemensamma.<P>
Ps. &Ouml;vrigt &auml;r inte en konstform, anv&auml;nd &ouml;vrigt med f&ouml;rnuft!<P>
<strong>Om du inte anger minst en kategori kommer bilden raderas!</strong>
	</div>
	<table border=0 ID="Table1" class="activityList"><tr>
	<?php 
$styleCount = 0;
foreach( $categorys as $iCount => $category ) {
	print "<td><INPUT type=checkbox ID=category".$iCount." NAME=category".$iCount." value=".$category['artid'].">".$category['artname']."</td>";
	$styleCount = $styleCount + 1;
	if( $styleCount == 3 ) {
		print "</tr><tr>";
		$styleCount = 0;
	}
}
$iCount = count($categorys);
?>
	</tr></table>
</td>	
</tr>
<tr>
<td bgcolor="#ffcc66" colspan="2" align="right">
	<div class=plainText>
	<br>Beskriv bilden s&aring; utf&ouml;rligt som m&ouml;jligt: </div>
	<textarea name="imagedesc" id="imagedesc" cols="32" rows="7"></textarea>
	<br><input type="image" src="images/icons/arrows.gif" name="submit" value="Spara!" id="submit">
	<input type="hidden" name="imageid" value="<?php echo $imageName['imageid'];?>" ID="Hidden1">
	<input type = "hidden" name ="txtcount" value="<?php echo $iCount;?>" ID="Hidden2">
	</form>
	  </td>
	 </tr>
	</table>

 </body>
 </html>
