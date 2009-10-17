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
if (!function_exists('Dwoo_Plugin_userlink_4a77647f99188')) {
function Dwoo_Plugin_userlink_4a77647f99188(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4a77647f99188'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77647f99188'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */
echo '<a href="'."/user/".$dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)."".'" class="'."user u".$dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)."".'" title="'."".$dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["user"]) ? $dwoo->scope["user"]:null), true)."".'">';
echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?></a><?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_userimage_4a77647fa0e8f')) {
function Dwoo_Plugin_userimage_4a77647fa0e8f(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4a77647fa0e8f'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77647fa0e8f'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */?>
<img class="userimage" src="/uploads/userImages/tn_<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>.jpg" alt="<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>"/>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_actions_4a77647fa6c55')) {
function Dwoo_Plugin_actions_4a77647fa6c55(Dwoo $dwoo, $actions) {
static $_callCnt = 0;
$dwoo->scope[' 4a77647fa6c55'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77647fa6c55'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_bubble_4a77647fae96e')) {
function Dwoo_Plugin_bubble_4a77647fae96e(Dwoo $dwoo, $data) {
static $_callCnt = 0;
$dwoo->scope[' 4a77647fae96e'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77647fae96e'.($_callCnt++)));
$dwoo->scope['data'] = $data;
/* -- template start output */?>
<div class="bubble"><?php if ($dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'id',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true)) {
?><a name="post-<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'id',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["data"], false);?>"></a><?php 
}?>

	<div class="bubble-userdata">
		<?php echo Dwoo_Plugin_userimage_4a77647fa0e8f($dwoo, (isset($dwoo->scope["data"]) ? $dwoo->scope["data"] : null));?>

		<?php echo Dwoo_Plugin_userlink_4a77647f99188($dwoo, (isset($dwoo->scope["data"]) ? $dwoo->scope["data"] : null));?>

	</div>
	<div class="bubble-content-wrap">
		<div class="bubble-content">
			<?php echo Dwoo_Plugin_rq($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'body',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true));?>

		</div>
	</div>
	<div class="bubble-meta">
	<?php echo Dwoo_Plugin_timesince($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'created',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true), ' sedan', true, 'Y-m-d H:i');?> <?php echo Dwoo_Plugin_actions_4a77647fa6c55($dwoo, $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'actions',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($dwoo->scope["data"]) ? $dwoo->scope["data"]:null), true));?>

	</div>
	<span class="clear"> </span>
</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_input_4a77647fd79e6')) {
function Dwoo_Plugin_input_4a77647fd79e6(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4a77647fd79e6'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77647fd79e6'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_textarea_4a77647fe54c3')) {
function Dwoo_Plugin_textarea_4a77647fe54c3(Dwoo $dwoo, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4a77647fe54c3'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77647fe54c3'.($_callCnt++)));
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

<textarea name="<?php echo $dwoo->scope["name"];?>"  class="form-item-textarea<?php if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) != "") {
?> form-item-error<?php 
}?>" id="form-item-<?php echo $dwoo->scope["name"];?>"><?php echo $dwoo->scope["value"];?></textarea>
<?php if ((isset($dwoo->scope["error"]) ? $dwoo->scope["error"] : null) != "") {
?><span class="form-error-description"><?php echo $dwoo->scope["error"];?></span><?php 
}?>

<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
ob_start(); /* template body */ ;
'';// checking for modification in file:/var/www/eldsjal.org/system/application/views/forum.tpl
if (!("1249327904" == filemtime('/var/www/eldsjal.org/system/application/views/forum.tpl'))) { ob_end_clean(); return false; };
'';// checking for modification in file:/var/www/eldsjal.org/system/application/views/layout.tpl
if (!("1249337827" == filemtime('/var/www/eldsjal.org/system/application/views/layout.tpl'))) { ob_end_clean(); return false; };
echo '';// checking for modification in file:templates.tpl
if (!("1249331244" == filemtime('/var/www/eldsjal.org/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<?php echo $this->assignInScope('main', 'active_section');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl<?php echo $this->assignInScope('forum', 'active_section');?></title>
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
				<?php echo Dwoo_Plugin_input_4a77647fd79e6($this, "text", "username", '', '', '');?> 
				<?php echo Dwoo_Plugin_input_4a77647fd79e6($this, "submit", "search", "", "Sök", '');?>

				</div>
			</form>	
			<a class="logout" href="/logout"><span>Logga ut</span></a>
			<?php 
}
else {
?>
				<form id="login" method="post" action="/login">
					<div>
						<?php echo Dwoo_Plugin_input_4a77647fd79e6($this, "text", "username", "Namn: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4a77647fd79e6($this, "password", "password", "Lösen: ", '', '');?>

					</div>
				</form>
			<?php 
}?>

		</div>
		<div class="grid_8" id="submenu">
			<a class="first" href="/forum/new">Skapa tråd</a>
	<a href="/forum/watched">Bevakade trådar</a>
	<a href="/forum/random">Slumpad tråd</a>
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
<div id="content" class="container_16">
	<div class="grid_16">
		<?php if ((isset($this->scope["flash"]) ? $this->scope["flash"] : null)) {

echo $this->scope["flash"];

}?>

<h2><?php echo '<a href="'."/forum".'">';?>Forum</a> &raquo; <?php echo '<a href="'."/forum/category/".$this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'forumCategoryId',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["topic"]) ? $this->scope["topic"]:null), true)."".'">';
echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'forumCategoryName',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["topic"], false);?></a> &raquo; <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'topicName',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["topic"], false);?></h2>
<?php 
$_fh5_data = (isset($this->scope["posts"]) ? $this->scope["posts"] : null);
if ($this->isArray($_fh5_data) === true)
{
	foreach ($_fh5_data as $this->scope['post'])
	{
/* -- foreach start output */
?>
	<?php echo Dwoo_Plugin_bubble_4a77647fae96e($this, (isset($this->scope["post"]) ? $this->scope["post"] : null));?>

<?php 
/* -- foreach end output */
	}
}?>

<?php if ((isset($this->scope["user_can_reply"]) ? $this->scope["user_can_reply"] : null)) {
?>
<?php echo form_open("/forum/topic/".$this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'topicId',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["topic"]) ? $this->scope["topic"]:null), true)."");?>

<?php echo Dwoo_Plugin_textarea_4a77647fe54c3($this, "body", "Inlägg", '', '');?>

<?php echo Dwoo_Plugin_input_4a77647fd79e6($this, "submit", "submit", "", "Spara", '');?>

</form>
<?php 
}?>

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