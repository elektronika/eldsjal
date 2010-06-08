<?php if( ! empty($items) || $filter == 'online'): ?>
<h3 class="widget-title">Dina favvosar
	<span class="right"> 
		<a<?php if($filter == 'all') echo ' class="current"'; ?> href="<?php echo $url; ?>?userfavorites_filter=all">alla</a> 
		<a<?php if($filter == 'online') echo ' class="current"'; ?> href="<?php echo $url; ?>?userfavorites_filter=online">online</a>
		<?php /* <a<?php if($timeline_filter == 'local') echo ' class="current"'; ?> href="<?php echo $url; ?>?timeline_filter=local">nära mig</a> */ ?>
	</span>
</h3>
<ul class="flat">
	<?php if( ! empty($items)): ?>
	<?php foreach($items as $item): ?>
		<li><?php echo userlink($item); ?> <a class="delete" href="/user/<?php echo $item->userid; ?>/unfav">x</a></li>
	<?php endforeach; ?>
<?php else: ?>
		<li>Tyvärr, ingen online just nu.</li>
<?php endif; ?>
</ul>
<?php endif; ?>