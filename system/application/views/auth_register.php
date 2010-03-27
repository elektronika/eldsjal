<?php region('content'); ?>
<p>Kul att du vill vara med! :) För att bli medlem måste du ha en fungerande emailadress, så därför börjar vi med den. Efter du har skickat formuläret nedan så kommer du att få ett mail med instruktioner om hur du fortsätter.</p>
<?php 
echo form_open('/register')
.input('text', 'email', 'Din emailadress')
.submit('Kom igen!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>