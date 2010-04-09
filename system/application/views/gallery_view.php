<?php region('content'); ?>
<img class="gallery-image" src="<?php echo $image->src; ?>" />
<?php echo post($image); ?>
<?php echo guestbook_form($image->userid); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>