<?php region('content'); ?>
<?php foreach($images as $image): ?>
	<?php echo thumbnail($image); ?>
<?php endforeach; ?>
<div class="clear"> </div>
<?php if(isset($pager)) echo pager($pager); ?>
<?php if( ! empty($tags)): ?>
<div>
Visar bilder som matchar
<?php foreach($tags as $tag): ?>
	<?php echo $tag->artname; ?><a href="/gallery/<?php echo $tag->href; ?>">(x)</a>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if(isset($tagcloud)) echo tagcloud($tagcloud, $tagcloud_prefix); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>