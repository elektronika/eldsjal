{extends "thoughts.tpl"}

{block "body"}
{userbar $user}
<div class="grid_10 alpha">
{foreach $thoughts thought}
	{teaser $thought}
{/foreach}
</div>
<div class="grid_6 omega">
	*humdidum*
</div>
{/block}