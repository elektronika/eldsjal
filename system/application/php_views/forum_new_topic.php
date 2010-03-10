<?php region('content'); ?>
<?php 
echo form_open("/forum/new/$category->forumCategoryId"); 
echo input('text', 'title', 'Rubrik');
echo textarea('body', 'Inlägg');
echo form_fieldset('Kalenderlattjolajban');
echo form_label('Visa i kalendern', 'is_event');
echo form_checkbox('is_event', '1', $is_event);
echo form_label('Datum', 'date');
echo datepicker('date_from', $years_ahead, $years_back).' - '.datepicker('date_to', $years_ahead, $years_back);
echo form_fieldset_close();
echo submit('Hit it!');
?>
</form>

<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>