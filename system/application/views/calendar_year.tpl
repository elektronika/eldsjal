{extends "calendar.tpl"}

{block "body"}
{datepager '/calendar/browse/' $year}
{cycle name="margin" values=array(' alpha', '', '', ' omega') advance=FALSE print=FALSE}
{cycle name="clear" values=array('', '', '','<div class="clear">&nbsp;</div>') advance=FALSE print=FALSE}
<div class="calendar-year">
{for month_number 1 12}
	<div class="grid_4{cycle name="margin"}">
	<h4><a href="/calendar/browse/{$year}/{$month_number}">{strftime('%B', mktime(0,0,0, $month_number))}</a></h4>
	{calendar $events.$month_number $month_number $year}
	</div>
	{cycle name="clear"}
{/for}
</div>
{/block}