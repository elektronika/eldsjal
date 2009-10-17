{extends "guestbook.tpl"}

{block "body"}
{userbar $user}
<div id="guestbook">
{foreach $posts post}
	{bubble $post}
{/foreach}
{pager $pager}
</div>
{/block}