{load_templates "templates.tpl"}
<form method="post" class="guestbook" action="/guestbook/ajax_add/{$userid}">
	{textarea 'body' 'Gästboksinlägg'}<br/>
	{input 'submit' 'save' '' 'Hit it!'}
	{input 'submit' 'cancel' '' 'Äh, det var inget.'}
</form>