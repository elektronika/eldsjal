<div id="quicklinks">
	<?php echo userimage($user, TRUE); ?>
	<h2><?php echo $user->first_name.' "'.userlink($user).'" '.$user->last_name;?></h2>
	<?php echo sublinks($quicklinks); ?>
</div>