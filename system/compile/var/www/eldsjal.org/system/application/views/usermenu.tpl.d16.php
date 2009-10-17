<?php
if (function_exists('Dwoo_Plugin_age')===false)
	$this->getLoader()->loadPlugin('age');
if (!function_exists('Dwoo_Plugin_userimage_4a7ec73dc5845')) {
function Dwoo_Plugin_userimage_4a7ec73dc5845(Dwoo $dwoo, $user) {
static $_callCnt = 0;
$dwoo->scope[' 4a7ec73dc5845'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a7ec73dc5845'.($_callCnt++)));
$dwoo->scope['user'] = $user;
/* -- template start output */?>
<img class="userimage" src="/uploads/userImages/tn_<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'userid',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>.jpg" alt="<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["user"], false);?>"/>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
ob_start(); /* template body */ ;
echo '';// checking for modification in file:templates.tpl
if (!("1249331244" == filemtime('/var/www/eldsjal.org/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<div class="usermenu">
	<?php echo Dwoo_Plugin_userimage_4a7ec73dc5845($this, (isset($this->scope["user"]) ? $this->scope["user"] : null));?>

	<div class="userinfo">
		<h3 class="title"><span><?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'first_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?> "</span><?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'username',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?><span>" <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'last_name',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?></span></h3>
		<h4><?php echo Dwoo_Plugin_age($this, $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'born',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true));?> år. Bor i <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'inhabitance',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>, <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'city',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>.<?php if ($this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'online',  ),  3 =>   array (    0 => '',    1 => '',  ),), (isset($this->scope["user"]) ? $this->scope["user"]:null), true)) {
?> <span class="online">Online</span><?php 
}?></h4>
		<div class="sysslarmed"><span>Sysslar med</span> <?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'does',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>.</div>
		<ul class="submenu">
			<li class="guestbook"><a href="/user/<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>/guestbook"><span>Gästbok</span></a></li>
			<li class="message"><a href="/messages/new/<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>"><span>Meddelande</span></a></li>
			<li class="images"><a href="/gallery/user:<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>"><span>Bilder</span></a></li>
			<li class="thoughts"><a href="/thoughts/user/<?php echo $this->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'slug',  ),  3 =>   array (    0 => '',    1 => '',  ),), $this->scope["user"], false);?>"><span>Tankar</span></a></li>
		</ul>
	</div>
</div><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>