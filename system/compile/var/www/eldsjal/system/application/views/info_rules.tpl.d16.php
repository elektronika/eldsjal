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
if (!function_exists('Dwoo_Plugin_input_4a8b23ea36649')) {
function Dwoo_Plugin_input_4a8b23ea36649(Dwoo $dwoo, $type, $name, $label = "", $value = "", $error = "") {
static $_callCnt = 0;
$dwoo->scope[' 4a8b23ea36649'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a8b23ea36649'.($_callCnt++)));
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
if (!function_exists('Dwoo_Plugin_messages_4a8b23ea5f2c9')) {
function Dwoo_Plugin_messages_4a8b23ea5f2c9(Dwoo $dwoo, $messages) {
static $_callCnt = 0;
$dwoo->scope[' 4a8b23ea5f2c9'.$_callCnt] = array();
$_scope = $dwoo->setScope(array(' 4a8b23ea5f2c9'.($_callCnt++)));
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
'';// checking for modification in file:/var/www/eldsjal/system/application/views/info.tpl
if (!("1250276015" == filemtime('/var/www/eldsjal/system/application/views/info.tpl'))) { ob_end_clean(); return false; };
'';// checking for modification in file:/var/www/eldsjal/system/application/views/layout.tpl
if (!("1250504115" == filemtime('/var/www/eldsjal/system/application/views/layout.tpl'))) { ob_end_clean(); return false; };
echo '';// checking for modification in file:templates.tpl
if (!("1250464309" == filemtime('/var/www/eldsjal/system/application/views/templates.tpl'))) { ob_end_clean(); return false; };?>

<?php echo $this->assignInScope('main', 'active_section');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl<?php echo $this->assignInScope('info', 'active_section');?></title>
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
				<?php echo Dwoo_Plugin_input_4a8b23ea36649($this, "text", "username", '', '', '');?> 
				<?php echo Dwoo_Plugin_input_4a8b23ea36649($this, "submit", "search", "", "Sök", '');?>

				</div>
			</form>	
			<a class="logout confirm" href="/logout"><span>Logga ut</span></a>
			<?php 
}
else {
?>
				<form id="login" method="post" action="/login">
					<div>
						<?php echo Dwoo_Plugin_input_4a8b23ea36649($this, "text", "username", "Namn: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4a8b23ea36649($this, "password", "password", "Lösen: ", '', '');?>

						<?php echo Dwoo_Plugin_input_4a8b23ea36649($this, "submit", "login", "", "Ja!", '');?>

					</div>
				</form>
			<?php 
}?>

		</div>
		<div class="grid_8" id="submenu">
			<a class="first" href="/info/rules">Stadgar</a>
	<a href="/info/groups">Arbetsgrupper</a>
	<a href="/info/policies">Policydokument</a>
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
	<?php echo Dwoo_Plugin_messages_4a8b23ea5f2c9($this, Dwoo_Plugin_getMessages($this));?>

<div id="content" class="container_12">
	<div class="grid_16">
<h2>Föreningen Eldsjäls stadgar</h2>
<STRONG>Centrala Stadgar</STRONG><P>
	<I>F&ouml;r lokala stadgar se <A HREF="http://www.eldsjal.org/forum.asp?mode=readTopic&category=10&threadId=4975" class=a3>denna sida</A></I><P>

<STRONG>&#167;1. Namn</STRONG><BR>
F&ouml;reningens namn &auml;r Eldsj&auml;l.<P>

<STRONG>&#167;2. Form</STRONG><BR>
Eldsj&auml;l &auml;r en ideell f&ouml;rening. Eldsj&auml;l st&aring;r sj&auml;lvst&auml;ndig gentemot stater, kommuner, religi&ouml;sa, politiska och privata intressen. F&ouml;reningens s&auml;te &auml;r i Stockholm.<P>

<STRONG>&#167;3. Syfte och m&aring;ls&auml;ttning</STRONG><BR>
Eldsj&auml;l &auml;r en &ouml;ppen f&ouml;rening.<BR>
F&ouml;reningen skall st&ouml;dja och uppmuntra medlemmarnas kulturella och sociala engagemang. F&ouml;reningen skall ocks&aring; verka f&ouml;r att medlemmarna, genom kunskaps- och erfarenhetsutbyte, har m&ouml;jlighet att utvecklas kreativt och socialt.<BR>
En stor del av Eldsj&auml;ls arbete fokuserar p&aring; gatuteater, konst, hantverk, nycirkus, teater och musik i alla dess former.<BR>
Eldsj&auml;l skall vara &ouml;ppen f&ouml;r nya konstformer och s&auml;tt f&ouml;r individer att uttrycka sig, samt fr&auml;mja ett samh&auml;lle d&auml;r detta &auml;r m&ouml;jligt.<BR>
Eldsj&auml;l arbetar aktivt f&ouml;r att motverka fr&auml;mlingsfientlighet, diskriminering samt mobbing av alla dess slag.<BR>
Eldsj&auml;l arbetar f&ouml;r att fr&auml;mja direktdemokrati.<P>

<STRONG>&#167;4. Medlemskap</STRONG><BR>
F&ouml;reningen &auml;r &ouml;ppen f&ouml;r alla fysiska personer. Medlem &auml;r den som godk&auml;nt medlemskap i en av eldsj&auml;ls lokalavdelningar. Medlem har r&ouml;str&auml;tt p&aring; medlems- och &aring;rsm&ouml;te. Medlem ansvarar f&ouml;r att verka i enlighet med Eldsj&auml;ls m&aring;ls&auml;ttning och uppfyller de av Eldsj&auml;l stadgade kraven.<BR>
Medlem uppmuntras att engagera sig i m&ouml;ten och att utveckla f&ouml;reningen. Medlem ansvarar ocks&aring; f&ouml;r att f&ouml;lja alla policydokument.<P>

<STRONG>&#167;5. Lokalavdelning</STRONG><BR>
Beslut om startande av lokalavdelning, sammanslagning av lokalavdelning eller delning av lokalavdelning g&ouml;rs av styrelsen. Alla lokalavdelningar &auml;r upptecknade i Eldsj&auml;ls lista &ouml;ver lokalavdelningar. Alla lokalavdelningar anv&auml;nder Eldsj&auml;ls mall f&ouml;r lokalavdelningar. F&ouml;r&auml;ndringar i mallen f&ouml;r lokalavdelningar tas upp p&aring; &aring;rsm&ouml;te i form av motioner.<P>

<STRONG>&#167;6. Kommunikation</STRONG><BR>
Intern kommunikation i f&ouml;reningen sker genom elektronisk media. F&ouml;reningens plattform &auml;r http://www.eldsjal.org.<BR>
Alla kallelser, policydokument, protokoll samt motioner skall finnas tillg&auml;ngliga f&ouml;r medlemmar via plattformen eller e-post, medlem ansvarar f&ouml;r att ta del av dessa. Motioner skall publiceras p&aring; plattformen minst 24 timmar innan medlems- eller &aring;rsm&ouml;te.<P>

<STRONG>&#167;7. M&ouml;ten</STRONG><BR>
Medlemsm&ouml;te behandlar propositioner, motioner och f&ouml;rslag. Medlemsm&ouml;te skall utlysas minst 72 timmar i f&ouml;rv&auml;g.<BR>
Alla medlemmar kan utlysa ett medlemsm&ouml;te.<BR>
&Aring;rsm&ouml;te skall utlysas minst 14 dagar i f&ouml;rv&auml;g av styrelsen och skall behandla f&ouml;ljande:<BR>
- verksamhetsber&auml;ttelse<BR>
- bokslut<BR>
- ansvarsfrihet f&ouml;r avg&aring;ende styrelse<BR>
- val av ny styrelse<BR>
- val av revisor<BR>
- fastst&auml;llande av f&ouml;rm&aring;nsmedlemsavgift<BR>
- propositioner, motioner och f&ouml;rslag<BR>
- val av valberedning som skall best&aring; av 3 fysiska personer.<BR>
Vid alla m&ouml;ten skall en majoritet av styrelsen n&auml;rvara f&ouml;r att m&ouml;tet skall vara giltigt. &Aring;rsm&ouml;te skall h&aring;llas senast juni m&aring;nad.<P>

<STRONG>&#167;8. Styrelse</STRONG><BR>
Styrelsen beslutar &ouml;ver l&ouml;pande fr&aring;gor och &auml;r underst&auml;lld medlems- och &aring;rsm&ouml;te. En majoritet av styrelsen m&aring;ste n&auml;rvara f&ouml;r att styrelsen skall vara
beslutsm&auml;ssig. Styrelsen skall str&auml;va efter konsensusbeslut, vid oenighet g&auml;ller enkel majoritet. Styrelsem&ouml;te skall h&aring;llas minst tre g&aring;nger per &aring;r.<BR>
Styrelsen skall best&aring; av 7 - 11 ordinarie ledam&ouml;ter. Styrelsen konstituerar sig sj&auml;lva med undantag av ordf&ouml;rande och kass&ouml;r som v&auml;ljs vid &aring;rsm&ouml;te.<BR>
Nya ers&auml;ttare f&ouml;r styrelsemedlemmar v&auml;ljs vid medlemsm&ouml;te.<P>

<STRONG>&#167;9. Firmatecknare</STRONG><BR>
Firmatecknare f&ouml;r f&ouml;reningen Eldsj&auml;l &auml;r nuvarande Ordf&ouml;rande och Kass&ouml;r.<P>

<STRONG>&#167;10. Verksamhets&aring;r</STRONG><BR>
F&ouml;reningens verksamhets&aring;r l&ouml;per fr&aring;n f&ouml;rsta januari till sista december.<P>

<STRONG>&#167;11. Uteslutning</STRONG><BR>
Medlem som klart bryter mot Eldsj&auml;ls stadgar, kan av styrelsen uteslutas. Den uteslutne har r&auml;tt att &ouml;verklaga beslutet vid medlemsm&ouml;te d&auml;r den uteslutne har r&ouml;str&auml;tt. Styrelsen f&ouml;rbeh&aring;ller sig r&auml;tten att direkt utesluta medlem som, i Eldsj&auml;ls namn, beg&aring;r lagbrott.<P>

<STRONG>&#167;12. Omr&ouml;stning</STRONG><BR>
Vid &aring;rs- och medlemsm&ouml;te g&auml;ller f&ouml;ljande:<BR>
- Vid beslut skall konsensus efterstr&auml;vas.<BR>
- Vid lika r&ouml;stetal avg&ouml;r ordf&ouml;randes r&ouml;st. Vid lika r&ouml;stetal i personval sker omr&ouml;stning mellan de tv&aring; starkaste kandidaterna, om majoritet ej erh&aring;lles sker lottning.<P>

<STRONG>&#167;13. Stadge&auml;ndring</STRONG><BR>
F&ouml;r att &auml;ndra Eldsj&auml;ls stadgar kr&auml;vs 2/3 majoritet vid ett &aring;rsm&ouml;te. Beslutet tr&auml;der i kraft 30 dagar efter att beslutet delgivits f&ouml;reningsmedlemmarna, f&ouml;rutsatt att ingen protest har l&auml;mnats in.<P>

En f&ouml;reningsmedlem har r&auml;tt att l&auml;mmna in en protest mot stadge&auml;ndring.<P>

En protest mot stadge&auml;ndring ska vara styrelsen tillhanda skriftligen inom 30 dagar efter det att beslut r&ouml;rande stadge&auml;ndring delgivits f&ouml;reningsmedlemmarna. D&aring; protest l&auml;mnas in kr&auml;vs ytterligare ett medlemsm&ouml;te med 2/3 majoritet f&ouml;r att &auml;ndra dessa stadgar. Beslutet tr&auml;der i kraft d&auml;refter.<P>

<STRONG>&#167;14. Uppl&ouml;sning</STRONG><BR>
F&ouml;reningens uppl&ouml;sning beslutas med minst 2/3 majoritet vid tre p&aring; varandra f&ouml;ljande medlemsm&ouml;ten varav ett &aring;rsm&ouml;te. Efter revisorernas godk&auml;nnande av r&auml;kenskaperna skall tillg&aring;ngarna f&ouml;rdelas till organisationer eller f&ouml;reningar med liknande m&aring;ls&auml;ttning. Det sista m&ouml;tet beslutar om f&ouml;rdelning av medel.
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