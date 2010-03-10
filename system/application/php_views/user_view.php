<?php region('content'); ?>
<div class="presentation-header">
<?php echo userimage($user); ?>
<div class="userdata">
<?php if(isset($page_title)): ?><h2><?php if( ! empty($breadcrumbs)) echo breadcrumbs($breadcrumbs); ?><?php echo $page_title; ?></h2><?php endif; ?>
<?php if( ! empty($sublinks)) echo sublinks($sublinks); ?>
<dl class="user-properties odd">
	<?php foreach($user->properties as $prop): ?>
		<dt><?php echo $prop->title; ?></dt>
		<dd><?php echo $prop->value; ?></dd>
	<?php endforeach; ?>
</dl>
</div>
</div>
<div class="presentation-body">
<?php echo rq($user->presentation); ?>
</div>
<?php end_region(); ?>

<?php require('layout.php'); ?>