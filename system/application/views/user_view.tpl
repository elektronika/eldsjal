{extends "user.tpl"}

{block "body"}
{userbar $user}
<div class="grid_10 alpha">
	{$user->presentation|escape|rq}
</div>
<div class="grid_6 omega">
	<h3>Kontaktinfo</h3>
	<dl>
		<dt>E-mail</dt>
		<dd>{$user->email|escape}</dd>
		<dt>MSN</dt>
		<dt>{$user->msn|escape}</dt>
		<dt>ICQ</dt>
		<dt>{$user->icq|escape}</dt>
		<dt>Telefon</dt>
		<dt>{$user->phone|escape}</dt>
		<dt>Hemsida</dt>
		<dt>{$user->webpage|escape}</dt>
	</dl>
	<h3>Sysslar med</h3>
	<ul>{foreach $user->does do}
		<li>{$do}</li>
	{/foreach}</ul>
</div>
{** printr $user **}
{/block}