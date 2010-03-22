<?php region('content'); ?>
<div class="inputgrid">
<?php echo form_open($form_action); ?>
<?php $i = 0; ?>
<table>
	<thead>
	<tr>
	<?php foreach(array_keys((array) current($items)) as $key): ?>
		<th>
		<?php echo $key; ?>
		</th>
	<?php endforeach; ?>
	</tr>
	</thead>
<?php foreach($items as $item): ?>
	<?php $j = $i++; ?>
	<tr class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php foreach($item as $key => $value): ?>
		<td>
			<input type="text" class="form-field-<?php echo $key; ?>" name="items[<?php echo $j; ?>][<?php echo $key; ?>]" value="<?php echo $value; ?>"/>
		</td>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
<tr>
<?php $j = $i++; ?>	
<?php foreach(array_keys((array) end($items)) as $key): ?>
	<td>
		<input type="text" class="form-field-<?php echo $key; ?>" name="items[<?php echo $j; ?>][<?php echo $key; ?>]" value=""/>
	</td>
<?php endforeach; ?>
</tr>
</table>
<?php echo submit(); ?>
</form>
<?php end_region(); ?>

<?php require('layout.php'); ?>