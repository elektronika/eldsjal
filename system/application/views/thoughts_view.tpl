{extends "thoughts.tpl"}

{block "body"}
<h2 class="title">{$thought->title} <span>{$thought->created|fuzzytime}</span></h2>
{bubble $thought}
{/block}