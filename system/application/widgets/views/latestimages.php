<h3>Senaste bilder:</h3>
<?php
$sql = " select imagename, imageid, filetype, width, height from images order by imageuploaddate desc limit 3";
$images = $this->db->query($sql)->result_array();

foreach( $images as $image ) {
	$iWidth = $image['width'] + 50;
	$iWidth = 900;
	$iHeight = $image['height'] + 300;
	$iHeight = 750;
	print "<span class='galleryThumb' onmouseover=\"this.style.background='#cccc99';\" onmouseout=\"this.style.background='#ffffff';\"><a href=\"javascript:openImage('viewPicture.php?imageid=".$image['imageid']."','".$iWidth."','".$iHeight."',''); \"><img src=/uploads/galleryImages/tn_".$image['imageid'].".".$image['filetype']." border=0 class=galleryThumb></a></span><br>";
}
?>