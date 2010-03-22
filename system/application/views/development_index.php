<?php region('content'); ?>
<?php if($log): ?>
	<?php foreach($log as $item):?>
		<h3><?php echo $item['revision'];?> - <?php echo $item->msg; ?></h3>
		<p><?php echo date('Y-m-d ', strtotime((string) $item->date)); ?> av <?php echo $item->author; ?></p>
	<?php endforeach;?>
<?php else: ?>
	Ehm, svnlog.xml saknas. Antingen så har något gått snett eller så är det här någons privata utvecklingssida.
<?php endif;?>

<?php end_region(); ?>

<?php require('layout.php'); ?>