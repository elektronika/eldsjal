<?php region('content'); ?>
<h2><?php echo $page_title?></h2>
<?php if(isset($sublinks)) echo sublinks($sublinks); ?>

<?php echo calendar($events, $month, $year); ?>
<?php echo datepager('/calendar/browse/', $year, $month, $day); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>