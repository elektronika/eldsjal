{extends "layout.tpl"}

{block "title"}
{assign 'people' active_section}
{/block}

{block "submenu"}
	<a class="first" href="/people/neighbours">Folk i närheten av mig</a>
	<a href="/people/guardians">Faddrar</a>
	<a href="/people/search">Supersöken</a>
	<a href="/people/map">Kartan</a>
{/block}