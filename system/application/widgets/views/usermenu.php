<h3>Din kruxlåda!</h3>
<ul class="usermenu flat">
<?php foreach($items as $item): ?>
	<li class="<?php echo $item->class; ?>"><a href="<?php echo $item->href; ?>"><?php echo $item->title; ?></a></li>
<?php endforeach; ?>
</ul>