{extends "forum.tpl"}

{block "body"}
<h2>{a href="/forum"}Forum{/} &raquo; {a href="/forum/category/$topic->forumCategoryID"}{$topic->forumCategoryName}{/} &raquo; {$topic->title}</h2>
<div class="grid_10 alpha">
{foreach $posts post}
	{bubble $post}
{/foreach}
{pager $pager}
{if $user_can_reply}
{form_open("/forum/topic/$topic->id")}
{textarea "body" "Inlägg"}
{input "submit" "submit" "" "Spara"}
</form>
{/if}
</div>
<div class="grid_6 omega">
<p>Ja, här ska det ju då vara en högerkolumn.</p>
<p>*lalala*</p>
<p>Med t ex liknande trådar, vem som tjötat mest i tråden, etc.</p>
</div>
{/block}