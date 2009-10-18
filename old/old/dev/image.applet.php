<?php
$content = '';
// Last uploaded images as thumbnails
if( $conn->type == 'mssql' )
	$sql = " select top 3 imagename, imageid, filetype, width, height from images order by imageuploaddate desc";
else
	$sql = " select imagename, imageid, filetype, width, height from images order by imageuploaddate desc limit 3";

$imageApplets = $conn->execute( $sql );

//print_r($imageApplets);

foreach( $imageApplets as $imageApplet ) {
	$iWidth = $imageApplet['width'] + 50;
	$iHeight = $imageApplet['height'] + 300;
	$content .= "<span class=galleryThumb onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$imageApplet['imageid']."','".$iWidth."','".$iHeight."',''); \"><img src=uploads/galleryImages/tn_".$imageApplet['imageid'].".".$imageApplet['filetype']." border=0 class=galleryThumb></a></span><br/>";

	//  //$imageApplet->moveNext;
}

print theme_box('Senaste bilder:', $content);
?>
