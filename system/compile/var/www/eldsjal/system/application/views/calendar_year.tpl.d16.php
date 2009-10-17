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
if (class_exists('Dwoo_Plugin_cycle', false)===false)
	$this->getLoader()->loadPlugin('cycle');
if (function_exists('Dwoo_Plugin_usersonline')===false)
	$this->getLoader()->loadPlugin('usersonline');
if (function_exists('Dwoo_Plugin_wisdom')===false)
	$this->getLoader()->loadPlugin('wisdom');
if (function_exists('Dwoo_Plugin_rq')===false)
	$this->getLoader()->loadPlugin('rq');
if (!function_exists('Dwoo_Plugin_input_4a892e5a99e5b')) {
function Dwoo_Plugin_input_4a892e5a99e5b(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4a892e5a99e5b'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a892e5a99e5b'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_datepager_4a892e5aab794')) {
function Dwoo_Plugin_datepager_4a892e5aab794(Dwoo $dwoo, $prefix, $year, $month = null, $day = null) {
static $_callCnt = 0;
$dwoo->scope[' 4a892e5aab794'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a892e5aab794'.($_callCnt++)));
$dwoo->scope['prefix'] = $prefix;
$dwoo->scope['year'] = $year;
$dwoo->scope['month'] = $month;
$dwoo->scope['day'] = $day;
/* -- template start output */?>
<div class="datepager pager">
<?php if( ! is_null($day)) { ?>
	<a href="<?php echo $dwoo->scope["prefix"];
echo date('Y/m/d', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), (isset($dwoo->scope["day"]) ? $dwoo->scope["day"] : null)-1, (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null)));?>" class="previous"><?php echo strftime('%e %B', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), (isset($dwoo->scope["day"]) ? $dwoo->scope["day"] : null)-1, (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null)));?> &laquo;</a> 
	<span class="current"><?php echo ucfirst(strftime('%A %e', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), (isset($dwoo->scope["day"]) ? $dwoo->scope["day"] : null), (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null))));?> <a href="<?php echo $dwoo->scope["prefix"];
echo $dwoo->scope["year"];?>/<?php echo $dwoo->scope["month"];?>"><?php echo strftime('%B', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), (isset($dwoo->scope["day"]) ? $dwoo->scope["day"] : null), (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null)));?></a> <a href="<?php echo $dwoo->scope["prefix"];
echo $dwoo->scope["year"];?>"><?php echo $dwoo->scope["year"];?></a></span> 
	<a href="<?php echo $dwoo->scope["prefix"];
echo date('Y/m/d', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), (isset($dwoo->scope["day"]) ? $dwoo->scope["day"] : null)+1, (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null)));?>" class="previous">&raquo; <?php echo strftime('%e %B', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), (isset($dwoo->scope["day"]) ? $dwoo->scope["day"] : null)+1, (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null)));?></a>
<?php } elseif( ! is_null($month)) { ?>
		<a href="<?php echo $dwoo->scope["prefix"];
echo date('Y/m', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null)-1));?>" class="previous"><?php echo strftime('%B', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null)-1));?> &laquo;</a> 
		<span class="current"><?php echo strftime('%B', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null)));?> <a href="<?php echo $dwoo->scope["prefix"];
echo $dwoo->scope["year"];?>"><?php echo $dwoo->scope["year"];?></a></span> 
		<a href="<?php echo $dwoo->scope["prefix"];
echo date('Y/m', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null)+1));?>" class="previous">&raquo; <?php echo strftime('%B', mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null)+1));?></a>
<?php } else { ?>
		<a href="<?php echo $dwoo->scope["prefix"];
echo $dwoo->scope["year"]-1;?>" class="previous"><?php echo $dwoo->scope["year"]-1;?> &laquo;</a> <span class="current"><?php echo $dwoo->scope["year"];?></span> <a href="<?php echo $dwoo->scope["prefix"];
echo $dwoo->scope["year"]+1;?>" class="previous">&raquo; <?php echo $dwoo->scope["year"]+1;?></a>
	<?php } ?>
