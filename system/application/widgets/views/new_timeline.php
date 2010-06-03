<h3 class="widget-title"><span class="left">Senaste färskaste!</span> <span class="right"><a<?php if($timeline_filter == 'all') echo ' class="current"'; ?> href="<?php echo $url; ?>/?timeline_filter=all">Visa nytt + svar</a> <a<?php if($timeline_filter == 'new') echo ' class="current"'; ?> href="<?php echo $url; ?>/?timeline_filter=new">Visa bara nytt</a></span></h3>
<ul class="flat">
<?php foreach($items as $item): ?>
	<li class="item-<?php echo $item->type; echo nth(2) ? ' odd' : ' even'; ?>"><a href="<?php echo $item->href; ?>"><?php echo $item->title; ?><span><?php echo truncate(strip_tags($item->body), $body_length); ?></span></a></li>
<?php endforeach; ?>
</ul>