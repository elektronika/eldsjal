<?php region('content'); ?>
<h2><span class="float-left"><a href="/forum">Forum</a> &raquo; <?php echo $category->forumCategoryName; ?></span> <?php if($user_can_post): ?><span class="float-right"><a href="/forum/new/<?php echo $category->forumCategoryId; ?>">Ny tråd</a></span><?php endif; ?></h2>
<span class="clear">&nbsp;</span><br/>
<table id="forum-topics">
	<thead>
		<tr>
			<th>Ämne</th>
			<th>Senaste svar</th>
			<th>Svar</th>
			<th>Skapad</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($topics as $topic): ?>
		<tr class="<?php echo implode(' ', $topic->classes); ?><?php echo nth(2) ? ' odd' : ' even'; ?>">
			<td class="topic-subject"><span class="topic-link"><a href="/forum/topic/<?php echo $topic->id; ?>"><?php echo $topic->title; ?></a> 
			<?php echo pagespan($topic->posts, "/forum/topic/$topic->id", $posts_per_page); ?> 
			<?php if(isset($topic->classes['new'])): ?> <a href="/forum/redirectupdated/<?php echo $topic->id; ?>"; ?>&raquo;</a><?php endif; ?></span> <?php echo actions($topic->actions, TRUE); ?></td>
			<td class="topic-lastrepy"><?php if($topic->replies == 0): ?>-<?php else: ?><?php echo fuzzytime($topic->updated,'',' sedan'); ?> av <?php echo userlink($topic->updater); ?><?php endif; ?></td>
			<td class="topic-replies"><?php echo $topic->replies; ?></td>
			<td class="topic-creator"><?php echo shortdate($topic->created); ?> av <?php echo userlink($topic->creator); ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php echo pager($pager); ?>

<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>