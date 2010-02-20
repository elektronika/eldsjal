<?php region('content'); ?>
<h2><a href="/forum">Forum</a> &raquo; <a href="/forum/category/<?php echo $category->forumCategoryId; ?>"><?php echo $category->forumCategoryName; ?></a> &raquo; Ny tråd</h2>

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