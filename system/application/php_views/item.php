<?php region('content'); ?>
<?php if( ! isset($item_function)) $item_function = 'post'; ?>
<h2><?php echo $page_title?></h2>
<?php if(isset($sublinks)) echo sublinks($sublinks); ?>

<div class="item-page">
<?php echo $item_function($item); ?>
</div>
<?php end_region(); ?>

<?php require('layout.php'); ?>