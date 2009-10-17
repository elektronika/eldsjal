<?php
if (function_exists('Dwoo_Plugin_age')===false)
	$this->getLoader()->loadPlugin('age');
if (function_exists('Dwoo_Plugin_natural_implode')===false)
	$this->getLoader()->loadPlugin('natural_implode');
if (!function_exists('Dwoo_Plugin_userimage_4ad8e97a79d1c')) {
function Dwoo_Plugin_userimage_4ad8e97a79d1c(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4ad8e97a79d1c'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad8e97a79d1c'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */?>
<img class="userimage" src="/uploads/userImages/tn_<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>.jpg" alt="<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>"/>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_actions_4ad8e97a7d3f1')) {
function Dwoo_Plugin_actions_4ad8e97a7d3f1(Dwoo $dwoo, $actions, $iconsonly = 1) {
static $_callCnt = 0;
$dwoo->scope[' 4ad8e97a7d3f1'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad8e97a7d3f1'.($_callCnt++)));
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
ob_start(); /* template body */ ;
echo '';// checking for modification in file:templates.tpl
if (!("1255722200" == filemtime('/var/www/eldsjal/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<div class="usermenu u<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>">
	<?php echo Dwoo_Plugin_userimage_4ad8e97a79d1c($this, (isset($this->scope["user"]) ? $this->scope["user"] : null));?>

	<div class="userinfo">
		<h3 class="title"><span><?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'first_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?> "</span><?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?><span>" <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'last_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?></span></h3>
		<h4><?php echo Dwoo_Plugin_age($this, $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'birthday',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true));?> år. Bor i <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'inhabitance',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>, <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'location',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>.<?php if ($this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'online',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true)) {
?> <span class="online">Online</span><?php 
}?></h4>
		<div class="sysslarmed"><span>Sysslar med</span> <?php echo Dwoo_Plugin_natural_implode($this, $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'does',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), 'och');?>.</div>
		<?php echo Dwoo_Plugin_actions_4ad8e97a7d3f1($this, $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'actions',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true), 1);?>

	</div>
	<div class="usermenu-inject"></div>
</div><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>