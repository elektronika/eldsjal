{extends "layout.tpl"}

{block "body"}
<div class="grid_10 alpha">
{foreach $items item}
	{if $item->type eq 'forum'}
	<div class="item forum-item">
		<h3 class="title">{a href="/forum/topic/$item->topic_id"}{$item->topic_name}{/a} i {a href="/forum/category/$item->category_id"}{$item->category_name}{/a} <span>uppdaterades {$item->time|fuzzytime}</span></h3>
		<div class="replies">
		{foreach $item->items reply}
			<div class="reply-{$.foreach.default.iteration}">{bubble $reply}</div>
		{/foreach}
		</div>
	</div>
	{elseif $item->type eq 'thought'}
		<div class="item thought-item">{teaser $item}</div>
	{else}
	<div class="item">
		<h3 class="title">{$item->title}</h3>
		<p>{$item->body}</p>
	</div>
	{/if}
{/foreach}
</div>
<div class="grid_6 omega">
	<h3 class="title">Nyheter</h3>
	<p>(här ska det ju vara nyheter då alltså)</p>
	{foreach $news new}
		<div><h4>{a href=$new->href}{$new->title}{/a}</h4>
			{if $.foreach.default.iteration eq 1}
				<p>{$new->body|rq}</p>
			{/if}
		</div>
	{/foreach}
	
	<h3 class="title">Kommande i kalendern</h3>
	<ul>
	{foreach $events event}
		<li>{a href=$event->href}{$event->title}{/a} {$event->date|fuzzytime}</li>
	{/foreach}
	</ul>
	<p>Visa <a href="/calendar/browse/{date('Y/m/d')}">Idag</a>/<a href="/calendar/browse/{date('Y/m')}">Denna månaden</a>/<a href="/calendar/browse/{date('Y')}">Detta året</a></p>
	<div class="grid_3 alpha">
	<h3 class="title">Födelsedagsbarn</h3>
	<ul>
	{foreach $birthdays birthday}
		<li>{userlink $birthday}</li>
	{/foreach}
	</ul>
	</div>
	<div class="grid_3 omega">
		<h3 class="title">Senast inloggade</h3>
		<ul>
		{foreach $latest_logins login}
			<li>{userlink $login}</li>
		{/foreach}
		</ul>
	</div>
	<br/>&nbsp;<br/>
	<h3 class="title">Om Eldsjäl</h3>
	<p>Föreningen Eldsjäl är helt utan kopplingar till politiska samt religiösa förbund. Föreningen Eldsjäl handlar om att samla människor med liknande intressen och underlätta för ökat utbyte av erfarenheter, värme och medmänsklighet. Föreningen Eldsjäl verkar för ökad kulturell bredd i hela Norden med fokus på kulturyttringar som inte får stor uppmärksamhet i den allmänna debatten. Föreningen Eldsjäl arbetar aktivt för att motarbeta mobbing, främlingsfientlighet och förtryck.</p>

	<p>Eldsjal.org är en tjänst som Föreningen Eldsjäl med stolthet tillhandahåller allmänheten kostnadsfritt, oavsett medlemsskap i föreningen för att sprida våra budskap och aktivt arbeta med våra målsättningar.</p>
</div>
{/block}