<?php region('content'); ?>
<h2>Forum</h2>
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
	<tr class="<?php echo implode(' ', $cat->classes); ?>">
		<td class="category-title"><a href="<?php echo $cat->href; ?>"><?php echo $cat->title; ?><span> - <?php echo $cat->description; ?></span></td>
		<td class="category-threads"><?php echo $cat->threads; ?></td>
		<td class="category-updated"><?php echo fuzzytime($cat->updated, '', ' sedan'); ?></td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>