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
			<td class="topic-subject">{a class="topic-link" href="/forum/topic/$topic->id"}{$topic->title}{/}{actions $topic->actions}</td>
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