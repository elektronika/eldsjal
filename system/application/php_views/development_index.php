<?php region('content'); ?>
<h2>Utveckling serru!</h2>
<p>Här kan du se vad som händer med utvecklingen utav eldsjal.org. Om du är sugen på att hjälpa till så kan du alltid peta på intedinmamma, eller någon annan som verkar tuff.<br/></p><p>Det kanske inte går så fort, och det kanske inte blir så bra, men vi är söta och glada. :)</p>
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