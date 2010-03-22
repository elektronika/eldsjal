<?php region('content'); ?>
<h3><?php echo $message; ?></h3>
<p>Du vet, det går liksom inte att ångra. Om du är osäker så är det bara att trycka på bakåt-knappen i webbläsaren!</p>

<?php 
echo form_open($form_action); 
echo submit('Ja men kom igen då!');
?>
</form>
<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>