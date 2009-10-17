{extends "layout.tpl"}

{block "title"}
{assign 'forum' active_section}
{/block}

{block "submenu"}
	<a class="first" href="/forum/new">Skapa tråd</a>
	<a href="/forum/watched">Bevakade trådar</a>
	<a href="/forum/random">Slumpad tråd</a>
{/block}