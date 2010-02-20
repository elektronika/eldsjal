<?php require('header.php'); ?>
<div class="sidebar" id="sidebar-left">
<?php foreach($widgets['left'] as $widget): ?>
	<div class="widget" id="widget-<?php echo $widget; ?>">
		<?php widget::run($widget); ?>
	</div>
<?php endforeach; ?>
</div>
<div class="region" id="region-content">
<?php echo region_contents('content'); ?>
</div>
<?php if($sidebar_right = region_contents('sidebar_right')): ?>
	<div class="sidebar" id="sidebar_right">
		<?php region('sidebar_right'); ?>
		sidebar_right tjohej!
		<?php end_region(); ?>
	</div>
<?php endif; ?>
<div class="clear">&nbsp;</div>
<?php require('footer.php'); ?>