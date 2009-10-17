{extends "forum.tpl"}

{block "body"}
<div class="grid_16 alpha omega">
<h2>Forum</h2>
{*foreach $categories cat}
{teaser $cat FALSE}
{/foreach*}
<table id="forum-categories">
	<thead>
		<tr>
			<th>Kategori</th>
			<th>Trådar</th>
			<th>Senaste inlägg</th>
		</tr>
	</thead>
	<tbody>
{foreach $categories cat}
	<tr class="{implode(' ', $cat->classes)}">
		<td class="category-title">{a href="$cat->href"}{$cat->title}{/}<span> - {$cat->description}</span></td>
		<td class="category-threads">{$cat->threads}</td>
		<td class="category-updated">{$cat->updated|fuzzytime:'':' sedan'}</td>
	</tr>
{/foreach}
	</tbody>
</table>
</div>
{*
<div class="grid_2 omega">
	<h3>Ge &amp; ta!</h3>
	<p>Välkommen till forumet, vårt alldeles egna fikabord, lägereld och innergård. Snacka skit om äpplen och päron, eller ha en seriös diskussion om vattnets betydelse för sjöfarten. Anything goes!</p>
	<h3>Forumstatistik</h3>
	<p>Som för tankarna, fast för forumet. Typ.</p>
</div>
*}
{/block}