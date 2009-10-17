{extends "layout.tpl"}

{block "title"}
	{assign 'gallery' active_section}
	- Galleri
{/block}

{block "submenu"}
	<a {if $active_sub_section eq 'upload'} class="active first" {else} class="first" {/if} href="/gallery/upload">Ladda upp</a>
	<a id="gallery-random" {if $active_section eq 'random'} class="active" {/if}href="/gallery/random">Slumpad bild</a>
{/block}