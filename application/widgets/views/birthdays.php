<?php if( ! empty($birthdays)): ?>
<h3 class="widget-title">Födelsedagsbarn</h3>
<ul id="birthdays" class="flat">
<?php foreach($birthdays as $user): ?>
	<li><?php echo userlink($user); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>