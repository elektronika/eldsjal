<?php region('content'); ?>
<p>Jaru, ibland glömmer man saker. Men det är lugnt. :) Fyll i din mailadress här nere så skickar vi information om hur du nollställer ditt lösenord!</p>
<?php 
echo form_open('/lostpassword')
.input('text', 'email', 'Din emailadress')
.submit('Tjohej!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>