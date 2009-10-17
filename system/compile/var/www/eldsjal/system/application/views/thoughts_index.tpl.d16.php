<?php
if (function_exists('Dwoo_Plugin_isloggedin')===false)
	$this->getLoader()->loadPlugin('isloggedin');
if (function_exists('Dwoo_Plugin_active_userlink')===false)
	$this->getLoader()->loadPlugin('active_userlink');
if (function_exists('Dwoo_Plugin_alertcounter')===false)
	$this->getLoader()->loadPlugin('alertcounter');
if (function_exists('Dwoo_Plugin_whatsup')===false)
	$this->getLoader()->loadPlugin('whatsup');
if (function_exists('Dwoo_Plugin_getMessages')===false)
	$this->getLoader()->loadPlugin('getMessages');
if (function_exists('Dwoo_Plugin_usersonline')===false)
	$this->getLoader()->loadPlugin('usersonline');
if (function_exists('Dwoo_Plugin_wisdom')===false)
	$this->getLoader()->loadPlugin('wisdom');
if (function_exists('Dwoo_Plugin_rq')===false)
	$this->getLoader()->loadPlugin('rq');
if (!function_exists('Dwoo_Plugin_userlink_4ada0cc2ba628')) {
function Dwoo_Plugin_userlink_4ada0cc2ba628(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4ada0cc2ba628'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ada0cc2ba628'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */?><a href="/user/<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)) {

echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);

}
else {

echo Dwoo_Plugin_slugify($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true));

}?>" class="user u<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>" title="<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>"><?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?></a><?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_pager_4ada0cc2be08f')) {
function Dwoo_Plugin_pager_4ada0cc2be08f(Dwoo $dwoo, $pager) {
static $_callCnt = 0;
$dwoo->scope[' 4ada0cc2be08f'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ada0cc2be08f'.($_callCnt++)));
$dwoo->scope['pager'] = $pager;
/* -- template start output */?>
<div class="pager"><?php echo $dwoo->scope["pager"];?></div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_actions_4ada0cc2bf442')) {
function Dwoo_Plugin_actions_4ada0cc2bf442(Dwoo $dwoo, $actions, $iconsonly = 1) {
static $_callCnt = 0;
$dwoo->scope[' 4ada0cc2bf442'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ada0cc2bf442'.($_callCnt++)));
$dwoo->scope['actions'] = $actions;
$dwoo->scope['iconsonly'] = $iconsonly;
/* -- template start output */?>
<div class="actions<?php if ((isset($dwoo->scope["iconsonly"]) ? $dwoo->scope["iconsonly"] : null)) {
?> icons-only<?php 
}?>">
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
if (!function_exists('Dwoo_Plugin_teaser_4ada0cc2c7507')) {
function Dwoo_Plugin_teaser_4ada0cc2c7507(Dwoo $dwoo, $data, $truncate = true) {
static $_callCnt = 0;
$dwoo->scope[' 4ada0cc2c7507'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ada0cc2c7507'.($_callCnt++)));
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

		<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true) || $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true) || $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'poster',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true) || $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'updated',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?>
			<span>
				<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true) >= $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'updated',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> skapades <?php echo Dwoo_Plugin_fuzzytime($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true), null, null, 'Y-m-d H:i');?> <?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'creator',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> av <?php echo Dwoo_Plugin_userlink_4ada0cc2ba628($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'creator',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true));

}?>

				<?php 
}
elseif ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'updated',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true) > $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> uppdaterades <?php echo Dwoo_Plugin_fuzzytime($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'updated',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true), null, null, 'Y-m-d H:i');?> <?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'updater',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> av <?php echo Dwoo_Plugin_userlink_4ada0cc2ba628($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'updater',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true));

}

}?>

				<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?> av <?php echo Dwoo_Plugin_userlink_4ada0cc2ba628($dwoo, (isset($dwoo->scope["data"]) ? $dwoo->scope["data"] : null));

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
		<div class="teaser-text body">
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

		<?php echo Dwoo_Plugin_actions_4ada0cc2bf442($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'actions',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true), 1);?>

		</div>
	<?php 
}?>

<?php 
}?>

</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_input_4ada0cc2d825d')) {
function Dwoo_Plugin_input_4ada0cc2d825d(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4ada0cc2d825d'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ada0cc2d825d'.($_callCnt++)));
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
?><label id="form-label-<?php echo $dwoo->scope["name"];?>" for="form-item-<?php echo $dwoo->scope["name"];?>"><?php echo $dwoo->scope["label"];
if ((isset($dwoo->scope["type"]) ? $dwoo->scope["type"] : null) != "checkbox") {
?></label><?php 
}

}?>

<input type="<?php echo $dwoo->scope["type"];?>" class="form-item-<?php echo $dwoo->scope["type"];
if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) != "") {
?> form-item-error<?php 
}?>" name="<?php echo $dwoo->scope["name"];?>" value="<?php echo $dwoo->scope["value"];?>" id="form-item-<?php echo $dwoo->scope["name"];?>"/>
<?php if ((isset($dwoo->scope["type"]) ? $dwoo->scope["type"] : null) == "checkbox") {
?></label><?php 
}?>

<?php if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) != "") {
?><span class="form-error-description"><?php echo $dwoo->scope["error"];?></span><?php 
}?>

