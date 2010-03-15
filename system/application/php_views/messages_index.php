<?php region('content'); ?>
<table id="messages">
	<thead>
		<tr>
			<th>Med</th>
			<th>Om</th>
			<th>När</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($items as $message): ?>
	<tr class="<?php echo implode(' ', $message->classes); ?><?php echo nth(2) ? ' odd' : ' even'; ?>">
		<td class="message-counterpart"><?php echo userlink($message->counterpart); ?></td>
		<td><a href="<?php echo $message->href; ?>"><?php echo $message->title; ?></td>
		<td><?php echo fuzzytime($message->created, '', ' sedan'); ?></td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php echo pager($pager); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>