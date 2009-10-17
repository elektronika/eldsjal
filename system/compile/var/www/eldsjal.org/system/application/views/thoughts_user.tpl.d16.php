<?php
if (function_exists('Dwoo_Plugin_isloggedin')===false)
	$this->getLoader()->loadPlugin('isloggedin');
if (function_exists('Dwoo_Plugin_active_userlink')===false)
	$this->getLoader()->loadPlugin('active_userlink');
if (function_exists('Dwoo_Plugin_alertcounter')===false)
	$this->getLoader()->loadPlugin('alertcounter');
if (function_exists('Dwoo_Plugin_whatsup')===false)
	$this->getLoader()->loadPlugin('whatsup');
if (function_exists('Dwoo_Plugin_usersonline')===false)
	$this->getLoader()->loadPlugin('usersonline');
if (function_exists('Dwoo_Plugin_wisdom')===false)
	$this->getLoader()->loadPlugin('wisdom');
if (function_exists('Dwoo_Plugin_rq')===false)
	$this->getLoader()->loadPlugin('rq');
if (!function_exists('Dwoo_Plugin_userlink_4a7ec650e8336')) {
function Dwoo_Plugin_userlink_4a7ec650e8336(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4a7ec650e8336'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a7ec650e8336'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */
echo '<a href="'."/user/".$dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)."".'" class="'."user u".$dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)."".'" title="'."".$dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)."".'">';
echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?></a><?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_actions_4a7ec650f1024')) {
function Dwoo_Plugin_actions_4a7ec650f1024(Dwoo $dwoo, $actions) {
static $_callCnt = 0;
$dwoo->scope[' 4a7ec650f1024'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a7ec650f1024'.($_callCnt++)));
$dwoo->scope['actions'] = $actions;
/* -- template start output */?>
<div class="actions">
<?php 
$_fh1_data = (isset($dwoo->scope["actions"]) ? $dwoo->scope["actions"] : null);
if ($dwoo->isArray($_fh1_data) === true)
{
	foreach ($_fh1_data as $dwoo->scope['action'])
	{
/* -- foreach start output */
?>
	<a class="action action-<?php echo $dwoo->scope["action"]["class"];?>" title="<?php echo $dwoo->scope["action"]["title"];?>" href="<?php echo $dwoo->scope["action"]["href"];?>">&nbsp;<span><?php echo $dwoo->scope["action"]["title"];?></span></a>
<?php 
/* -- foreach end output */
	}
}?>

</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_teaser_4a7ec651079d4')) {
function Dwoo_Plugin_teaser_4a7ec651079d4(Dwoo $dwoo, $data, $truncate = true) {
static $_callCnt = 0;
$dwoo->scope[' 4a7ec651079d4'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a7ec651079d4'.($_callCnt++)));
$dwoo->scope['data'] = $data;
$dwoo->scope['truncate'] = $truncate;
/* -- template start output */?>
<div class="teaser">
<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'title',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?>
	<h3 class="title"><?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'href',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {

echo '<a href="'.$dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'href',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true).'">';
echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'title',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["data"], false);?></a><?php 
}
else {

echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'title',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["data"], false);

}?>

		<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true) || $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true) || $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'poster',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?>
			<span>
				<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> för <?php echo Dwoo_Plugin_timesince($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true), ' sedan', true, 'Y-m-d H:i');

}?>

				<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> av <?php echo Dwoo_Plugin_userlink_4a7ec650e8336($dwoo, (isset($dwoo->scope["data"]) ? $dwoo->scope["data"] : null));

}?>

				<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'creator',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> av <?php echo Dwoo_Plugin_userlink_4a7ec650e8336($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'creator',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true));

}?>

			</span>
		<?php 
}?>

	</h3>
	<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'subtitle',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?>
		<h4 class="subtitle"><?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'subtitle',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["data"], false);?></h4>
	<?php 
}?>

	<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'body',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?>
		<div class="teaser-text">
		<?php if ((isset($dwoo->scope["truncate"]) ? $dwoo->scope["truncate"] : null)) {
?>
			<?php echo Dwoo_Plugin_truncate($dwoo, Dwoo_Plugin_remove_tags($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'body',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)), 120, '...', false, false);?>

		<?php 
}
else {
?>
			<?php echo Dwoo_Plugin_rq($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'body',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true));?>

		<?php 
}?>

		<?php echo Dwoo_Plugin_actions_4a7ec650f1024($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'actions',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true));?>

		</div>
	<?php 
}?>

<?php 
}?>

