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
if (!function_exists('Dwoo_Plugin_userlink_4ad9900d23c90')) {
function Dwoo_Plugin_userlink_4ad9900d23c90(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4ad9900d23c90'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad9900d23c90'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */?><a href="/user/<?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)) {

echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);

}
else {

echo Dwoo_Plugin_slugify($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true));

}?>" class="user u<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>" title="<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>"><?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?></a><?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_userimage_4ad9900d27729')) {
function Dwoo_Plugin_userimage_4ad9900d27729(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4ad9900d27729'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad9900d27729'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */?>
<img class="userimage" src="/uploads/userImages/tn_<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>.jpg" alt="<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>"/>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_actions_4ad9900d2a629')) {
function Dwoo_Plugin_actions_4ad9900d2a629(Dwoo $dwoo, $actions, $iconsonly = 1) {
static $_callCnt = 0;
$dwoo->scope[' 4ad9900d2a629'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad9900d2a629'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_input_4ad9900d43c7b')) {
function Dwoo_Plugin_input_4ad9900d43c7b(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4ad9900d43c7b'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad9900d43c7b'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_select_4ad9900d4fff0')) {
function Dwoo_Plugin_select_4ad9900d4fff0(Dwoo $dwoo, $name, $options, $default = "", $label = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4ad9900d4fff0'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad9900d4fff0'.($_callCnt++)));
$dwoo->scope['name'] = $name;
$dwoo->scope['options'] = $options;
$dwoo->scope['default'] = $default;
$dwoo->scope['label'] = $label;
$dwoo->scope['error'] = $error;
/* -- template start output */?>
<?php if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) == "" && function_exists('form_error')) {

$dwoo->scope["error"]=form_error((isset($dwoo->scope["name"]) ? $dwoo->scope["name"] : null));

}?>

<?php if ((isset($dwoo->scope["value"]) ? $dwoo->scope["value"] : null) == "" && function_exists('set_value')) {

$dwoo->scope["value"]=set_value((isset($dwoo->scope["name"]) ? $dwoo->scope["name"] : null));

}?>

<?php if ((isset($dwoo->scope["label"]) ? $dwoo->scope["label"] : null) != "") {
?><label for="form-item-<?php echo $dwoo->scope["name"];?>"><?php echo $dwoo->scope["label"];?></label><?php 
}?>

<?php $dwoo->scope["extra"]='class="form-item-select" id="form-item-'.(isset($dwoo->scope["name"]) ? $dwoo->scope["name"] : null).'"'?>

<?php echo form_dropdown((isset($dwoo->scope["name"]) ? $dwoo->scope["name"] : null), (isset($dwoo->scope["options"]) ? $dwoo->scope["options"] : null), (isset($dwoo->scope["default"]) ? $dwoo->scope["default"] : null), (isset($dwoo->scope["extra"]) ? $dwoo->scope["extra"] : null));?>

<?php if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) != "") {
?><span class="form-error-description"><?php echo $dwoo->scope["error"];?></span><?php 
}?>

<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_messages_4ad9900d6c8f8')) {
function Dwoo_Plugin_messages_4ad9900d6c8f8(Dwoo $dwoo, $messages) {
static $_callCnt = 0;
$dwoo->scope[' 4ad9900d6c8f8'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad9900d6c8f8'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_userbar_4ad9900d6d4c7')) {
function Dwoo_Plugin_userbar_4ad9900d6d4c7(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4ad9900d6d4c7'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad9900d6d4c7'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */?>
<div class="userbar">
	<div class="grid_2 alpha">
		<?php echo Dwoo_Plugin_userimage_4ad9900d27729($dwoo, (isset($dwoo->scope["user"]) ? $dwoo->scope["user"] : null));?>

	</div>
	<div class="grid_14 omega">
		<h2><?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'first_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?> "<span><?php echo Dwoo_Plugin_userlink_4ad9900d23c90($dwoo, (isset($dwoo->scope["user"]) ? $dwoo->scope["user"] : null));?></span>" <?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'last_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?></h2>
		<h3><?php echo Dwoo_Plugin_age($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'birthday',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true));?> år, <?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'inhabitance',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>, <?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'location',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);
if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'online',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)) {
?>, <span class="online">Online</span><?php 
}?></h3>
		<h4>Gick med <?php echo Dwoo_Plugin_fuzzytime($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'register_date',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true), true, 'Y-m-d H:i');?>, loggade senast in <?php echo Dwoo_Plugin_fuzzytime($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'lastLogin',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true), true, 'Y-m-d H:i');?></h4>
		<?php echo Dwoo_Plugin_actions_4ad9900d2a629($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'actions',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true), 0);?>

	</div>
	<div class="clear"> </div>
</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
ob_start(); /* template body */ ;
'';// checking for modification in file:/var/www/eldsjal/system/application/views/user.tpl
if (!("1250349530" == filemtime('/var/www/eldsjal/system/application/views/user.tpl'))) { ob_end_clean(); return false; };
'';// checking for modification in file:/var/www/eldsjal/system/application/views/layout.tpl
if (!("1255770918" == filemtime('/var/www/eldsjal/system/application/views/layout.tpl'))) { ob_end_clean(); return false; };
echo '';// checking for modification in file:templates.tpl
if (!("1255722200" == filemtime('/var/www/eldsjal/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<?php echo $this->assignInScope('main', 'active_section');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl<?php echo $this->assignInScope('user', 'active_section');?></title>
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
				<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "username", '', '', '');?> 
				<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "submit", "search", "", "Sök", '');?>

				</div>
			</form>	
			<a class="logout confirm" href="/logout"><span>Logga ut</span></a>
			<?php 
}
else {
?>
				<form id="login" method="post" action="/login">
					<div>
						<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "username", "Namn: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "password", "password", "Lösen: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "submit", "login", "", "Ja!", '');?>

					</div>
				</form>
			<?php 
}?>

		</div>
		<div class="grid_8" id="submenu">
		&nbsp;
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
	<?php echo Dwoo_Plugin_messages_4ad9900d6c8f8($this, Dwoo_Plugin_getMessages($this));?>

<div id="content" class="container_16">
	<div class="grid_16">
<?php echo Dwoo_Plugin_userbar_4ad9900d6d4c7($this, (isset($this->scope["user"]) ? $this->scope["user"] : null));?>

<?php echo form_open("/user/{".$this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true)."}/edit");?>

<fieldset>
	<legend>Kontoinformation</legend>
	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "username", "Användarnamn", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "email", "E-mail", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'email',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<div><a href="/user/<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>/password">Byt lösenord</a></div>
</fieldset>
<fieldset>
	<legend>Kontaktinfo</legend>
	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "first_name", "Förnamn", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'first_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "last_name", "Efternamn", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'last_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "msn", "MSN", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'msn',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "icq", "ICQ", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'icq',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "webpage", "Hemsida", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'webpage',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, "text", "phone", "Telefonnummer", $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'phone',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), '');?>

	<?php echo Dwoo_Plugin_select_4ad9900d4fff0($this, "location", (isset($this->scope["locations"]) ? $this->scope["locations"] : null), $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'locationId',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), "Område", '');?>

</fieldset>
<?php echo Dwoo_Plugin_input_4ad9900d43c7b($this, 'submit', '', '', 'Spara', '');?>

</form>
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
			<p><a href="mailto:info@eldsjal.org">info@eldsjal.org</a></p>
			<h4>Arbetsgrupp för eldsjal.org</h4>
			<p><a href="mailto:elektronika@eldsjal.org">elektronika@eldsjal.org</a></p>
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