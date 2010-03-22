<?php region('content'); ?>

<?php echo form_open($form_action);
foreach($fields as $field)
	echo input('text', $field, $field, rqForm($user->$field));
echo submit('Spara skrotet!');
?>
</form>
<?php end_region(); ?>

<?php require('layout.php'); ?>