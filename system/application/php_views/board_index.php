<?php region('content'); ?>
<?php foreach($members as $member): ?>
<div class="member">
<?php echo userimage($member);?>
<strong>Namn: </strong><?php echo $member->first_name.' "'.userlink($member).'" '.$member->last_name;?><br/>
<strong>Post: </strong><?php echo $member->title; ?><br/>
<strong>E-mail: </strong><?php echo $member->email; ?><br/>
</div>
<?php endforeach; ?>
<?php end_region(); ?>

<?php require('layout.php'); ?>