<?php region('content'); ?>

<?php 
echo form_open($form_action); 
if($is_first_post) echo input('text', 'title', 'Rubrik', $topic->title);
echo textarea('body', 'Inlägg', rqForm($post->body));
if($is_moderator && $is_first_post) {
	echo form_fieldset('Moderatorsfunktioner');
	echo form_checkbox('locked', '1', $topic->locked);
	echo form_label('Låst tråd', 'locked');
	echo form_checkbox('sticky', '1', $topic->sticky);
	echo form_label('Klistrad tråd', 'sticky');
	echo form_label('Kategori', 'category');
	echo form_dropdown('category', $categories, $topic->forumCategoryID);
	echo form_fieldset_close();
}
if($is_first_post) {
	echo form_fieldset('Kalenderlattjolajban');
	echo form_label('Visa i kalendern', 'is_event');
	echo form_checkbox('is_event', '1', $topic->is_event);
	echo form_label('Datum', 'date');
	echo datepicker('date_from', $years_ahead, $years_back, $topic->date_from).' - '.datepicker('date_to', $years_ahead, $years_back, $topic->date_to);
	echo form_fieldset_close();
}
echo submit('Spara!');
?>
</form>
<?php end_region(); ?>

<?php clear_region('sidebar_right') ?>

<?php require('layout.php'); ?>