<?php region('content'); ?>
<h2><a href="/forum">Forum</a> &raquo; <a href="/forum/category/<?php echo $topic->forumCategoryID; ?>"><?php echo $topic->forumCategoryName; ?></a> &raquo; <?php echo $topic->title; ?></h2>
<?php foreach($posts as $post): ?>
	<?php post($post); ?>
<?php endforeach; ?>

<?php echo pager($pager); ?>

<?php if($user_can_reply): ?>
	<?php if($is_last_page): ?>
		<?php echo form_open("/forum/topic/$topic->id/page:$cur_page").textarea('body', 'Inlägg').submit(); ?>
		</form>
	<?php else: ?>
<p class="notice">Sugen på att peta in en pinne till i brasan? Bläddra till sista sidan om du vill skriva ett inlägg!</p>
	<?php endif; ?>
<?php else: ?>
<p class="notice">Visst vore det kul att vara med och tjöta? Bli medlem vetja!</p>	
<?php endif; ?>

<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>