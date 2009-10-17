{extends "gallery.tpl"}

{block "body"}
{foreach $images image}
	{thumbnail $image}
{/foreach}
<div class="clear"> </div>
{pager $pager}
{if $tags}
<div>
Visar bilder som matchar
{foreach $tags tag}
	{$tag->artname}{a href="/gallery/$tag->href"}(x){/a}
{/foreach}
</div>
{/if}
{tagcloud $tagcloud $tagcloud_prefix}
{*
<pre>
	{$arguments|print_r}
</pre>*}
{/block}