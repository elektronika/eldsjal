{extends "forum.tpl"}

{block "content_class"}container_12{/block}

{block "body"}
<h2>{a href="/forum"}Forum{/} &raquo; {a href="/forum/category/$topic->forumCategoryID"}{$topic->forumCategoryName}{/} &raquo; {$topic->title}</h2>
<div class="grid_10 alpha">
{foreach $posts post}
	{bubble $post}
{/foreach}
{if $user_can_reply}
{form_open("/forum/topic/$topic->id")}
{textarea "body" "Inlägg"}
{input "submit" "submit" "" "Spara"}
</form>
{/if}
</div>
<div class="grid_2 omega">
<p>Ja, här ska det ju då vara en högerkolumn.</p>
<p>*lalala*</p>
</div>
{/block}