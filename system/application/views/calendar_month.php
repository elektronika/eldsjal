<?php region('content'); ?>
<?php echo calendar($events, $month, $year); ?>
<?php echo datepager('/calendar/browse/', $year, $month, $day); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>