</div>
<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_calendar_4a892e5ab30e8')) {
function Dwoo_Plugin_calendar_4a892e5ab30e8(Dwoo $dwoo, $events, $month, $year) {
static $_callCnt = 0;
$dwoo->scope[' 4a892e5ab30e8'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a892e5ab30e8'.($_callCnt++)));
$dwoo->scope['events'] = $events;
$dwoo->scope['month'] = $month;
$dwoo->scope['year'] = $year;
/* -- template start output */?>
<?php $dwoo->scope["timestamp_start"]=mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), 1, (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null))?>

<?php $dwoo->scope["days_in_month"]=date('t', (isset($dwoo->scope["timestamp_start"]) ? $dwoo->scope["timestamp_start"] : null))?>

<?php $dwoo->scope["days_to_skip"]=date('N', (isset($dwoo->scope["timestamp_start"]) ? $dwoo->scope["timestamp_start"] : null))?>

<?php $dwoo->scope["days_to_skip"]=(isset($dwoo->scope["days_to_skip"]) ? $dwoo->scope["days_to_skip"] : null)-1?>

<?php $dwoo->scope["first_week"]=date('W', (isset($dwoo->scope["timestamp_start"]) ? $dwoo->scope["timestamp_start"] : null))?>

<?php $dwoo->scope["first_week"]=(isset($dwoo->scope["first_week"]) ? $dwoo->scope["first_week"] : null)-1?>


<?php $dwoo->scope["number_of_cells"]=(isset($dwoo->scope["days_in_month"]) ? $dwoo->scope["days_in_month"] : null)+(isset($dwoo->scope["days_to_skip"]) ? $dwoo->scope["days_to_skip"] : null)?>

<?php $dwoo->scope["number_of_rows_kinda"]=(isset($dwoo->scope["number_of_cells"]) ? $dwoo->scope["number_of_cells"] : null)/7?>

<?php $dwoo->scope["rows_in_calendar"]=ceil((isset($dwoo->scope["number_of_rows_kinda"]) ? $dwoo->scope["number_of_rows_kinda"] : null))?>


<?php echo $dwoo->classCall('counter', array("day_of_month", 0, null, null, null, "day_of_month"));?>

