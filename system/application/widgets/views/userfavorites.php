<?php if( ! empty($items) || $filter == 'online'): ?>
<h3 class="widget-title">Favvosar
	<span class="right"> 
		<a<?php if($filter == 'all') echo ' class="current"'; ?> href="<?php echo $url; ?>?userfavorites_filter=all">alla</a> 
		<a<?php if($filter == 'online') echo ' class="current"'; ?> href="<?php echo $url; ?>?userfavorites_filter=online">online</a>
		<a<?php if($filter == 'local') echo ' class="current"'; ?> href="<?php echo $url; ?>?userfavorites_filter=local">lokalt</a>
	</span>
</h3>
<ul class="flat">
	<?php if( ! empty($items)): ?>
	<?php foreach($items as $item): ?>
		<li><?php echo userlink($item); ?> 
			<span>
				<a title="Gästbok" href="/guestbook/view/<?php echo $item->userid; ?>">GB</a>
				<a title="Meddelande" href="/messages/new/<?php echo $item->userid; ?>">PM</a>
				<a title="Bilder" href="/gallery/user:<?php echo $item->userid; ?>">B</a>
				<a title="Tankar" href="/thoughts/user/<?php echo $item->userid; ?>">T</a>
				<a class="delete" title="Sluta favorita" href="/user/<?php echo $item->userid; ?>/unfav">X</a>
			</span>
		</li>
	<?php endforeach; ?>
<?php else: ?>
		<li>Tyvärr, ingen online just nu.</li>
<?php endif; ?>
</ul>
<?php endif; ?>