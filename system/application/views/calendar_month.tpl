{extends "calendar.tpl"}

{block "body"}
{datepager '/calendar/browse/' $year $month}
<div class="calendar-month">
{calendar $events $month $year}
</div>
{* printr $events *}
{/block}