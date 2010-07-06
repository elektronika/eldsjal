<?php if( ! empty($items) || $show_filter): ?>
<h3 class="widget-title">
	<span class="left">Senaste färskaste!</span> 
	<?php if($show_filter): ?>
		<span class="right">
			<?php foreach($filters as $key => $name): ?>
			<a<?php if($filter == $key) echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=<?php echo $key; ?>"><?php echo $name; ?></a> 
			<?php endforeach; ?>
		</span>
	<?php endif;?>
</h3>
<ul class="flat">
<?php foreach($items as $item): ?>
	<?php
	if($item->type == 'image') {
		$next = next($items);
		prev($items);
		if($next && $next->type == 'image' && $next->user_id == $item->user_id) {
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
<?php endif; ?>