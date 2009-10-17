{extends "people.tpl"}

{block "body"}
{foreach $people dude}
	{bubble $dude}
{/foreach}
{/block}