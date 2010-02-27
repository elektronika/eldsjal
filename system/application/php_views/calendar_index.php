<?php region('content'); ?>
<?php if( ! isset($item_function)) $item_function = 'teaser'; ?>
<?php if( ! empty($attending)): ?>
<h3>Dessa är du anmäld till!</h3>
<div class="list-page">
<?php foreach($attending as $item): ?>
	<div class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php echo $item_function($item); ?>
	</div>
<?php endforeach;?>
</div>
<?php endif; ?>

<h3>De här kommer härnäst!</h3>
<div class="list-page">
<?php foreach($upcoming as $item): ?>
	<div class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php echo $item_function($item); ?>
	</div>
<?php endforeach;?>
</div>
<a href="/calendar/browse">Visa ännu fler!</a>
<?php end_region(); ?>

<?php require('layout.php'); ?>