</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_input_4a7ec65130a58')) {
function Dwoo_Plugin_input_4a7ec65130a58(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4a7ec65130a58'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a7ec65130a58'.($_callCnt++)));
$dwoo->scope['type'] = $type;
$dwoo->scope['name'] = $name;
$dwoo->scope['label'] = $label;
$dwoo->scope['value'] = $value;
$dwoo->scope['error'] = $error;
/* -- template start output */?>
<?php if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) == "" && function_exists('form_error')) {

$dwoo->scope["error"]=form_error((isset($dwoo->scope["name"]) ? $dwoo->scope["name"] : null));

}?>

<?php if ((isset($dwoo->scope["value"]) ? $dwoo->scope["value"] : null) == "" && function_exists('set_value')) {

$dwoo->scope["value"]=set_value((isset($dwoo->scope["name"]) ? $dwoo->scope["name"] : null));

}?>

<?php if ((isset($dwoo->scope["label"]) ? $dwoo->scope["label"] : null) != "") {
?><label id="form-label-<?php echo $dwoo->scope["name"];?>" for="form-item-<?php echo $dwoo->scope["name"];?>"><?php echo $dwoo->scope["label"];?></label><?php 
}?>

<input type="<?php echo $dwoo->scope["type"];?>" class="form-item-<?php echo $dwoo->scope["type"];
if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) != "") {
?> form-item-error<?php 
}?>" name="<?php echo $dwoo->scope["name"];?>" value="<?php echo $dwoo->scope["value"];?>" id="form-item-<?php echo $dwoo->scope["name"];?>"/>
<?php if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) != "") {
?><span class="form-error-description"><?php echo $dwoo->scope["error"];?></span><?php 
}?>

