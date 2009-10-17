{template printr data}
<pre class="printr">{$data|print_r}</pre>
{/template}

{template tagcloud tags prefix}
<?php
$tag_max = $tag_min = 0;

foreach($tags as $tag) {
	if($tag->size > $tag_max)
		$tag_max = $tag->size;
	if($tag->size < $tag_min)
		$tag_min = $tag->size;
}

$tag_levels = 5;
$tag_count = count($tags);
$size_range = log($tag_max - $tag_min);
foreach($tags as &$tag) {
	if($size_range > 0) {
		$size_diff = $tag->size - $tag_min;
		$tag->level = floor($tag_levels*(log($size_diff) / $size_range));
	} else {
		$tag->level = 2;
	}
} ?>
<div class="tagcloud">
{foreach $tags tag}
	<a class="tag tag-level-{$tag->level}" href="{$prefix}{$tag->slug}">{$tag->tag} ({$tag->size})</a>
{/foreach}
</div>
{/template}

{template userlink user}<a href="/user/{if $user->slug}{$user->slug}{else}{$user->username|slugify}{/if}" class="user u{$user->userid}" title="{$user->username}">{$user->username}</a>{/template}

{template userimage user}
<img class="userimage" src="/uploads/userImages/tn_{$user->userid}.jpg" alt="{$user->username}"/>
{/template}

{template pager pager}
<div class="pager">{$pager}</div>
{/template}

{template actions actions iconsonly=1}
<div class="actions{if $iconsonly} icons-only{/if}">
{foreach $actions action}
	<a class="action action-{$action.class}" title="{$action.title}" href="{$action.href}">&nbsp;<span>{$action.title}</span></a>
{/foreach}
</div>
{/template}

{template bubble data}
<div class="bubble">{if $data->id}<a name="post-{$data->id}"></a>{/if}
	<div class="bubble-userdata">
		{userimage $data}
		{userlink $data}
	</div>
	<div class="bubble-content-wrap">
		<div class="bubble-content">
			{$data->body|escape|nl2br|rq}
		</div>
	</div>
	<div class="bubble-meta">
	{$data->created|fuzzytime} {actions $data->actions}
	</div>
	<span class="clear"> </span>
</div>
{/template}

{template teaser data truncate = TRUE}
<div class="teaser">
{if $data->title}
	<h3 class="title">{if $data->href}{a href=$data->href}{$data->title}{/a}{else}{$data->title}{/if}
		{if $data->userid OR $data->created OR $data->poster OR $data->updated}
			<span>
				{if $data->created gte $data->updated} skapades {$data->created|fuzzytime} {if $data->creator} av {userlink $data->creator}{/if}
				{elseif $data->updated gt $data->created} uppdaterades {$data->updated|fuzzytime} {if $data->updater} av {userlink $data->updater}{/if}{/if}
				{if $data->userid} av {userlink $data}{/if}
			</span>
		{/if}
	</h3>
	{if $data->subtitle}
		<h4 class="subtitle">{$data->subtitle}</h4>
	{/if}
	{if $data->body}
		<div class="teaser-text body">
		{if $truncate}
			{$data->body|remove_tags|truncate:120}
		{else}
			{$data->body|rq}
		{/if}
		{actions $data->actions}
		</div>
	{/if}
{/if}
</div>
{* printr $data *}
{/template}

{template thumbnail image}
<a href="/gallery/view/{$image->imageId}" class="thumbnail image-{$image->imageId}" style="background-image: url('/uploads/galleryImages/tn_{$image->imageId}.jpg')" title="{$image->imageName}"> </a>
{/template}

{template input type name label = "" value = "" error = ""}
{if $error eq "" AND function_exists('form_error')}{$error = form_error($name)}{/}
{if $value eq "" AND function_exists('set_value')}{$value = set_value($name)}{/}
{if $label neq ""}<label id="form-label-{$name}" for="form-item-{$name}">{$label}{if $type neq "checkbox"}</label>{/if}{/if}
<input type="{$type}" class="form-item-{$type}{if $error neq ""} form-item-error{/if}" name="{$name}" value="{$value}" id="form-item-{$name}"/>
{if $type eq "checkbox"}</label>{/if}
{if $error neq ""}<span class="form-error-description">{$error}</span>{/if}
{/template}

