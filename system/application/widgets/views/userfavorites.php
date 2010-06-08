<?php if( ! empty($items)): ?>
<h3 class="widget-title">Dina favvosar</h3>
<ul class="flat">
<?php foreach($items as $item): ?>
	<li><?php echo userlink($item); ?> <a class="delete" href="/user/<?php echo $item->userid; ?>/unfav">x</a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>