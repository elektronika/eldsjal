{load_templates("templates.tpl")}
<div class="usermenu u{$user->userid}">
	{userimage $user}
	<div class="userinfo">
		<h3 class="title"><span>{$user->first_name} "</span>{$user->username}<span>" {$user->last_name}</span></h3>
		<h4>{$user->birthday|age} år. Bor i {$user->inhabitance}, {$user->location}.{if $user->online} <span class="online">Online</span>{/if}</h4>
		<div class="sysslarmed"><span>Sysslar med</span> {$user->does|natural_implode:'och'}.</div>
		{actions $user->actions}
	</div>
	<div class="usermenu-inject"></div>
</div>