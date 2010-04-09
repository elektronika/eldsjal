<?php region('content'); ?>
<div class="inputgrid">
<?php echo form_open($form_action); ?>
<fieldset><legend>Rättigheter</legend>
<p>Bocka ur "Läsa" för en person för att radera alla dess rättigheter. Vill du lägga till en person så fyller du i användarnamnet i den tomma rutan längst ner. Om alla har rättighet att t ex skapa trådar så spelar det inte någon roll om en enskild användare har den rättigheten.</p>
<table id="forum-user-rights">
	<thead>
		<tr>
			<th>Vem</th>
			<th>Läsa</th>
			<th>Skapa</th>
			<th>Svara</th>
			<th>Bossa</th>
		</tr>
	</thead>
	<tbody>
    <tr class="<?php echo nth(2) ? ' odd' : ' even'; ?>">	
    	<td><strong>Alla</strong></td>
    	<td><?php echo form_checkbox('default_acl[read]', '1', $default_acl->read);?></td>
    	<td><?php echo form_checkbox('default_acl[create]', '1', $default_acl->create);?></td>
    	<td><?php echo form_checkbox('default_acl[reply]', '1', $default_acl->reply);?></td>
    	<td><?php echo form_checkbox('user_acls[admin]', '1', $default_acl->admin, 'disabled="disabled"');?></td>
    </tr>
<?php foreach($user_acls as $acl): ?>
	<tr class="<?php echo nth(2) ? ' odd' : ' even'; ?>">	
		<td><?php echo userlink($acl);?></td>
		<td><?php echo form_checkbox('user_acls['.$acl->user_id.'][read]', '1', $acl->read);?></td>
		<td><?php echo form_checkbox('user_acls['.$acl->user_id.'][create]', '1', $acl->create);?></td>
		<td><?php echo form_checkbox('user_acls['.$acl->user_id.'][reply]', '1', $acl->reply);?></td>
		<td><?php echo form_checkbox('user_acls['.$acl->user_id.'][admin]', '1', $acl->admin);?></td>
	</tr>
<?php endforeach; ?>
<tr class="<?php echo nth(2) ? ' odd' : ' even'; ?>">	
	<td><?php echo input('text', 'new_acl[username]'); ?></td>
	<td><?php echo form_checkbox('new_acl[read]', '1', 1);?></td>
	<td><?php echo form_checkbox('new_acl[create]', '1', 1);?></td>
	<td><?php echo form_checkbox('new_acl[reply]', '1', 1);?></td>
	<td><?php echo form_checkbox('new_acl[admin]', '1');?></td>
</tr>
	</tbody>
</table>
</fieldset>
<?php echo submit(); ?>
</form>
<?php end_region(); ?>

<?php require('layout.php'); ?>