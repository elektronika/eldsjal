{extends "calendar.tpl"}

{block "body"}
<div class="grid_12 alpha">
{event_teaser $event FALSE}
{if $posts}
<h4>Kommentarer:</h4>
{/if}
{foreach $posts post}
	{bubble $post}
{else}
<p>Inga inlägg här du. Gör nåt åt et vetja!</p>
{/foreach}
{if $user_can_comment}
	{form_open()}
		{textarea "body" "Inlägg"}
		{input "submit" "submit" "" "Spara"}
	</form>
{/if}
{* printr $event *}
</div>
<div class="grid_4 omega">
	{if $user_has_signed_up}
		{signoff $event->id}
	{else}
		{signup $event->id}
	{/if}
	{if $collisions}
		<h3>Samtidigt som...</h3>
		<ul>
			{foreach $collisions event}
				<li>{a href=$event->href}{$event->title}{/a}</li>
			{/foreach}
		</ul>
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