<table class="calendar">
<?php 
$_for3_from = 1;
$_for3_to = (isset($dwoo->scope["rows_in_calendar"]) ? $dwoo->scope["rows_in_calendar"] : null);
$_for3_step = abs(1);
if (is_numeric($_for3_from) && !is_numeric($_for3_to)) { $dwoo->triggerError('For requires the <em>to</em> parameter when using a numerical <em>from</em>'); }
$tmp_shows = $dwoo->isArray($_for3_from, true) || (is_numeric($_for3_from) && (abs(($_for3_from - $_for3_to)/$_for3_step) !== 0 || $_for3_from == $_for3_to));
if ($tmp_shows)
{
	if ($dwoo->isArray($_for3_from, true)) {
		$_for3_to = is_numeric($_for3_to) ? $_for3_to - $_for3_step : count($_for3_from) - 1;
		$_for3_from = 0;
	}
	if ($_for3_from > $_for3_to) {
				$tmp = $_for3_from;
				$_for3_from = $_for3_to;
				$_for3_to = $tmp;
			}
	for ($dwoo->scope['row'] = $_for3_from; $dwoo->scope['row'] <= $_for3_to; $dwoo->scope['row'] += $_for3_step)
	{
/* -- for start output */
?>
	<tr>
		<td class="week">
			<?php if ((isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null) == 1) {
?>
				<?php $dwoo->scope["timestamp_start"]=mktime(0, 0, 0, (isset($dwoo->scope["month"]) ? $dwoo->scope["month"] : null), (isset($dwoo->scope["day_of_month"]) ? $dwoo->scope["day_of_month"] : null)+1, (isset($dwoo->scope["year"]) ? $dwoo->scope["year"] : null))?>

				<?php $dwoo->scope["first_week"]=date('W', (isset($dwoo->scope["timestamp_start"]) ? $dwoo->scope["timestamp_start"] : null))?>

				<?php $dwoo->scope["first_week"]=(isset($dwoo->scope["first_week"]) ? $dwoo->scope["first_week"] : null)-1?>

			<?php 
}?>

			<?php echo $dwoo->scope["first_week"]+$dwoo->scope["row"];?>

			</td>
		<?php if ((isset($dwoo->scope["row"]) ? $dwoo->scope["row"] : null) == 1) {
?>
			<?php if ((isset($dwoo->scope["days_to_skip"]) ? $dwoo->scope["days_to_skip"] : null) > 0) {
?>
			<?php 
$_for0_from = 1;
$_for0_to = (isset($dwoo->scope["days_to_skip"]) ? $dwoo->scope["days_to_skip"] : null);
$_for0_step = abs(1);
if (is_numeric($_for0_from) && !is_numeric($_for0_to)) { $dwoo->triggerError('For requires the <em>to</em> parameter when using a numerical <em>from</em>'); }
$tmp_shows = $dwoo->isArray($_for0_from, true) || (is_numeric($_for0_from) && (abs(($_for0_from - $_for0_to)/$_for0_step) !== 0 || $_for0_from == $_for0_to));
if ($tmp_shows)
{
	if ($dwoo->isArray($_for0_from, true)) {
		$_for0_to = is_numeric($_for0_to) ? $_for0_to - $_for0_step : count($_for0_from) - 1;
		$_for0_from = 0;
	}
	if ($_for0_from > $_for0_to) {
				$tmp = $_for0_from;
				$_for0_from = $_for0_to;
				$_for0_to = $tmp;
			}
	for ($dwoo->scope['skip_days'] = $_for0_from; $dwoo->scope['skip_days'] <= $_for0_to; $dwoo->scope['skip_days'] += $_for0_step)
	{
/* -- for start output */
?>
				<td class="day empty skip"> </td>
			<?php /* -- for end output */
	}
}
?>

			<?php 
}?>

			<?php 
$_for1_from = (isset($dwoo->scope["days_to_skip"]) ? $dwoo->scope["days_to_skip"] : null);
$_for1_to = 6;
$_for1_step = abs(1);
if (is_numeric($_for1_from) && !is_numeric($_for1_to)) { $dwoo->triggerError('For requires the <em>to</em> parameter when using a numerical <em>from</em>'); }
$tmp_shows = $dwoo->isArray($_for1_from, true) || (is_numeric($_for1_from) && (abs(($_for1_from - $_for1_to)/$_for1_step) !== 0 || $_for1_from == $_for1_to));
if ($tmp_shows)
{
	if ($dwoo->isArray($_for1_from, true)) {
		$_for1_to = is_numeric($_for1_to) ? $_for1_to - $_for1_step : count($_for1_from) - 1;
		$_for1_from = 0;
	}
	if ($_for1_from > $_for1_to) {
				$tmp = $_for1_from;
				$_for1_from = $_for1_to;
				$_for1_to = $tmp;
			}
	for ($dwoo->scope['days'] = $_for1_from; $dwoo->scope['days'] <= $_for1_to; $dwoo->scope['days'] += $_for1_step)
	{
/* -- for start output */
?>
				<?php echo $dwoo->classCall('counter', array("day_of_month", null, null, null, null, "day_of_month"));?>

				<?php if ($dwoo->readVar("events.".(isset($dwoo->scope["day_of_month"]) ? $dwoo->scope["day_of_month"] : null))) {
?>
					<?php $dwoo->scope["day_class"]=' has-events'?>

				<?php 
}
else {
?>
					<?php $dwoo->scope["day_class"]=' no-events'?>

				<?php 
}?>

				<td class="day<?php echo $dwoo->scope["day_class"];?>"><a href="/calendar/browse/<?php echo $dwoo->scope["year"];?>/<?php echo $dwoo->scope["month"];?>/<?php echo $dwoo->scope["day_of_month"];?>"><?php echo $dwoo->scope["day_of_month"];?></a><br/>
					<ul class="events">
					<?php 
$_fh3_data = $dwoo->readVar("events.".(isset($dwoo->scope["day_of_month"]) ? $dwoo->scope["day_of_month"] : null));
if ($dwoo->isArray($_fh3_data) === true)
{
	foreach ($_fh3_data as $dwoo->scope['event'])
	{
/* -- foreach start output */
?>
					<li><a href="/calendar/view/<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'eventId',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["event"], false);?>"><?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'title',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["event"], false);?></a></li>
					<?php 
/* -- foreach end output */
	}
}?>

					</ul>
				</td>
			<?php /* -- for end output */
	}
}
?>

		<?php 
}
else {
?>
			<?php 
$_for2_from = 1;
$_for2_to = 7;
$_for2_step = abs(1);
if (is_numeric($_for2_from) && !is_numeric($_for2_to)) { $dwoo->triggerError('For requires the <em>to</em> parameter when using a numerical <em>from</em>'); }
$tmp_shows = $dwoo->isArray($_for2_from, true) || (is_numeric($_for2_from) && (abs(($_for2_from - $_for2_to)/$_for2_step) !== 0 || $_for2_from == $_for2_to));
if ($tmp_shows)
{
	if ($dwoo->isArray($_for2_from, true)) {
		$_for2_to = is_numeric($_for2_to) ? $_for2_to - $_for2_step : count($_for2_from) - 1;
		$_for2_from = 0;
	}
	if ($_for2_from > $_for2_to) {
				$tmp = $_for2_from;
				$_for2_from = $_for2_to;
				$_for2_to = $tmp;
			}
	for ($dwoo->scope['days'] = $_for2_from; $dwoo->scope['days'] <= $_for2_to; $dwoo->scope['days'] += $_for2_step)
	{
/* -- for start output */
?>
				<?php echo $dwoo->classCall('counter', array("day_of_month", null, null, null, null, "day_of_month"));?>

				<?php if ((isset($dwoo->scope["day_of_month"]) ? $dwoo->scope["day_of_month"] : null) > (isset($dwoo->scope["days_in_month"]) ? $dwoo->scope["days_in_month"] : null)) {
?>
					<td class="day empty skip"> </td>
				<?php 
}
else {
?>
				<?php if ($dwoo->readVar("events.".(isset($dwoo->scope["day_of_month"]) ? $dwoo->scope["day_of_month"] : null))) {
?>
					<?php $dwoo->scope["day_class"]=' has-events'?>

				<?php 
}
else {
?>
					<?php $dwoo->scope["day_class"]=' no-events'?>

				<?php 
}?>

				<td class="day<?php echo $dwoo->scope["day_class"];?>"><a href="/calendar/browse/<?php echo $dwoo->scope["year"];?>/<?php echo $dwoo->scope["month"];?>/<?php echo $dwoo->scope["day_of_month"];?>"><?php echo $dwoo->scope["day_of_month"];?></a><br/>
					<ul class="events">
						<?php 
$_fh4_data = $dwoo->readVar("events.".(isset($dwoo->scope["day_of_month"]) ? $dwoo->scope["day_of_month"] : null));
if ($dwoo->isArray($_fh4_data) === true)
{
	foreach ($_fh4_data as $dwoo->scope['event'])
	{
/* -- foreach start output */
?>
						<li><a href="/calendar/view/<?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'eventId',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["event"], false);?>"><?php echo $dwoo->readVarInto(array (  1 =>   array (    0 => '->',  ),  2 =>   array (    0 => 'title',  ),  3 =>   array (    0 => '',    1 => '',  ),), $dwoo->scope["event"], false);?></a></li>
						<?php 
/* -- foreach end output */
	}
}?>

					</ul>
					</td>
				<?php 
}?>

			<?php /* -- for end output */
	}
}
?>

		<?php 
}?>

	</tr>
<?php /* -- for end output */
	}
}
?>

