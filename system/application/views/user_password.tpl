{extends "user.tpl"}

{block "body"}
{userbar $user}
{form_open("/user/$user->slug/password")}
<fieldset>
	<legend>Lösenordsbyte</legend>
	{input "password" "current" "Nuvarande lösenord" ''}
	{input "password" "new" "Nytt lösenord" ''}
	{input "password" "confirm" "Bekräfta lösenordet" ''}
</fieldset>
{input 'submit' '' '' 'Ändra lösenord'}
</form>
{/block}