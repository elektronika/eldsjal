<?php region('content'); ?>
<?php 
echo form_open("/forum/new/$category->forumCategoryId"); 
echo input('text', 'title', 'Rubrik');
echo textarea('body', 'Inlägg');
echo submit('Hit it!');
?>
</form>

<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>