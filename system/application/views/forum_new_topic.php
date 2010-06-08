<?php region('content'); ?>
<?php 
echo form_open("/forum/new/$category->forumCategoryId"); 
echo input('text', 'title', 'Rubrik');
echo textarea('body', 'Inlägg');
// echo form_label(form_checkbox('is_wiki', '1').'Gör till wiki-tråd (så alla kan redigera första inlägget)', 'is_wiki');
echo form_fieldset('Kalenderlattjolajban');
echo form_label(form_checkbox('is_event', '1', $is_event).' Visa i kalendern', 'is_event');
echo '<div class="datepicker">';
echo form_label('Datum', 'date');
echo datepicker('date_from', $years_ahead, $years_back).' - '.datepicker('date_to', $years_ahead, $years_back);
echo '</div>';
echo form_fieldset_close();
echo form_fieldset('Plats');
echo form_label('Plats/område');
echo form_dropdown('location', $locations);
echo form_fieldset_close();
echo submit('Hit it!');
?>
</form>

<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>