</table>

<?php /* -- template end output */ $dwoo->setScope($_scope, true);
}
}
if (!function_exists('Dwoo_Plugin_messages_4a892e5abd4a9')) {
function Dwoo_Plugin_messages_4a892e5abd4a9(Dwoo $dwoo, $messages) {
static $_callCnt = 0;
$dwoo->scope[' 4a892e5abd4a9'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a892e5abd4a9'.($_callCnt++)));
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
'';// checking for modification in file:/var/www/eldsjal/system/application/views/calendar.tpl
if (!("1250276017" == filemtime('/var/www/eldsjal/system/application/views/calendar.tpl'))) { ob_end_clean(); return false; };
'';// checking for modification in file:/var/www/eldsjal/system/application/views/layout.tpl
if (!("1250504115" == filemtime('/var/www/eldsjal/system/application/views/layout.tpl'))) { ob_end_clean(); return false; };
echo '';// checking for modification in file:templates.tpl
if (!("1250464309" == filemtime('/var/www/eldsjal/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<?php echo $this->assignInScope('main', 'active_section');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl<?php echo $this->assignInScope('calendar', 'active_section');?></title>
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
				<?php echo Dwoo_Plugin_input_4a892e5a99e5b($this, "text", "username", '', '', '');?> 
				<?php echo Dwoo_Plugin_input_4a892e5a99e5b($this, "submit", "search", "", "Sök", '');?>

				</div>
			</form>	
			<a class="logout confirm" href="/logout"><span>Logga ut</span></a>
			<?php 
}
else {
?>
				<form id="login" method="post" action="/login">
					<div>
						<?php echo Dwoo_Plugin_input_4a892e5a99e5b($this, "text", "username", "Namn: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4a892e5a99e5b($this, "password", "password", "Lösen: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4a892e5a99e5b($this, "submit", "login", "", "Ja!", '');?>

					</div>
				</form>
			<?php 
}?>

		</div>
		<div class="grid_8" id="submenu">
			<a class="first" href="/calendar/new">Skapa aktivitet</a>
	<a href="/calendar/history">Min historik</a>
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
	<?php echo Dwoo_Plugin_messages_4a892e5abd4a9($this, Dwoo_Plugin_getMessages($this));?>

<div id="content" class="container_16">
	<div class="grid_16">
<?php echo Dwoo_Plugin_datepager_4a892e5aab794($this, '/calendar/browse/', (isset($this->scope["year"]) ? $this->scope["year"] : null), null, null);?>

<?php echo $this->classCall('cycle', array("margin", array(0=>' alpha', 1=>'', 2=>'', 3=>' omega'), false, false, ',', null, false));?>

<?php echo $this->classCall('cycle', array("clear", array(0=>'', 1=>'', 2=>'', 3=>'<div class="clear">&nbsp;</div>'), false, false, ',', null, false));?>

<div class="calendar-year">
<?php 
$_for4_from = 1;
$_for4_to = 12;
$_for4_step = abs(1);
if (is_numeric($_for4_from) && !is_numeric($_for4_to)) { $this->triggerError('For requires the <em>to</em> parameter when using a numerical <em>from</em>'); }
$tmp_shows = $this->isArray($_for4_from, true) || (is_numeric($_for4_from) && (abs(($_for4_from - $_for4_to)/$_for4_step) !== 0 || $_for4_from == $_for4_to));
if ($tmp_shows)
{
	if ($this->isArray($_for4_from, true)) {
		$_for4_to = is_numeric($_for4_to) ? $_for4_to - $_for4_step : count($_for4_from) - 1;
		$_for4_from = 0;
	}
	if ($_for4_from > $_for4_to) {
				$tmp = $_for4_from;
				$_for4_from = $_for4_to;
				$_for4_to = $tmp;
			}
	for ($this->scope['month_number'] = $_for4_from; $this->scope['month_number'] <= $_for4_to; $this->scope['month_number'] += $_for4_step)
	{
/* -- for start output */
?>
	<div class="grid_4<?php echo $this->classCall('cycle', array("margin", null, true, true, ',', null, false));?>">
	<h4><a href="/calendar/browse/<?php echo $this->scope["year"];?>/<?php echo $this->scope["month_number"];?>"><?php echo strftime('%B', mktime(0, 0, 0, (isset($this->scope["month_number"]) ? $this->scope["month_number"] : null)));?></a></h4>
	<?php echo Dwoo_Plugin_calendar_4a892e5ab30e8($this, $this->readVar("events.".(isset($this->scope["month_number"]) ? $this->scope["month_number"] : null)), (isset($this->scope["month_number"]) ? $this->scope["month_number"] : null), (isset($this->scope["year"]) ? $this->scope["year"] : null));?>

	</div>
	<?php echo $this->classCall('cycle', array("clear", null, true, true, ',', null, false));?>

<?php /* -- for end output */
	}
}
?>

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