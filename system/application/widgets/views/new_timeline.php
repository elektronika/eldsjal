<h3 class="widget-title">
	<span class="left">Senaste färskaste!</span> 
	<?php if($show_filter): ?>
		<span class="right">
			Visa: 
			<a<?php if($timeline_filter == 'all') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=all">nytt + svar</a> 
			<a<?php if($timeline_filter == 'new') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=new">bara nytt</a>
			<?php /* <a<?php if($timeline_filter == 'local') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=local">nära mig</a> */ ?>
		</span>
	<?php endif;?>
</h3>
<ul class="flat">
<?php foreach($items as $item): ?>
	<li class="item-<?php echo $item->type; echo nth(2) ? ' odd' : ' even'; ?>"><?php if($item->type == 'image') echo thumbnail($item); ?><a class="item-link" href="<?php echo $item->href; ?>"><?php echo $item->title; ?><span><?php echo truncate(strip_tags($item->body), $body_length); ?></span></a></li>
<?php endforeach; ?>
</ul>