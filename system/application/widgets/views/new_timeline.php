<h3>Senaste färskaste!</h3>
<ul class="flat">
<?php foreach($items as $item): ?>
	<li class="item-<?php echo $item->type; echo nth(2) ? ' odd' : ' even'; ?>"><a href="<?php echo $item->href; ?>"><?php echo $item->title; ?><span><?php echo truncate(strip_tags($item->body), $body_length); ?></span></a></li>
<?php endforeach; ?>
</ul>