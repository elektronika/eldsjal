<?php region('content'); ?>
<?php if($display_form): ?>
	<?php echo form_open($form_action);?>
	<?php echo textarea('body', 'Gästboksmeddelande');?>
	<?php echo submit('Pytsa in\'ett i gästboka!');?>
	</form>
<?php endif; ?>
<div class="list-page">
<?php foreach($items as $item): ?>
	<div class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php echo post($item); ?>
	</div>
<?php endforeach;?>
</div>
<?php if(isset($pager)) echo pager($pager); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>