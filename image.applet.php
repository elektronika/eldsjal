<script TYPE="text/javascript" language="javascript">
		function openImage(url,x,y,qs)
		{
		window.open(url, 'galleryImage', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,directories=no,location=no,left=80,top=30,width=' + x + ',height=' + y);
		window.self.location='gallery.php?mode=' + qs;
		}
</script>

<?php
// Last uploaded images as thumbnails
if( $conn->type == 'mssql' )
	$sql = " select top 3 imagename, imageid, filetype, width, height from images order by imageuploaddate desc";
else
	$sql = " select imagename, imageid, filetype, width, height from images order by imageuploaddate desc limit 3";

$imageApplets = $conn->execute( $sql );

//print_r($imageApplets);

foreach( $imageApplets as $imageApplet ) {
	$iWidth = $imageApplet['width'] + 50;
	$iWidth = 900;
	$iHeight = $imageApplet['height'] + 300;
	$iHeight = 750;
	print "<span class=galleryThumb onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$imageApplet['imageid']."','".$iWidth."','".$iHeight."',''); \"><img src=uploads/galleryImages/tn_".$imageApplet['imageid'].".".$imageApplet['filetype']." border=0 class=galleryThumb></a></span><br>";

	//  //$imageApplet->moveNext;
}
?>
