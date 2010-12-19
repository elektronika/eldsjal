<?php region('content'); ?>
<?php if(isset($newly_tagged)): ?>
	<div class="newly_tagged">
	<?php foreach($newly_tagged as $image): ?>
		<div>
			<?php echo thumbnail($image); ?>
			<h3><?php $image->title; ?></h3>
			<p><?php echo userlink($image); ?> lade till taggen <a href="/gallery/tags:<?php echo $image->tag_id; ?>"><?php echo $image->tag; ?></a> till bilden <a href="/gallery/view/<?php echo $image->item_id; ?>"><?php echo $image->title; ?></a></p>
			<p class="clear">&nbsp;</p>
		</div>
	<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php foreach($images as $image): ?>
	<?php echo thumbnail($image); ?>
<?php endforeach; ?>
<div class="clear"> </div>
<?php if(isset($pager)) echo pager($pager); ?>
<?php if( ! empty($tags)): ?>
<div>
Visar bilder som matchar
<?php foreach($tags as $tag): ?>
	<?php echo $tag->title; ?><a href="/gallery/<?php echo $tag->href; ?>">(x)</a>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if(isset($tagcloud)) echo tagcloud($tagcloud, $tagcloud_prefix); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>