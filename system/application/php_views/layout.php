<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $site_name; ?> - <?php echo isset($page_title) ? $page_title : $slogan; ?></title>
	<?php foreach($css as $stylesheet): ?>
	<link rel="stylesheet" href="/<?php echo $stylesheet.'?'.filemtime($stylesheet); ?>" type="text/css"/>
	<?php endforeach; ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Expires" content="<?php echo time();?>"/>
	<meta http-equiv="Pragma" content="no-cache"/>
</head>
<body>
	<div id="wrap">
<div id="header-wrap">
	<div id="header">
		<?php foreach($widgets['header'] as $widget): ?>
			<div class="widget" id="widget-<?php echo $widget; ?>">
				<?php widget::run($widget); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php
if(isset($widgets['left']) && ! empty($widgets['left']) && isset($widgets['right']) && ! empty($widgets['right']))
	$sidebar_class = 'two-sidebars';
elseif(isset($widgets['left']) && ! empty($widgets['left']))
	$sidebar_class = 'sidebar-left';
elseif(isset($widgets['right']) && ! empty($widgets['right']))
	$sidebar_class = 'sidebar-right';
else
	$sidebar_class = 'no-sidebars';
?>
<div id="content-wrap" class="<?php echo $sidebar_class; ?>">
	<div id="content">
		
<div class="sidebar" id="sidebar-left">
<?php foreach($widgets['left'] as $widget): ?>
	<div class="widget" id="widget-<?php echo $widget; ?>">
		<?php widget::run($widget); ?>
	</div>
<?php endforeach; ?>
</div>
<div class="region" id="region-content">
<?php echo region_contents('content'); ?>
</div>
<?php if(isset($widgets['right']) && ! empty($widgets['right'])): ?>
	<div class="sidebar" id="sidebar-right">
		<?php foreach($widgets['right'] as $widget): ?>
			<div class="widget" id="widget-<?php echo $widget; ?>">
				<?php widget::run($widget); ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<div class="clear">&nbsp;</div>

</div>
<div id="footer-wrap">
	<div id="footer">
		<div class="float-left">
			<a href = "/members.php?mode=showOnline" class = "a2" ><?php echo $usersonline; ?> eldsjälar är online</a><br/>
		</div>
		<div class="float-right">
				Senast uppdaterad: <?php echo $revision_date; ?><br/>
				eldsjal.org <a href="/development"><?php echo $revision_name; ?></a>
		</div>
		<div id="footer-text">
			Det &auml;r ej till&aring;tet att kopiera, sprida eller vidaref&ouml;rmedla information fr&aring;n Eldsj&auml;l	F&ouml;reningen Eldsj&auml;l  (C) 2005 - <?php echo date('Y');?><br>
			eldsjal.org drivs av f&ouml;reningen Eldsj&auml;l med st&ouml;d fr&aring;n Ungdomsstyrelsen
		</div>
	</div>
</div>
<script type="text/javascript" src="/jquery.min.js"></script>
<script type="text/javascript" src="/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<script type="text/javascript" src="/scripts.js"></script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
_uacct = "UA-201570-2";
urchinTracker();
</script>
</body>
</html>