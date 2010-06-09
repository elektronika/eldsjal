<h3 class="widget-title">
	<span class="left">Senaste färskaste!</span> 
	<?php if($show_filter): ?>
		<span class="right">
			<a<?php if($timeline_filter == 'all') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=all">nytt + svar</a> 
			<a<?php if($timeline_filter == 'new') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=new">bara nytt</a>
			<a<?php if($timeline_filter == 'local') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=local">lokalt</a>
			<a<?php if($timeline_filter == 'favorites') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=favorites">favvosar</a>
		</span>
	<?php endif;?>
</h3>
<ul class="flat">
<?php foreach($items as $item): ?>
	<?php
	if($item->type == 'image') {
		$next = next($items);
		prev($items);
		if($next->type == 'image' && $next->user_id == $item->user_id) {
			$break = 'nobreak';
		} else
			$break = 'break';
	} else
		$break = 'break';
	?>
	<li class="item-<?php echo $item->type; echo nth(2) ? ' odd' : ' even'; echo ' '.$break;?>">
		<?php if($item->type == 'image') echo thumbnail($item); ?>
		<a class="item-link" href="<?php echo $item->href; ?>"><?php echo $item->title; ?><span><?php echo truncate(strip_tags($item->body), $body_length); ?></span></a>
	</li>
<?php endforeach; ?>
</ul>