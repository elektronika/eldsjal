<h3>Senaste bilder:</h3>
<?php
$sql = " select imagename, imageid, filetype, width, height from images order by imageuploaddate desc limit 3";
$images = $this->db->query($sql)->result_array();

foreach( $images as $image ) {
	print "<span class='galleryThumb'><a href='/gallery/view/".$image['imageid']."'><img src=/uploads/galleryImages/tn_".$image['imageid'].".".$image['filetype']." border=0 class=galleryThumb></a></span><br>";
}