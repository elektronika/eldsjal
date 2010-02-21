<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>eldsjäl - <?php echo isset($page_title) ? $page_title : $slogan; ?></title>
	<link rel="stylesheet" href="/alt_style/style.css?<?php echo filemtime('alt_style/style.css');?>" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Expires" content="<?php echo time();?>"/>
	<meta http-equiv="Pragma" content="no-cache"/>
</head>
<body>
	<div id="wrap">
<div id="header-wrap">
	<div id="header">
		<h1><span>Eldsjäl.org</span></h1>
		<div id="navbar">
			<div id="menuItems">
				<a href="/main" title="Tillbaka till startsida med nyheter och statistik">Start</a>
				<a href="/forum" title="Diskutera, fundera och spekulera fritt med andra eldsjälar *inlägg kräver medlemskap*">Forum</a>
				<a href="/members.php" title="Här finns alla våra medlemmar!">Medlemmar</a>
				<a href="/gallery.php" title="Underbara bilder med anknytning till alternativkonst från våra medlemmar *uppladdning kräver medlemskap*">Galleri</a>
				<a href="http://www.cby.se/" title="Camp Burn Yourselfs egna sida!" target="_blank">C.B.Y</a>
				<a href="/board.php" title="Information om föreningen">Föreningen</a>
			</div>
			<form id="quicksearch" action = "/members.php?mode=listMembers" method = "post"> 
				<div>
				<input type = "text" name = "username" id = "quicksearch-username"/> 
				<input type = "image" src = "/images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
				</div>
			</form>	
			<div class="clear"> </div>
		</div>
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