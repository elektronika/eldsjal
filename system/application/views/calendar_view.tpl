{extends "calendar.tpl"}

{block "body"}
<div class="grid_12 alpha">
{event_teaser $event FALSE}
{* printr $event *}
</div>
<div class="grid_4 omega">
	{if $user_has_signed_up}
		{signoff $event->id}
	{else}
		{signup $event->id}
	{/if}
	{if $attendees}
	<h3>Vi ska med!</h3>
	<ul>
		{foreach $attendees user}
			<li>{userlink $user}</li>
		{/foreach}
	</ul>
	{/if}
</div>
{/block}