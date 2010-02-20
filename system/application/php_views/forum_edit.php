<?php region('content'); ?>
<h2><a href="/forum">Forum</a> &raquo; <a href="/forum/category/<?php echo $topic->forumCategoryID; ?>"><?php echo $topic->forumCategoryName; ?></a> &raquo; Redigera</h2>

<?php 
echo form_open($form_action); 
if($is_first_post) echo input('text', 'title', 'Rubrik', $topic->title);
if($is_moderator) {
	echo form_label('Låst tråd', 'locked');
	echo form_checkbox('locked', '1', $topic->locked);
	echo form_label('Klistrad tråd', 'sticky');
	echo form_checkbox('sticky', '1', $topic->sticky);
	echo form_label('Kategori', 'category');
	echo form_dropdown('category', $categories, $topic->forumCategoryID);
}
echo textarea('body', 'Inlägg', rqForm($post->body));
echo submit('Spara!');
?>
</form>
<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>