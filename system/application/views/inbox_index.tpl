{extends "layout.tpl"}

{block "title"}
{assign 'forum' active_section}
{/block}

{block "submenu"}
	<a class="first" href="/inbox/guestbook">Gästbok</a>
	<a href="/inbox/messages">Meddelanden</a>
	<a href="/inbox/events">Aktiviteter</a>
	<a href="/inbox/forum">Forumtrådar</a>
{/block}

{block "body"}
<h2>Alerts tjohej!</h2>
<dl id="alerts">
{foreach $alerts item="alert_group" key="title"}
	<dt id="alert-group-{$title}"{if $dwoo.foreach.default.first} class="first"{/}>{$title|titlify}</dt>
		{foreach $alert_group alert}
			<dd><a href="{$alert->href}">{$alert->title}</a> {if $alert->userid}av {userlink $alert}{/if} {if $alert->count}{$alert->count}{else}{$alert->date|fuzzytime}{/if}</dd>
		{/foreach}
{/foreach}
</dl>
{/block}