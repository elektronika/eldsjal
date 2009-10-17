{extends "user.tpl"}

{block "body"}
{userbar $user}
{** printr $user **}
{form_open("/user/{$user->slug}/edit")}
<fieldset>
	<legend>Kontoinformation</legend>
	{input "text" "username" "Användarnamn" $user->username}
	{input "text" "email" "E-mail" $user->email}
	<div><a href="/user/{$user->slug}/password">Byt lösenord</a></div>
</fieldset>
<fieldset>
	<legend>Kontaktinfo</legend>
	{input "text" "first_name" "Förnamn" $user->first_name}
	{input "text" "last_name" "Efternamn" $user->last_name}
	{input "text" "msn" "MSN" $user->msn}
	{input "text" "icq" "ICQ" $user->icq}
	{input "text" "webpage" "Hemsida" $user->webpage}
	{input "text" "phone" "Telefonnummer" $user->phone}
	{select "location" $locations $user->locationId "Område"}
</fieldset>
{input 'submit' '' '' 'Spara'}
</form>
{/block}