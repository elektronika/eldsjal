{extends "thoughts.tpl"}

{block "content_class"}container_12{/block}

{block "body"}
<div class="grid_8 alpha">
<h2>Tänka sig, du har tänkt allt det här!</h2>
{foreach $thoughts thought}
	{teaser $thought}
{/foreach}
</div>
<div class="grid_4 omega">
	<h3>Plocka hem</h3>
	<p>Vill du spara alla dina tankar någon annanstans än här? Klicka på knappen nedanför och spara sidan som kommer upp. Den är dessutom anpassad för utksrift, om du känner för att vara lite mer analog.</p>
	<h3>Rensa ur</h3>
	<p>Ibland vill man börja om. Det är ok. Klickar du på knappen nedanför så raderas <em>alla</em> dina tankar för gott, så tänk dig för innan du gör det! En bra idé är att plocka hem alla tankar med knappen ovanför innan du far fram med yxan.</p>
</div>
{/block}