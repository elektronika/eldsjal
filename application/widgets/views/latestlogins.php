<h3 class="widget-title">Senast inloggade</h3>
<ul id="latestlogins" class="flat">
<?php foreach($logins as $login): ?>
	<li><?php echo userlink($login); ?> - <?php echo date('H:i', strtotime($login->lastlogin)); ?></li>
<?php endforeach; ?>
</ul>