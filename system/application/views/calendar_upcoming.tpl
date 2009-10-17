{extends "calendar.tpl"}

{block "content_class"}container_12{/block}

{block "body"}
	<h2>Ja, det här är då allt som händer framöver. *host*</h2>
	{foreach $events event}
		{event_teaser $event}
	{/foreach}
{/block}