{extends "layout.tpl"}

{block "title"}
{assign 'calendar' active_section}
{/block}

{block "submenu"}
	<a class="first" href="/calendar/new">Skapa aktivitet</a>
	<a href="/calendar/history">Min historik</a>
{/block}