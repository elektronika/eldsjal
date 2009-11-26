{extends "forum.tpl"}

{block "body"}
<h2>{a href="/forum"}Forum{/} &raquo; {$category->forumCategoryName}</h2>
{* {a href="/forum/new/$category->forumCategoryId"}Ny tråd!{/a *} 
<table id="forum-topics">
	<thead>
		<tr>
			<th>Ämne</th>
			<th>Senaste svar</th>
			<th>Svar</th>
			<th>Skapad</th>
		</tr>
	</thead>
	<tbody>
{foreach $topics topic}
		<tr class="{implode(' ', $topic->classes)}">
			<td class="topic-subject"><span class="topic-link">{a href="/forum/topic/$topic->id"}{$topic->title}{/} {pagespan $topic->pages "/forum/topic/$topic->id" $posts_per_page} {if isset($topic->classes['new'])} {a href="/forum/redirectupdated/$topic->id"}&raquo;{/a}{/if}</span> {actions $topic->actions}</td>
			<td class="topic-lastrepy">{if $topic->replies eq 0}-{else}{$topic->updated|fuzzytime:'':' sedan'} av {userlink $topic->updater}{/if}</td>
			<td class="topic-replies">{$topic->replies}</td>
			<td class="topic-creator">{$topic->created|shortdate} av {userlink $topic->creator}</td>
		</tr>
{/foreach}
	</tbody>
</table>
{* foreach $topics topic}
	{teaser $topic FALSE}
{/foreach *}
{pager $pager}
{* printr $topics *}

{/block}