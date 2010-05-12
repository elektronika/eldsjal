<?php region('content'); ?>
<?php 
echo 
form_open($form_action)
.form_fieldset('Radera konto')
.'<p>Fyll i ditt lösenord igen för att bekräfta att du vill radera ditt konto.</p>'
.input('password', 'password', 'Ditt lösenord')
.'<p>Om du vill hälsa något innan du drar (tack & hej, fuck you eller vad som) så kan du göra det här. Såväl kärlek som kritik uppskattas!</p>'
.textarea('byebye', 'Adjö-hälsning')
.submit('Ja, jag vet att mitt konto raderas så fort jag trycker på den här knappen. Hit it!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>