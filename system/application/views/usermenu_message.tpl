{load_templates "templates.tpl"}
<form method="post" class="guestbook" action="/message/ajax_add/{$userid}">
	{input 'text' 'title' 'Ämne'}
	{textarea 'body' 'Meddelande'}<br/>
	{input 'submit' 'save' '' 'Färdig!'}
	{input 'submit' 'cancel' '' 'Äh, skit it.'}
</form>