{load_templates "templates.tpl"}
{assign 'main' active_section}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  
<head>
	<title>Eldsjäl{block "title"} - Vad brinner du för?{/block}</title>
	<link rel="stylesheet" href="/beta/reset.css" type="text/css"/>
	<link rel="stylesheet" href="/beta/960.css" type="text/css"/>
	<link type="text/css" href="/beta/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
	<link rel="stylesheet" href="/beta/style.css?{rand()}" type="text/css"/>
	{*<script src="/beta/jquery.min.js" type="text/javascript"></script>*}
	<script src="/beta/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="/beta/jquery.hoverIntent.js" type="text/javascript"></script>
	{*<script src="/beta/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>*}
	<script src="/beta/scripts.js?{rand()}" type="text/javascript"></script>
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
				<a href="/forum/" {if $active_section eq 'forum'} class="active first" {else} class="first" {/if}title="Diskutera, fundera och spekulera fritt med andra eldsj&auml;lar *inl&auml;gg kr&auml;ver medlemskap*">Forum</a>
				<a href="/calendar/" {if $active_section eq 'calendar'} class="active" {/if}title="Allt möjligt hittepå som händer runtomkring i landet!">Kalender</a>
				<a href="/thoughts/" {if $active_section eq 'thoughts'} class="active" {/if}title="Ditten och datten, sånt som rör sig i huvet på Eldsjäl helt enkelt!">Tankar</a>
				<a href="/people/" {if $active_section eq 'people'} class="active" {/if}title="H&auml;r finns alla v&aring;ra medlemmar!">Folk</a>
				<a href="/gallery/" {if $active_section eq 'gallery'} class="active" {/if}title="Underbara bilder med anknytning till alternativkonst fr&aring;n v&aring;ra medlemmar *uppladdning kr&auml;ver medlemskap*">Galleri</a>
				<a href="/wiki/" {if $active_section eq 'wiki'} class="active" {/if}title="Vår samlade kunskap! Wiki'n använder vi för allt möjligt, och du får gärna fylla på själv!">Wiki</a>
				<a href="/info/" {if $active_section eq 'info'} class="active" {/if}title="Information om f&ouml;reningen">Om</a>
			</div>
		</div>
		<div class="grid_8" id="userbar">
			{if isloggedin()}
			{active_userlink}
			<a class="inbox" href="/inbox">Inbox<span id="alert-counter"> {alertcounter}</span></a>
			<form id="quicksearch" action = "/members.php?mode=listMembers" method = "post"> 
				<div>
				{input "text" "username"} 
				{input "submit" "search" "" "Sök"}
				</div>
			</form>	
			<a class="logout confirm" href="/logout"><span>Logga ut</span></a>
			{else}
				<form id="login" method="post" action="/login">
					<div>
						{input "text" "username" "Namn: "}
						{input "password" "password" "Lösen: "}
						{input "submit" "login" "" "Ja!"}
					</div>
				</form>
			{/if}
		</div>
		<div class="grid_8" id="submenu">
		{block "submenu"}&nbsp;{/block}
		</div>
		<div class="grid_8" id="usersub">
			{if isloggedin()}
			<div id="whatsup">
				Just nu: <span>{whatsup}</span>
			</div>
			{else}
			<a href="/forgotpassword">Glömt lösenordet?</a>
			<a href="/register" class="last">Bli medlem</a>
			{/if}
		</div>
	</div>
</div>
<div id="content-wrap">
	{messages getMessages()}
<div id="content" class="{block "content_class"}container_16{/block}">
	<div class="grid_16">
{block "body"}
Här sare va body-content jao!
{/block}
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
			<a href = "members.php?mode=showOnline" class = "a2" >{usersonline} eldsjälar är online</a><br/>
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
				{wisdom()|rq}
			</p></div>
		</div>
		<div class="clear">&nbsp;</div>
		</div>
		<div class="grid_4">
			Det &auml;r ej till&aring;tet att misstro, glömma eller förtränga information fr&aring;n Eldsj&auml;l.
		</div>
		<div class="grid_4">
			&copy; F&ouml;reningen Eldsj&auml;l 2005 - {date('Y')} och respektive upprorsman
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
</html>