{extends "thoughts.tpl"}

{block "content_class"}container_12{/block}

{block "body"}
<div class="grid_8 alpha">
{foreach $thoughts thought}
	{teaser $thought}
{/foreach}
{pager $pager}
</div>
<div class="grid_4 omega">
	<h2>Vad har du på hjärtat?</h2>
	<p>Vad gnager dig? Vad får dig att tända till? Vad älskar du? Vad hatar du?</p>
	<h3>Släpp loss...</h3>
	<p>(mer text)</p>
	<h3>...men tänk efter</h3>
	<p>För när en tanke väl är publicerad så går den inte att radera.</p>
	
	<h3>Tankar i siffror</h3>
	<p>(lattjo statistik över tankarna, typ antal, när det skrevs flest, etc)</p>
</div>
{/block}