{template textarea name label = "" value = "" error = ""}
{if $error eq "" AND function_exists('form_error')}{$error = form_error($name)}{/}
{if $value eq "" AND function_exists('set_value')}{$value = set_value($name)}{/}
{if $label neq ""}<label id="form-label-{$name}" for="form-item-{$name}">{$label}</label>{/if}
<textarea name="{$name}"  class="form-item-textarea{if $error neq ""} form-item-error{/if}" id="form-item-{$name}">{$value}</textarea>
{if $error neq ""}<span class="form-error-description">{$error}</span>{/if}
{/template}

{template select name options default = "" label = "" error = ""}
{if $error eq "" AND function_exists('form_error')}{$error = form_error($name)}{/}
{if $value eq "" AND function_exists('set_value')}{$value = set_value($name)}{/}
{if $label neq ""}<label for="form-item-{$name}">{$label}</label>{/if}
{$extra = 'class="form-item-select" id="form-item-$name"'}
{form_dropdown($name, $options, $default, $extra)}
{if $error neq ""}<span class="form-error-description">{$error}</span>{/if}
{/template}

{template inputs fields data}
	{foreach $fields field}
		{input 'text' $field $field $data.$field}
	{/foreach}
{/template}

{template datepager prefix year month = NULL day = NULL}
<div class="datepager pager">
<?php if( ! is_null($day)) { ?>
	<a href="{$prefix}{date('Y/m/d',mktime(0,0,0,$month, $day - 1, $year))}" class="previous">{strftime('%e %B',mktime(0,0,0,$month, $day - 1, $year))} &laquo;</a> 
	<span class="current">{ucfirst(strftime('%A %e',mktime(0,0,0,$month, $day, $year)))} <a href="{$prefix}{$year}/{$month}">{strftime('%B',mktime(0,0,0,$month, $day, $year))}</a> <a href="{$prefix}{$year}">{$year}</a></span> 
	<a href="{$prefix}{date('Y/m/d',mktime(0,0,0,$month, $day + 1, $year))}" class="previous">&raquo; {strftime('%e %B',mktime(0,0,0,$month, $day + 1, $year))}</a>
<?php } elseif( ! is_null($month)) { ?>
		<a href="{$prefix}{date('Y/m',mktime(0,0,0,$month - 1))}" class="previous">{strftime('%B',mktime(0,0,0,$month - 1))} &laquo;</a> 
		<span class="current">{strftime('%B',mktime(0,0,0,$month))} <a href="{$prefix}{$year}">{$year}</a></span> 
		<a href="{$prefix}{date('Y/m',mktime(0,0,0,$month + 1))}" class="previous">&raquo; {strftime('%B',mktime(0,0,0,$month + 1))}</a>
<?php } else { ?>
		<a href="{$prefix}{$year - 1}" class="previous">{$year - 1} &laquo;</a> <span class="current">{$year}</span> <a href="{$prefix}{$year + 1}" class="previous">&raquo; {$year + 1}</a>
	<?php } ?>
</div>
{/template}

{template calendar events month year}
{$timestamp_start = mktime(0, 0, 0, $month, 1, $year)}
{$days_in_month = date('t', $timestamp_start)}
{$days_to_skip = date('N', $timestamp_start)}
{$days_to_skip = $days_to_skip - 1}
{$first_week = date('W', $timestamp_start)}
{$first_week = $first_week - 1}

{$number_of_cells = $days_in_month + $days_to_skip}
{$number_of_rows_kinda = $number_of_cells / 7}
{$rows_in_calendar = ceil($number_of_rows_kinda)}
{*
days_in_month = {$days_in_month}<br/>
days_to_skip = {$days_to_skip}<br/>
first_week = {$first_week}<br/>
number_of_rows_kinda = {$number_of_rows_kinda}<br/>
rows_in_calendar = {$rows_in_calendar}<br/>
*}

