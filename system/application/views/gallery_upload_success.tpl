{extends "gallery.tpl"}

{block "title"}
{assign 'upload' active_sub_section}
{assign 'gallery' active_section}
- Ladda upp bild
{/block}

{block "body"}
<p>Yay, bilden är uppladdad!</p>
<p>{$resize_error}</p>
{/block}