<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_messages_4ada0cc30f798')) {
function Dwoo_Plugin_messages_4ada0cc30f798(Dwoo $dwoo, $messages) {
static $_callCnt = 0;
$dwoo->scope[' 4ada0cc30f798'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ada0cc30f798'.($_callCnt++)));
$dwoo->scope['messages'] = $messages;
/* -- template start output */?>
<div class="container_16" id="messages">
	<?php 
$_fh5_data = (isset($dwoo->scope["messages"]) ? $dwoo->scope["messages"] : null);
if ($dwoo->isArray($_fh5_data) === true)
{
	foreach ($_fh5_data as $dwoo->scope['type']=>$dwoo->scope['message'])
	{
/* -- foreach start output */
?>
		<div class="grid_16 <?php echo $dwoo->scope["type"];?>"><?php echo $dwoo->scope["message"];?></div>
	<?php 
/* -- foreach end output */
	}
}?>

</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
ob_start(); /* template body */ ;
'';// checking for modification in file:/var/www/eldsjal/system/application/views/thoughts.tpl
if (!("1250276017" == filemtime('/var/www/eldsjal/system/application/views/thoughts.tpl'))) { ob_end_clean(); return false; };
'';// checking for modification in file:/var/www/eldsjal/system/application/views/layout.tpl
if (!("1255790635" == filemtime('/var/www/eldsjal/system/application/views/layout.tpl'))) { ob_end_clean(); return false; };
echo '';// checking for modification in file:templates.tpl
if (!("1255722200" == filemtime('/var/www/eldsjal/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<?php echo $this->assignInScope('main', 'active_section');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl<?php echo $this->assignInScope('thoughts', 'active_section');?></title>
	<link rel="stylesheet" href="/beta/reset.css" type="text/css"/>
	<link rel="stylesheet" href="/beta/960.css" type="text/css"/>
	<link type="text/css" href="/beta/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
	<link rel="stylesheet" href="/beta/style.css?<?php echo rand();?>" type="text/css"/>
	<script src="/beta/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="/beta/jquery.hoverIntent.js" type="text/javascript"></script>
	<script src="/beta/scripts.js?<?php echo rand();?>" type="text/javascript"></script>
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
		<h1><a href="/main.php"><span>Eldsj&auml;l.org</span></a></h1>
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
				<?php echo Dwoo_Plugin_input_4ada0cc2d825d($this, "text", "username", '', '', '');?> 
				<?php echo Dwoo_Plugin_input_4ada0cc2d825d($this, "submit", "search", "", "Sök", '');?>

				</div>
			</form>	
			<a class="logout confirm" href="/logout"><span>Logga ut</span></a>
			<?php 
}
else {
?>
				<form id="login" method="post" action="/login">
					<div>
						<?php echo Dwoo_Plugin_input_4ada0cc2d825d($this, "text", "username", "Namn: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4ada0cc2d825d($this, "password", "password", "Lösen: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4ada0cc2d825d($this, "submit", "login", "", "Ja!", '');?>

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
	<?php echo Dwoo_Plugin_messages_4ada0cc30f798($this, Dwoo_Plugin_getMessages($this));?>

<div id="content" class="container_12">
	<div class="grid_16">
<div class="grid_8 alpha">
<?php 
$_fh6_data = (isset($this->scope["thoughts"]) ? $this->scope["thoughts"] : null);
if ($this->isArray($_fh6_data) === true)
{
	foreach ($_fh6_data as $this->scope['thought'])
	{
/* -- foreach start output */
?>
	<?php echo Dwoo_Plugin_teaser_4ada0cc2c7507($this, (isset($this->scope["thought"]) ? $this->scope["thought"] : null), true);?>

<?php 
/* -- foreach end output */
	}
}?>

<?php echo Dwoo_Plugin_pager_4ada0cc2be08f($this, (isset($this->scope["pager"]) ? $this->scope["pager"] : null));?>

</div>
<div class="grid_4 omega">
	<h2>Vad har du på hjärtat?</h2>
	<p>Vad gnager dig? Vad får dig att tända till? Vad älskar du? Vad hatar du?</p>
	<h3>Släpp loss...</h3>
	<p>(mer text)</p>
	<h3>...men tänk efter</h3>
	<p>För när en tanke väl är publicerad så går den inte att radera.</p>
	
	<h3>Tankar i siffror</h3>
	<p>(lattjo statistik över tankarna, typ antal, när det skrevs flest, etc)</p>
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
			<h3>Om eldsjal.org</h3>
			<p>Eldsjal.org är en tjänst som Föreningen Eldsjäl med stolthet tillhandahåller allmänheten kostnadsfritt, oavsett medlemsskap i föreningen, för att sprida våra budskap och aktivt arbeta med våra målsättningar.</p><p><a href="/info">Läs mer om föreningen Eldsjäl &raquo;</a></p>
		</div>
		<div class="grid_4">
			<a href = "members.php?mode=showOnline" class = "a2" ><?php echo Dwoo_Plugin_usersonline($this);?> eldsjälar är online</a><br/>
			Antal inloggade idag: Jättemånga
		</div>
		<div class="grid_4 sitemap">
			<h3>Översikt</h3>
			<a href="/">Start</a>
			<ul>
				<li><a href="/forum">Forum</a></li>
				<li><a href="/calendar">Kalender</a></li>
				<li><a href="/thougts">Tankar</a></li>
				<li><a href="/people">Folk</a></li>
				<li>
					<ul>
						<li><a href="/people/map">Kartan</a></li>
					</ul>
				</li>
				<li><a href="/gallery">Galleri</a></li>
				<li><a href="/wiki">Wiki</a></li>
				<li><a href="/info">Om</a></li>
			</ul>
		</div>
		<div class="grid_4">
			<h3>Kontakt</h3>
			<h4>Styrelsen</h4>
			<p><a href="mailto:styrelsen@eldsjal.org">styrelsen@eldsjal.org</a></p>
			<h4>Arbetsgrupp för eldsjal.org</h4>
			<p><a href="mailto:elektronika@eldsjal.org">elektronika@eldsjal.org</a></p>
			<h4>Allt annat</h4>
			<p><a href="mailto:info@eldsjal.org">info@eldsjal.org</a></p>
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