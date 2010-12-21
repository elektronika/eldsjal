<?php region('content'); ?>
<?php if(isset($new_topics)): ?>
	<h3>De häringa trådarna handlar om din trakt, och är nya! <a href="/forum/markallasseen">(markera alla som visade)</a></h3>
	<table id="forum-topics" class="vertical-margin">
		<thead>
			<tr>
				<th>Ämne</th>
				<!-- <th>Senaste svar</th> -->
				<th>Svar</th>
				<th>Skapad</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($new_topics as $topic): ?>
			<tr class="<?php echo implode(' ', $topic->classes); ?><?php echo nth(2) ? ' odd' : ' even'; ?>">
				<td class="topic-subject"><span class="topic-link"><a href="/forum/<?php echo isset($topic->classes['new']) ? 'redirectupdated' : 'topic'; ?>/<?php echo $topic->id; ?>"><?php echo $topic->title; ?></a> 
				</span></td>
				<!-- <td class="topic-lastrepy"><?php if($topic->replies == 0): ?>-<?php else: ?><?php echo fuzzytime($topic->updated,'',' sedan'); ?> av <?php echo userlink($topic->updater); ?><?php endif; ?></td> -->
				<td class="topic-replies"><?php echo $topic->replies; ?></td>
				<td class="topic-creator"><?php echo shortdate($topic->created); ?> av <?php echo userlink($topic->creator); ?></td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<table id="forum-categories">
	<thead>
		<tr>
			<th>Kategori</th>
			<th>Trådar</th>
			<th>Senaste inlägg</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($categories as $cat): ?>
	<tr class="<?php echo implode(' ', $cat->classes); ?><?php echo nth(2) ? ' odd' : ' even'; ?>">
		<td class="category-title"><a href="<?php echo $cat->href; ?>"><?php echo $cat->title; ?><span> - <?php echo $cat->description; ?></span></td>
		<td class="category-threads"><?php echo $cat->threads; ?></td>
		<td class="category-updated"><?php echo is_null($cat->updated) ? '-' : fuzzytime($cat->updated, '', ' sedan'); ?></td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>