<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
ob_start(); /* template body */ ;
'';// checking for modification in file:/var/www/eldsjal.org/system/application/views/thoughts.tpl
if (!("1249327814" == filemtime('/var/www/eldsjal.org/system/application/views/thoughts.tpl'))) { ob_end_clean(); return false; };
'';// checking for modification in file:/var/www/eldsjal.org/system/application/views/layout.tpl
if (!("1249337827" == filemtime('/var/www/eldsjal.org/system/application/views/layout.tpl'))) { ob_end_clean(); return false; };
echo '';// checking for modification in file:templates.tpl
if (!("1249331244" == filemtime('/var/www/eldsjal.org/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<?php echo $this->assignInScope('main', 'active_section');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl<?php echo $this->assignInScope('thoughts', 'active_section');?></title>
	<link rel="stylesheet" href="/beta/reset.css" type="text/css"/>
	<link rel="stylesheet" href="/beta/960.css" type="text/css"/>
	<link rel="stylesheet" href="/beta/style.css" type="text/css"/>
	<script src="/beta/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/beta/jquery.hoverIntent.js" type="text/javascript" charset="utf-8"></script>
	<script src="/beta/jquery.livequery.js" type="text/javascript" charset="utf-8"></script>
	<script src="/beta/scripts.js" type="text/javascript" charset="utf-8"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Expires" content="<?php echo time( );?>"/>
	<meta http-equiv="Pragma" content="no-cache"/>
</head>
<body>
	<div id="wrap">
		<div id="upper-wrap"><div id="upper-wrap-inner">
<div id="header-wrap">
	<div id="header" class="container_16">
		<div class="grid_16" id="logo">
		<h1><a href="/main"><span>Eldsj&auml;l.org</span></a></h1>
		</div>
		<div class="grid_8" id="navbar">
			<div id="menuItems">
				<a href="/forum/" <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'forum') {
?> class="active first" <?php 
}
else {
?> class="first" <?php 
}?>title="Diskutera, fundera och spekulera fritt med andra eldsj&auml;lar *inl&auml;gg kr&auml;ver medlemskap*">Forum</a>
				<a href="/calendar/" <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'calendar') {
?> class="active" <?php 
}?>title="Allt möjligt hittepå som händer runtomkring i landet!">Kalender</a>
				<a href="/thoughts/" <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'thoughts') {
?> class="active" <?php 
}?>title="Ditten och datten, sånt som rör sig i huvet på Eldsjäl helt enkelt!">Tankar</a>
				<a href="/people/" <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'people') {
?> class="active" <?php 
}?>title="H&auml;r finns alla v&aring;ra medlemmar!">Folk</a>
				<a href="/gallery/" <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'gallery') {
?> class="active" <?php 
}?>title="Underbara bilder med anknytning till alternativkonst fr&aring;n v&aring;ra medlemmar *uppladdning kr&auml;ver medlemskap*">Galleri</a>
				<a href="/wiki/" <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'wiki') {
?> class="active" <?php 
}?>title="Vår samlade kunskap! Wiki'n använder vi för allt möjligt, och du får gärna fylla på själv!">Wiki</a>
				<a href="/info/" <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'info') {
?> class="active" <?php 
}?>title="Information om f&ouml;reningen">Om</a>
			</div>
		</div>
		<div class="grid_8" id="userbar">
			<?php if (Dwoo_Plugin_isloggedin($this)) {
?>
			<?php echo Dwoo_Plugin_active_userlink($this);?>

			<a class="inbox" href="/inbox">Inbox<span id="alert-counter"> <?php echo Dwoo_Plugin_alertcounter($this);?></span></a>
			<form id="quicksearch" action = "/members.php?mode=listMembers" method = "post"> 
				<div>
				<?php echo Dwoo_Plugin_input_4a7ec65130a58($this, "text", "username", '', '', '');?> 
				<?php echo Dwoo_Plugin_input_4a7ec65130a58($this, "submit", "search", "", "Sök", '');?>

				</div>
			</form>	
			<a class="logout" href="/logout"><span>Logga ut</span></a>
			<?php 
}
else {
?>
				<form id="login" method="post" action="/login">
					<div>
						<?php echo Dwoo_Plugin_input_4a7ec65130a58($this, "text", "username", "Namn: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4a7ec65130a58($this, "password", "password", "Lösen: ", '', '');?>

					</div>
				</form>
			<?php 
}?>

		</div>
		<div class="grid_8" id="submenu">
			<a class="first" href="/thoughts/today">Dagens tanke</a>
	<a href="/thoughts/mine">Mina tankar</a>
		</div>
		<div class="grid_8" id="usersub">
			<?php if (Dwoo_Plugin_isloggedin($this)) {
?>
			<div id="whatsup">
				Just nu: <span><?php echo Dwoo_Plugin_whatsup($this);?></span>
			</div>
			<?php 
}
else {
?>
			<a href="/forgotpassword">Glömt lösenordet?</a>
			<a href="/register" class="last">Bli medlem</a>
			<?php 
}?>

		</div>
	</div>
</div>
<div id="content-wrap">
<div id="content" class="container_12">
	<div class="grid_16">
		<?php if ((isset($this->scope["flash"]) ? $this->scope["flash"] : null)) {

echo $this->scope["flash"];

}?>

<div class="grid_8 alpha">
<?php 
$_fh5_data = (isset($this->scope["thoughts"]) ? $this->scope["thoughts"] : null);
if ($this->isArray($_fh5_data) === true)
{
	foreach ($_fh5_data as $this->scope['thought'])
	{
/* -- foreach start output */
?>
	<?php echo Dwoo_Plugin_teaser_4a7ec651079d4($this, (isset($this->scope["thought"]) ? $this->scope["thought"] : null), true);?>

<?php 
/* -- foreach end output */
	}
}?>

</div>
<div class="grid_4 omega">
	*humdidum*
</div>
	</div>
</div>
<div class="clear"> </div>
</div>
</div>
</div>
<div id="footer-wrap">
	<div id="footer" class=" container_16">
		<div class="grid_4">
			<a href = "members.php?mode=showOnline" class = "a2" ><?php echo Dwoo_Plugin_usersonline($this);?> eldsjälar är online</a><br/>
			Antal inloggade idag: Jättemånga
		</div>
		<div class="grid_4">
			Lattjo text liksom.
		</div>
		
		<div class="wisdom-wrap grid_16">
		<div class="grid_8 alpha omega prefix_4 suffix_4">
			<div id="wisdom"><p>
				<?php echo Dwoo_Plugin_rq($this, Dwoo_Plugin_wisdom($this));?>

			</p></div>
		</div>
		<div class="clear">&nbsp;</div>
		</div>
		<div class="grid_4">
			Det &auml;r ej till&aring;tet att misstro, glömma eller förtränga information fr&aring;n Eldsj&auml;l.
		</div>
		<div class="grid_4">
			&copy; F&ouml;reningen Eldsj&auml;l 2005 - <?php echo date('Y');?> och respektive upprorsman
		</div>
		<div class="grid_4">
			eldsjal.org drivs av f&ouml;reningen Eldsj&auml;l utan st&ouml;d fr&aring;n Ungdomsstyrelsen
		</div>
		<div class="grid_4">
			Elektronika gjorde det här.<br/>
			Bra saker tar tid.
		</div>
	</div>
	<div class="clear"> </div>
</div>
<div class="clear"> </div>
</div>
<script type="text/javascript" src="/jquery.min.js"></script>
<script type="text/javascript" src="/scripts.js"></script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
_uacct = "UA-201570-2";
urchinTracker();
</script>
</body>
</html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>