<?php region('content'); ?>
<h2>Dagens tanke!</h2>

<?php 
echo form_open('/thoughts/today'); 
echo input('text', 'title', 'Rubrik', rqForm($thought->title));
echo textarea('body', 'Din tanke', rqForm($thought->body));
echo submit('Spara!');
?>
</form>
<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>