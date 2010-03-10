<?php region('content'); ?>
<?php if( ! isset($item_function)) $item_function = 'teaser'; ?>
<div class="list-page">
<?php if(isset($before)) echo $before; ?>
<?php if( ! empty($items)): foreach($items as $item): ?>
	<div class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php echo $item_function($item); ?>
	</div>
<?php endforeach;
else: ?>
<p>Tomt vare här!</p>
<?php endif; ?>
</div>
<?php if(isset($pager)) echo pager($pager); ?>
<?php if(isset($after)) echo $after; ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>