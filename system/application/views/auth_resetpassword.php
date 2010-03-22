<?php region('content'); ?>
<p>Då är det bara fylla i ditt nya lösenord, sen är saken biff!</p>
<?php 
echo form_open($form_action)
.input('password', 'password', 'Nytt lösenord')
.input('password', 'password_confirm', 'Nytt lösenord igen')
.submit('Tjohej!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>