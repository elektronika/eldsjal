{extends "calendar.tpl"}

{block "content_class"}container_12{/block}

{block "body"}
<div class="grid_8 alpha">
	{foreach $upcoming event}
		{event_teaser $event}
	{/foreach}
	<a href="/calendar/upcoming">Visa alla kommande aktiviteter i en enda lång lista!</a>
</div>
<div class="grid_4 omega">
	<h3>Visa mig mer som händer...</h3>
	<p>
	<a href="/calendar/browse/{date('Y')}">...detta året</a><br/>
	<a href="/calendar/browse/{date('Y/m')}">...denna månaden</a><br/>
	<a href="/calendar/browse/{date('Y/m/d')}">...idag</a></p>
	{if $attending}
	<h3>Du är anmäld till...</h3>
	<ul class="attending event-list">
	{foreach $attending event}
		<li><a href="/calendar/view/{$event->id}">{$event->title}</a></li>
	{/if}
	{if $posted}
	<h3>Du lagt upp...</h3>
	<ul class="posted event-list">
	{foreach $posted event}
		<li><a href="/calendar/view/{$event->id}">{$event->title}</a></li>
	{/if}
</div>
{/block}