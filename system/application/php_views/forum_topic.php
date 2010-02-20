<?php region('content'); ?>
<h2><a href="/forum">Forum</a> &raquo; <a href="/forum/category/<?php echo $topic->forumCategoryID; ?>"><?php echo $topic->forumCategoryName; ?></a> &raquo; <?php echo $topic->title; ?></h2>
<?php foreach($posts as $post): ?>
	<?php post($post); ?>
<?php endforeach; ?>

<?php echo pager($pager); ?>

<?php if($user_can_reply): ?>
<?php 
echo form_open("/forum/topic/$topic->id"); 
echo textarea('body', 'Inlägg');
echo submit('Hit it!');
?>
</form>
<?php endif; ?>

<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>