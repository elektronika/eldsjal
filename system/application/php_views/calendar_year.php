<?php region('content'); ?>
<h2><?php echo $page_title?></h2>
<?php if(isset($sublinks)) echo sublinks($sublinks); ?>
<div class="calendar-year">
<div class="break">
<?php for($month_number = 1; $month_number <= 12; $month_number++): ?>
	<div class="month">
		<h4><a href="/calendar/browse/<?php echo $year.'/'.$month_number; ?>"><?php echo strftime('%B', mktime(0,0,0, $month_number)); ?></a></h4>
		<?php echo calendar(empty($events[$month_number]) ? array() : $events[$month_number], $month_number, $year); ?>
	</div>
	<?php echo in_array($month_number, array(3, 6, 9)) ? '</div><div class="break">' : ''; ?>
<?php endfor; ?>
</div>
</div>
<?php echo datepager('/calendar/browse/', $year, $month, $day); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>