{extends "forum.tpl"}

{block "body"}
{form_open('/forum/new')}
{input "text" "title" "Rubrik"}
{select "category" $categories $cat_id "Kategori"}
{textarea "body" "Inlägg"}
{input "submit" "submit" "" "Spara"}
</form>
{/block}