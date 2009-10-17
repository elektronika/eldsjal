{extends "gallery.tpl"}

{block "body"}
<div id="image">
	<div id="image-border">
		<img src="{$image->src}" alt="{$image->title}"/>
	</div>
	{teaser $image FALSE}
</div>
{/block}