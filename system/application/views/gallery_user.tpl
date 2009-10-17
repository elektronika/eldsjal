{extends "gallery.tpl"}

{block "body"}
{userbar $user}
{foreach $images image}
	{thumbnail $image}
{/foreach}
{/block}