<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $site_name; ?> - <?php echo isset($page_title) ? $page_title : $slogan; ?></title>
	<?php foreach($css as $stylesheet): ?>
	<link rel="stylesheet" href="/<?php echo $stylesheet.'?'.filemtime($stylesheet); ?>" type="text/css"/>
	<?php endforeach; ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Expires" content="<?php echo time();?>"/>
	<meta http-equiv="Pragma" content="no-cache"/>
</head>
<body class="layout-plain <?php echo $body_class; ?>">
<div id="wrap">
	<div id="upper-wrap">
		<?php widgets('header'); ?>
		<?php widgets('content'); ?>
		<div class="clear">&nbsp;</div>
	</div>
	<div id="footer-wrap">
		<?php widgets('footer'); ?>
	</div> <!-- #footer-wrap -->
	
</div> <!-- #wrap -->
<script type="text/javascript" charset="utf-8">
	var appData = <?php echo json_encode($js); ?>;
</script>
<script type="text/javascript" src="/jquery.min.js"></script>
<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
<script type="text/javascript" src="/scripts.js"></script>

</body>
</html>