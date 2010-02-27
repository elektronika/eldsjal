<?php region('content'); ?>
<?php if( ! isset($item_function)) $item_function = 'teaser'; ?>
<div class="list-page">
<?php foreach($events as $item): ?>
	<div class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php echo $item_function($item); ?>
	</div>
<?php endforeach;?>
</div>
<?php echo datepager('/calendar/browse/', $year, $month, $day); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>