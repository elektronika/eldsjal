<h3 class="widget-title">Kommande event</h3>
<ul id="upcoming" class="flat">
<?php foreach($events as $event): ?>
	<li><a href="<?php echo $event->href; ?>"><?php echo $event->title; ?></a></li>
<?php endforeach; ?>
</ul>