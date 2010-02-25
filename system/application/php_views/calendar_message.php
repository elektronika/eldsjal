<?php region('content'); ?>
<h2><?php echo $page_title; ?></h2>
<?php echo sublinks($sublinks); ?>

<?php 
echo form_open($form_action); 
echo input('text', 'title', 'Rubrik', $prefilled_title);
echo textarea('body', 'Meddelande');
echo submit('Ja, jag vet att det här går ut till hinkvis med folk. Skicka!');
?>
</form>
<?php end_region(); ?>

<?php require('layout.php'); ?>