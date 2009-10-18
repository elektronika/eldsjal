<ul id="dev">
{foreach name=l from=$dev.logs item=log key=name}
<li class="container">
<h2>{$name} - {$log|@count}</h2>
   <ul class='log'>
     {foreach name=l from=$log item=item}
     	<li class="item"><pre>
{if $item|is_array}
{foreach name=logparts from=$item key=partkey item=part}
{if ($partkey == 'time' && $part > 0.005) || $partkey == 'error'}[{$partkey}] => <span class='warning'>{$part|escape:html}</span>
{elseif $partkey =='time' && $part<0.0005}[{$partkey}] => <span class='good'>{$part|escape:html}</span>
{else}[{$partkey}] => {$part|escape:html}
{/if}
{/foreach}{else}
{$item}
{/if}
</pre></li>
     {/foreach}
   </ul>
</li>
{/foreach}
{foreach name=l from=$dev.globals item=global key=name}
<li class="container">
<h2>{$name}</h2>
   <ul class='log'>
     	<li class="item"><pre>{$global|escape:html}</pre></li>
   </ul>
</li>
{/foreach}
<li>{time|round:3} sekunder</li>
</ul>