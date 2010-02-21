<?php region('content'); ?>
<h2>Inställningar</h2>
<p class="notice">Töm key-fältet för att radera en inställning. Inställningar med user_id = 0 gäller för alla användare som inte har en likadan inställning med sitt user_id.</p>
<?php echo form_open('/admin/settings'); ?>
<?php $i = 0; ?>
<table>
	<tr>
		<td>user_id</td>
		<td>key</td>
		<td>value</td>		
	</tr>
<?php foreach($settings as $setting): ?>
	<tr class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php $j = $i++; ?>
		<td><input type="text" class="admin-settings-user_id form-item-text" name="settings[<?php echo $j;?>][user_id]" value="<?php echo $setting->user_id; ?>"/></td>
		<td><input type="text" class="admin-settings-key form-item-text" name="settings[<?php echo $j;?>][key]" value="<?php echo $setting->key; ?>"/></td>
		<td><input type="text" class="admin-settings-value form-item-text" name="settings[<?php echo $j;?>][value]" value="<?php echo $setting->value; ?>"/></td>
	</tr>
<?php endforeach; ?>
	<tr class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php $j = $i++; ?>
		<td><input type="text" class="admin-settings-user_id form-item-text" name="settings[<?php echo $j;?>][user_id]" value=""/></td>
		<td><input type="text" class="admin-settings-key form-item-text" name="settings[<?php echo $j;?>][key]" value=""/></td>
		<td><input type="text" class="admin-settings-value form-item-text" name="settings[<?php echo $j;?>][value]" value=""/></td>
	</tr>
</table>
<?php echo submit('Spara!'); ?>
</form>
<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>