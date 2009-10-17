{extends "user.tpl"}

{block "body"}
{userbar $user}
{** printr $user **}
{form_open}
{inputs $fields $user_array}
{input 'submit' 'save' '' 'Spara'}
</form>
{/block}