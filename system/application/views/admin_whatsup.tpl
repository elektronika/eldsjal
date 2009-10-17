{extends "layout.tpl"}

{block "title"}
{assign 'user' active_section}
{/block}

{block "body"}
{form_open('/admin/whatsup')}
{input 'text' 'text' 'Meddelande'}
{input 'submit' 'save' '' 'Spara'}
</form>
{/block}