{counter name="day_of_month" assign="day_of_month" start = 0}
<table class="calendar">
{for row 1 $rows_in_calendar}
	<tr>
		<td class="week">
			{if $month eq 1}
				{$timestamp_start = mktime(0, 0, 0, $month, $day_of_month + 1, $year)}
				{$first_week = date('W', $timestamp_start)}
				{$first_week = $first_week - 1}
			{/if}
			{$first_week + $row}
			</td>
		{if $row eq 1}
			{if $days_to_skip gt 0}
			{for skip_days 1 $days_to_skip}
				<td class="day empty skip"> </td>
			{/for}
			{/if}
			{for days $days_to_skip 6}
				{counter name="day_of_month" assign="day_of_month"}
				{if $events.$day_of_month}
					{$day_class = ' has-events'}
				{else}
					{$day_class = ' no-events'}
				{/if}
				<td class="day{$day_class}"><a href="/calendar/browse/{$year}/{$month}/{$day_of_month}">{$day_of_month}</a><br/>
					<ul class="events">
					{foreach $events.$day_of_month event}
					<li><a href="/calendar/view/{$event->eventId}">{$event->title}</a></li>
					{/foreach}
					</ul>
				</td>
			{/for}
		{else}
			{for days 1 7}
				{counter name="day_of_month" assign="day_of_month"}
				{if $day_of_month gt $days_in_month}
					<td class="day empty skip"> </td>
				{else}
				{if $events.$day_of_month}
					{$day_class = ' has-events'}
				{else}
					{$day_class = ' no-events'}
				{/if}
				<td class="day{$day_class}"><a href="/calendar/browse/{$year}/{$month}/{$day_of_month}">{$day_of_month}</a><br/>
					<ul class="events">
						{foreach $events.$day_of_month event}
						<li><a href="/calendar/view/{$event->eventId}">{$event->title}</a></li>
						{/foreach}
					</ul>
					</td>
				{/if}
			{/for}
		{/if}
		{*<td> rad: {$row}</td>*}
	</tr>
{/for}
</table>

{/template}

{template event_teaser data truncate = TRUE}
<div class="teaser event">
{if $data->title}
	<h3 class="title">{if $data->href}{a href=$data->href}{$data->title}{/a}{else}{$data->title}{/if}
			<span>
				{if $data->created} {$data->date|fuzzytime}{/if}
			</span>
	</h3>
		<h4 class="subtitle"><span class="event-date">{$data->date|nicedate} i {$data->locationName}</span> | Upplagd av {userlink $data} {$data->created|fuzzytime}</h4>
	{if $data->body}
		<div class="teaser-text">
		{if $truncate}
			{$data->body|remove_tags|truncate:120}
		{else}
			{$data->body|escape|rq}
		{/if}
		{actions $data->actions}
		</div>
	{/if}
{/if}
</div>
{/template}

{template signup eventid}
<form class="signup" method="post" action="/calendar/signup/{$eventid}">
	<input type="submit" value="Sign me up Scotty!"/>
</form>
{/template}

{template signoff eventid}
<form class="signoff" method="post" action="/calendar/signoff/{$eventid}">
	<input type="submit" value="Njae, jag ångrade mig!"/>
</form>
{/template}

{template messages messages}
<div class="container_16" id="messages">
	{foreach $messages item=message key=type}
		<div class="grid_16 {$type}">{$message}</div>
	{/foreach}
</div>
{/template}

{template userbar user}
<div class="userbar">
	<div class="grid_2 alpha">
		{userimage $user}
	</div>
	<div class="grid_14 omega">
		<h2>{$user->first_name} "<span>{userlink $user}</span>" {$user->last_name}</h2>
		<h3>{$user->birthday|age} år, {$user->inhabitance}, {$user->location}{if $user->online}, <span class="online">Online</span>{/if}</h3>
		<h4>Gick med {$user->register_date|fuzzytime}, loggade senast in {$user->lastLogin|fuzzytime}</h4>
		{actions $user->actions 0}
	</div>
	<div class="clear"> </div>
</div>
{/template}