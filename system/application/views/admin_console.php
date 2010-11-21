<?php region('content'); ?>

<?php 
echo form_open('/admin/console')
.textarea('query', 'SQL-fråga', $query)
.submit('Gjört Majvor!')
.form_close();
?>

<?php if(isset($result)): ?>
	<table>
		<thead>
			<tr>
				<?php foreach(current($result) as $field => $value):?>
				<th><?php print $field; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row): ?>
				<tr>
					<?php foreach($row as $field => $value):?>
					<td><?php print is_null($value) ? 'NULL' : $value; ?></td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<?php if(isset($num_rows)): ?>
	<p>Antal rader: <?php print $num_rows;?></p>
<?php endif; ?>

<?php if(isset($affected_rows)): ?>
	<p>Antal påverkade rader: <?php print $affected_rows;?></p>
<?php endif; ?>

<?php if(isset($insert_id) && $insert_id != 0): ?>
	<p>Senaste ID: <?php print $insert_id;?></p>
<?php endif; ?>

<p><?php print $platform.' '.$version;?></p>
<?php end_region(); ?>

<?php require('layout.php'); ?>