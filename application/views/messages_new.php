<?php region('content'); ?>
<?php 
echo form_open("/messages/new/{$user->userid}"); 
echo input('text', 'title', 'Ämne');
echo textarea('body', 'Meddelande');
echo submit('Hit it!');
?>
</form>

<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>