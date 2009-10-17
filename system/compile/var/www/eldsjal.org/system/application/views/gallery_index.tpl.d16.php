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
if (!function_exists('Dwoo_Plugin_tagcloud_4a77644fb4ae3')) {
function Dwoo_Plugin_tagcloud_4a77644fb4ae3(Dwoo $dwoo, $tags, $prefix) {
static $_callCnt = 0;
$dwoo->scope[' 4a77644fb4ae3'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77644fb4ae3'.($_callCnt++)));
$dwoo->scope['tags'] = $tags;
$dwoo->scope['prefix'] = $prefix;
/* -- template start output */?>
<?php
$tag_max = $tag_min = 0;

foreach($tags as $tag) {
	if($tag->size > $tag_max)
		$tag_max = $tag->size;
	if($tag->size < $tag_min)
		$tag_min = $tag->size;
}

$tag_levels = 5;
$tag_count = count($tags);
$size_range = log($tag_max - $tag_min);
foreach($tags as &$tag) {
	if($size_range > 0) {
		$size_diff = $tag->size - $tag_min;
		$tag->level = floor($tag_levels*(log($size_diff) / $size_range));
	} else {
		$tag->level = 2;
	}
} ?>
<div class="tagcloud">
<?php 
$_fh0_data = (isset($dwoo->scope["tags"]) ? $dwoo->scope["tags"] : null);
if ($dwoo->isArray($_fh0_data) === true)
{
	foreach ($_fh0_data as $dwoo->scope['tag'])
	{
/* -- foreach start output */
?>
	<a class="tag tag-level-<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'level',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["tag"], false);?>" href="<?php echo $dwoo->scope["prefix"];
echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["tag"], false);?>"><?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'tag',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["tag"], false);?> (<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'size',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["tag"], false);?>)</a>
<?php 
/* -- foreach end output */
	}
}?>

</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_pager_4a77644fc3562')) {
function Dwoo_Plugin_pager_4a77644fc3562(Dwoo $dwoo, $pager) {
static $_callCnt = 0;
$dwoo->scope[' 4a77644fc3562'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77644fc3562'.($_callCnt++)));
$dwoo->scope['pager'] = $pager;
/* -- template start output */?>
<div class="pager"><?php echo $dwoo->scope["pager"];?></div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_thumbnail_4a77645004ee9')) {
function Dwoo_Plugin_thumbnail_4a77645004ee9(Dwoo $dwoo, $image) {
static $_callCnt = 0;
$dwoo->scope[' 4a77645004ee9'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77645004ee9'.($_callCnt++)));
$dwoo->scope['image'] = $image;
/* -- template start output */?>
<a href="/uploads/galleryImages/<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'imageId',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["image"], false);?>.jpg" class="thumbnail image-<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'imageId',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["image"], false);?>" style="background-image: url('/uploads/galleryImages/tn_<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'imageId',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["image"], false);?>.jpg')" title="<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'imageName',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["image"], false);?>"> </a>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_input_4a77645008d58')) {
function Dwoo_Plugin_input_4a77645008d58(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4a77645008d58'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a77645008d58'.($_callCnt++)));
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
'';// checking for modification in file:/var/www/eldsjal.org/system/application/views/gallery.tpl
if (!("1249327884" == filemtime('/var/www/eldsjal.org/system/application/views/gallery.tpl'))) { ob_end_clean(); return false; };
'';// checking for modification in file:/var/www/eldsjal.org/system/application/views/layout.tpl
if (!("1249337827" == filemtime('/var/www/eldsjal.org/system/application/views/layout.tpl'))) { ob_end_clean(); return false; };
echo '';// checking for modification in file:templates.tpl
if (!("1249331244" == filemtime('/var/www/eldsjal.org/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<?php echo $this->assignInScope('main', 'active_section');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl	<?php echo $this->assignInScope('gallery', 'active_section');?>

	- Galleri</title>
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
				<?php echo Dwoo_Plugin_input_4a77645008d58($this, "text", "username", '', '', '');?> 
				<?php echo Dwoo_Plugin_input_4a77645008d58($this, "submit", "search", "", "Sök", '');?>

				</div>
			</form>	
			<a class="logout" href="/logout"><span>Logga ut</span></a>
			<?php 
}
else {
?>
				<form id="login" method="post" action="/login">
					<div>
						<?php echo Dwoo_Plugin_input_4a77645008d58($this, "text", "username", "Namn: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4a77645008d58($this, "password", "password", "Lösen: ", '', '');?>

					</div>
				</form>
			<?php 
}?>

		</div>
		<div class="grid_8" id="submenu">
			<a <?php if ((isset($this->scope["active_sub_section"]) ? $this->scope["active_sub_section"] : null) == 'upload') {
?> class="active first" <?php 
}
else {
?> class="first" <?php 
}?> href="/gallery/upload">Ladda upp</a>
	<a <?php if ((isset($this->scope["active_section"]) ? $this->scope["active_section"] : null) == 'random') {
?> class="active" <?php 
}?>href="/gallery/random">Slumpad bild</a>
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

<?php 
$_fh5_data = (isset($this->scope["images"]) ? $this->scope["images"] : null);
if ($this->isArray($_fh5_data) === true)
{
	foreach ($_fh5_data as $this->scope['image'])
	{
/* -- foreach start output */
?>
	<?php echo Dwoo_Plugin_thumbnail_4a77645004ee9($this, (isset($this->scope["image"]) ? $this->scope["image"] : null));?>

<?php 
/* -- foreach end output */
	}
}?>

<div class="clear"> </div>
<?php echo Dwoo_Plugin_pager_4a77644fc3562($this, (isset($this->scope["pager"]) ? $this->scope["pager"] : null));?>

<?php if ((isset($this->scope["tags"]) ? $this->scope["tags"] : null)) {
?>
<div>
Visar bilder som matchar
<?php 
$_fh6_data = (isset($this->scope["tags"]) ? $this->scope["tags"] : null);
if ($this->isArray($_fh6_data) === true)
{
	foreach ($_fh6_data as $this->scope['tag'])
	{
/* -- foreach start output */
?>
	<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'artname',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["tag"], false);
echo '<a href="'."/gallery/".$this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'href',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["tag"]) ? $this->scope["tag"]:null), true)."".'">';?>(x)</a>
<?php 
/* -- foreach end output */
	}
}?>

</div>
<?php 
}?>

<?php echo Dwoo_Plugin_tagcloud_4a77644fb4ae3($this, (isset($this->scope["tagcloud"]) ? $this->scope["tagcloud"] : null), (isset($this->scope["tagcloud_prefix"]) ? $this->scope["tagcloud_prefix"] : null));?>

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