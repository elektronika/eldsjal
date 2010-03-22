<?php region('content'); ?>
<h2>Sharing is caring!</h2>
<?php echo form_open_multipart('gallery/upload')
.input("file", "file", "Börja med att välja filen som ska laddas upp...")
.input("text", "title", "...ge den en schysst titel...")
.input("text", "body", "...och en lattjo beskrivning")
.submit("Spara"); ?>

<fieldset id="categories">
	<legend>Sen bockar du i de kategorier du tycker passar. Men inget löjl!</legend>
<?php foreach($tags as $tag) echo form_label(form_checkbox("tag[{$tag->id}]", 1).$tag->tag); ?>

</fieldset>
</form>
<?php end_region(); ?>

<?php require('layout.php'); ?>