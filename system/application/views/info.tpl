{extends "layout.tpl"}

{block "title"}
{assign 'info' active_section}
{/block}

{block "submenu"}
	<a class="first" href="/info/rules">Stadgar</a>
	<a href="/info/groups">Arbetsgrupper</a>
	<a href="/info/policies">Policydokument</a>
{/block}