{extends "info.tpl"}

{block "content_class"}container_12{/block}

{block "body"}
<div class="grid_4 alpha">
	<h2>Om Eldsjäl</h2>
	<p>Föreningen Eldsjäl är helt utan kopplingar till politiska samt religiösa förbund. Föreningen Eldsjäl handlar om att samla människor med liknande intressen och underlätta för ökat utbyte av erfarenheter, värme och medmänsklighet.</p> 
	<p>Föreningen Eldsjäl verkar för ökad kulturell bredd i hela Norden med fokus på kulturyttringar som inte får stor uppmärksamhet i den allmänna debatten. Föreningen Eldsjäl arbetar aktivt för att motarbeta mobbing, främlingsfientlighet och förtryck.</p>
</div>
<div class="grid_4">
	<h2>Om eldsjal.org</h2>
	<p>Eldsjal.org är en tjänst som Föreningen Eldsjäl med stolthet tillhandahåller allmänheten kostnadsfritt, oavsett medlemsskap i föreningen, för att sprida våra budskap och aktivt arbeta med våra målsättningar.</p>
</div>
<div class="grid_4 omega">
	<h2>Styrelsen</h2>
	{foreach $boardmembers member}
		<div class="board-member">
		{userimage $member}
		<div class="board-member-info">
		{$member->first_name} "{userlink $member}" {$member->last_name}<br/>
		{$member->title}<br/>
		{safe_mailto($member->email)}
		</div>
		<div class="clear"> </div>
		</div>
	{/foreach}
</div>
{/block}