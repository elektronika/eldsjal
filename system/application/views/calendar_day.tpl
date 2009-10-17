{extends "calendar.tpl"}

{block "body"}
{datepager '/calendar/browse/' $year $month $day}
{foreach $events event}
	{event_teaser $event}
{/foreach}
{/block}