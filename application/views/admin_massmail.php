<?php region('content'); ?>

<?php 
echo form_open('/admin/massmail')
.input('text', 'title', 'Ämne')
.input('text', 'from_email', 'Från (email)', $from_email)
.input('text', 'from_name', 'Från (namn)', $from_name)
.textarea('body', 'Meddelande')
.form_label(form_checkbox('broadcast', '1', FALSE).'Skicka meddelandet till alla användare! (om du inte bockar i så skickas ett testmeddelande till dig själv)')
.submit('Ja men kom igen då!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>