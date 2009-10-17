{extends "gallery.tpl"}

{block "title"}
{assign 'upload' active_sub_section}
{assign 'gallery' active_section}
- Ladda upp bild
{/block}

{block "body"}
<h2>Sharing is caring!</h2>
{form_open_multipart('gallery/upload')}
<div class="grid_8 alpha">
{input "file" "file" "Börja med att välja filen som ska laddas upp..."}
{input "text" "title" "...ge den en schysst titel..."}
{input "text" "body" "...och en lattjo beskrivning"}
{input "submit" "submit" "" "Spara"}
</div>
<div class="grid_8 omega">
<fieldset id="categories">
	<legend>Sen bockar du i de kategorier du tycker passar. Men inget löjl!</legend>
{foreach $tags tag}{input "checkbox" "tag[$tag->id]" $tag->tag}{/foreach}
</fieldset>
</div>
</form>
{/block}