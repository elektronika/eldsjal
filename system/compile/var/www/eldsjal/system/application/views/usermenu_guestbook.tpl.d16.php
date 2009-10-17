<?php
if (!function_exists('Dwoo_Plugin_input_4ad8f2241732e')) {
function Dwoo_Plugin_input_4ad8f2241732e(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4ad8f2241732e'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad8f2241732e'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_textarea_4ad8f2241ec49')) {
function Dwoo_Plugin_textarea_4ad8f2241ec49(Dwoo $dwoo, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4ad8f2241ec49'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4ad8f2241ec49'.($_callCnt++)));
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
echo '';// checking for modification in file:templates.tpl
if (!("1255722200" == filemtime('/var/www/eldsjal/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<form method="post" class="guestbook" action="/guestbook/ajax_add/<?php echo $this->scope["userid"];?>">
	<?php echo Dwoo_Plugin_textarea_4ad8f2241ec49($this, 'body', 'Gästboksinlägg', '', '');?><br/>
	<?php echo Dwoo_Plugin_input_4ad8f2241732e($this, 'submit', 'save', '', 'Hit it!', '');?>

	<?php echo Dwoo_Plugin_input_4ad8f2241732e($this, 'submit', 'cancel', '', 'Äh, det var inget.', '');?>

</form><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>