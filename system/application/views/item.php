<?php region('content'); ?>
<?php if( ! isset($item_function)) $item_function = 'post'; ?>
<div class="item-page">
<?php echo $item_function($item); ?>
</div>
<?php end_region(); ?>

<?php require('layout.php'); ?>