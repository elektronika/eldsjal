<?php region('content'); ?>
<h2>Sharing is caring!</h2>
<?php echo form_open_multipart('gallery/upload')
.input("file", "file", "Börja med att välja filen som ska laddas upp...")
.input("text", "title", "...ge den en schysst titel...")
.input("text", "body", "...en lattjo beskrivning...")
.input('text', 'tags', '...och avsluta med några kategorier du tycker passar.', NULL, '', array('autocomplete', 'tags'))
.'<p>Separera varje kategori med kommatecken, typ så här: "poi, eldkastare, grafitti". Fast utan citationstecknena då såklart. :)</p>'
.submit("Spara")
.form_close(); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>