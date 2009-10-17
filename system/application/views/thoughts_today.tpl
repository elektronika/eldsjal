{extends "thoughts.tpl"}

{block "body"}
<div class="grid_8 alpha">
{form_open('/thoughts/today')}
{input "text" "title" "Rubrik" $thought->title}
{textarea "body" "Din tanke" $thought->body}
{input "submit" "submit" "" "Spara"}
</form>
</div>
<div class="grid_8 omega">
	<h2>Låt fingrarna springa, tangenterna rassla och känslorna flöda!</h2>
	<p>Skriv vad ditt hjärta säger, men tänk på att det du skriver kommer läsas av och påverka andra. När en tanke väl finns går det inte att ångra sig, gamla tankar går inte att radera. Tänk också på att vissa saker passar bättre i forumet, t ex frågor och diskussionsämnen.</p>
</div>
{/block}