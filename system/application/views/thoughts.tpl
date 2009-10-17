{extends "layout.tpl"}

{block "title"}
{assign 'thoughts' active_section}
{/block}

{block "submenu"}
	<a class="first" href="/thoughts/today">Dagens tanke</a>
	<a href="/thoughts/mine">Mina tankar</a>
	{*<a href="/thoughts/bookmarked">Mina bokmärkta tankar</a>*}
{/block}