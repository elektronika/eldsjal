<?php region('content'); ?>
<?php if( ! isset($item_function)) $item_function = 'teaser'; ?>
<h2><?php echo $page_title?></h2>
<?php if(isset($sublinks)) echo sublinks($sublinks); ?>

<div class="list-page">
<?php foreach($items as $item): ?>
	<div class="<?php echo nth(2) ? 'odd' : 'even'; ?>">
		<?php echo $item_function($item); ?>
	</div>
<?php endforeach;?>
</div>
<?php if(isset($pager)) echo pager($pager); ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>