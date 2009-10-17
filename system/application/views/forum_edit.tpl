{extends "forum.tpl"}

{block "body"}
{form_open($form_action)}
{if $is_first_post}
	{input "text" "title" "Rubrik" $topic->title}
	{if $is_moderator}
		{select "category" $categories $topic->category_id "Kategori"}
		{input "checkbox" "sticky" "Klistrad"}
		{input "checkbox" "locked" "Låst"}
		{input "checkbox" "is_news" "Nyhet"}
	{/if}
{/if}
{textarea "body" "Inlägg" $post->body}
{input "submit" "submit" "" "Spara"}
</form>
{/block}