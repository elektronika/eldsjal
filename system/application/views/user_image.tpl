{extends "user.tpl"}

{block "body"}
{userbar $user}
<h3>Jag tycker att du ska ta en bra bild!</h3>
{form_open_multipart("/user/$user->slug/image")}
{input "file" "file" "Välj här!"}
{input 'submit' '' '' 'Ladda upp!'}
</form>
{/block}