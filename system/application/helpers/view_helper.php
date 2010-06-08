<?php
	// Dom två följande funktionerna är stulna från FluxBB, http://fluxbb.org

	//
	// Make hyperlinks clickable
	//
	 function do_clickable($text)
	{
		$text = ' '.$text;

		$text = preg_replace('#([\s\(\)])(https?|ftp|news){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2://$3\')', $text);
		$text = preg_replace('#([\s\(\)])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2.$3\', \'$2.$3\')', $text);

		return substr($text, 1);
	}

	//
	// Truncate URL if longer than 55 characters (add http:// or ftp:// if missing)
	//
	 function handle_url_tag($url, $link = '')
	{
		$full_url = str_replace(array(' ', '\'', '`', '"'), array('%20', '', '', ''), $url);
		if (strpos($url, 'www.') === 0)			// If it starts with www, we add http://
			$full_url = 'http://'.$full_url;
		else if (strpos($url, 'ftp.') === 0)	// Else if it starts with ftp, we add ftp://
			$full_url = 'ftp://'.$full_url;
		else if (!preg_match('#^([a-z0-9]{3,6})://#', $url, $bah)) 	// Else if it doesn't start with abcdef://, we add http://
			$full_url = 'http://'.$full_url;

		// Ok, not very pretty :-)
		$link = ($link == '' || $link == $url) ? ((strlen($url) > 55) ? substr($url, 0 , 39).' &hellip; '.substr($url, -10) : $url) : stripslashes($link);

		return '<a href="'.$full_url.'">'.$link.'</a>';
	}

	function remove_tags( $content ) {
			if( $content != "" ) {
				$content = str_replace( "&#59;", ";", $content );
				$content = str_replace( "&#44;", ",", $content );
				$content = str_replace( "&#39;", "'", $content );
				$content = str_replace( "&#34;", "\"", $content );
				$content = str_replace( "&lt;", "<", $content );
				$content = str_replace( "&gt;", ">", $content );
				$content = str_replace( "\r\n", " ", $content );
				$content = str_replace( "[br]", " ", $content );
				$content = str_replace( "[b]", " ", $content );
				$content = str_replace( "[/b]", " ", $content );
				$content = str_replace( "]", ">", $content );
				$content = str_replace( "[a ", "<a ", $content );
				$content = str_replace( "[/a>", "</a>", $content );
				$content = str_replace( "[3", "&lt;3", $content );
				$content = str_replace( ">.[", "&gt;.&lt;", $content );
			}

			return $content;
		}
		
		function fuzzytime( $timestamp, $prefix = NULL, $suffix = NULL, $hoverDateFormat = 'Y-m-d H:i' ) {
			return get_instance()->util->fuzzytime($timestamp, $prefix, $suffix);
		}
		
		function truncate( $value, $length=80, $etc='...', $break=false, $middle=false) {
			if ($length == 0) {
				return '';
			}

			$value = (string) $value;
			$etc = (string) $etc;
			$length = (int) $length;

			if (strlen($value) < $length) {
				return $value;
			}

			$length = max($length - strlen($etc), 0);
			if ($break === false && $middle === false) {
				$value = preg_replace('#\s+(\S*)?$#', '', substr($value, 0, $length+1));
			}
			if ($middle === false) {
				return substr($value, 0, $length) . $etc;
			}
			return substr($value, 0, ceil($length/2)) . $etc . substr($value, -floor($length/2));
		}

function slugify( $string ) {
	return get_instance()->util->slugify($string);
}
	
function actions($actions = NULL, $icons_only = FALSE) {
	if( ! is_null($actions) && is_array($actions)) {
		$icon_class = $icons_only ? ' icons-only' : '';
		$out = '<div class="actions'.$icon_class.'">';
		foreach($actions as $action)
			$out .= "<a class='action action-{$action['class']}' title='{$action['title']}' href='{$action['href']}'>&nbsp;<span>{$action['title']}</span></a>";
		$out .= '</div>';
		return $out;
	}
}

function userlink($user) {
	static $ping_timeout = NULL;

	if(isset($user->deleted) && $user->deleted)
		return "<span class='user deleted'>{$user->username}</span>";
	else {
		if(isset($user->ping)) {
			if(is_null($ping_timeout))
				$ping_timeout = get_instance()->settings->get('online_timeout');
			$online = isset($user->ping) ? (time() - $user->ping < $ping_timeout ? ' online' : ' offline') : '';
		} else
			$online = '';
		return '<a href="/user/'.$user->userid.'" class="user u'.$user->userid.$online.'" title="'.$user->username.'">'.$user->username.'</a>';		
	}
}

function pager($pager) {
	return '<div class="pager">'.$pager.'</div>';
}

function pagespan_link($page, $href, $items_per_page) {
	$offset = $page * $items_per_page;
	$page_number = $page + 1;
	return "<a href='{$href}/page:{$offset}'>{$page_number}</a> ";
}

function pagespan($items, $href, $items_per_page) {
	if($items > $items_per_page) {
		$out = '<span class="pagespan">[ ';
		if($items < $items_per_page * 6)
			for($i = 0; $i < $items / $items_per_page; $i++)
				$out .= pagespan_link($i, $href, $items_per_page);
		else
			foreach(array(0, 1, ' ... ', floor(($items / $items_per_page) - 1), floor($items / $items_per_page)) as $page)
				$out .= is_numeric($page) ? pagespan_link($page, $href, $items_per_page) : $page;
		$out .= ' ]</span>';
		return $out;
	}
}

function shortdate($timestamp) {
	return get_instance()->util->shortdate($timestamp);
}

function userimage($user, $square = FALSE) {
	$img_url = (isset($user->hasimage) && ! $user->hasimage) ? '/images/ingetfoto.gif' : "/uploads/userImages/tn_{$user->userid}.jpg";
	if($square)
		return "<span class='userimage' style='background-image: url(\n{$img_url}\n)' title='{$user->username}'>&nbsp;</span>";
	else
		return "<img class='userimage' src={$img_url} alt='{$user->username}'/>";
}

function post($post) { 
	foreach(array('id', 'actions') as $element)
		isset_fallback($post, $element, 0);
	?>
	<div class="post"><?php if($post->id): ?><a name="post-<?php echo $post->id; ?>"></a><?php endif; ?>
		<div class="left">
			<?php echo userimage($post); ?>
			<?php echo userlink($post); ?>		
		</div>
		<div class="right">
			<div class="body">
				<?php echo rq($post->body); ?>
			</div>
			<div class="meta">
				<?php echo fuzzytime($post->created); ?> <?php echo actions($post->actions); ?>
			</div>
		</div>
		<span class="clear">&nbsp;</span>
	</div><?php
}

function rq( $content ) {
	if( $content != "" ) {
		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&amp;#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&amp;#44;", ",", $content );			
		$content = str_replace( "&#39;", "'", $content );
		$content = str_replace( "&amp;#39;", "'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&amp;#34;", "\"", $content );
		// $content = str_replace( "&lt;", "<", $content );
		// $content = str_replace( "&gt;", ">", $content );
		$content = str_replace( "\r\n", "<br/>", $content );
		$content = str_replace( "\n", "<br/>", $content );
		$content = str_replace( "[br]", "<br/>", $content );
		$content = str_replace( "[b]", "<b>", $content );
		$content = str_replace( "[/b]", "</b>", $content );
		$content = str_replace( "]", ">", $content );
		$content = str_replace( "[a ", "<a ", $content );
		$content = str_replace( "[/a>", "</a>", $content );
		$content = str_replace( "[3", "&lt;3", $content );
		$content = str_replace( ">.[", "&gt;.&lt;", $content );
		$content = do_clickable($content);
	}

	return $content;
}

function nth($what = 2, $loop = 'default') {
	static $loops = array();
	if( ! isset($loops[$loop]))
		$loops[$loop] = 0;
	else
		$loops[$loop]++;
	return ($loops[$loop] % $what == 0);
}

function rqJS( $content ) {
	if( $content != "" ) {
		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "\\'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );
		$content = str_replace( "\r\n", "<br>", $content );
		$content = str_replace( "[br]", "<br>", $content );
		$content = str_replace( "[b]", "<b>", $content );
		$content = str_replace( "[/b]", "</b>", $content );
		$content = str_replace( "\"", "", $content );
	}
	return $content;
}

function timeSince( $timestamp, $suffix = ' sedan', $hover = TRUE, $hoverDateFormat = 'Y-m-d H:i' ) {
	$timeDiff = time() - $timestamp;
	
	if( $timeDiff < 60 ) {
		$out = 'alldeles nyss';
		$suffix = $suffix == ' sedan' ? '' : $suffix;
	}
	elseif( $timeDiff < 7 * 60 )
		$out = 'n&aring;gra minuter';
	elseif( $timeDiff < 17 * 60 )
		$out = 'typ en kvart';
	elseif( $timeDiff < 27 * 60 )
		$out = 'n&auml;stan en halvtimme';
	elseif( $timeDiff < 40 * 60 )
		$out = 'lite mer &auml;n en halvtimme';
	elseif( $timeDiff < 55 * 60 )
		$out = 'n&auml;stan en timme';
	elseif( $timeDiff < 90 * 60 )
		$out = 'typ en timme';
	elseif( $timeDiff < 22 * 3600 )
		$out = round($timeDiff / 3600).' timmar';
	elseif( $timeDiff < 30 * 3600 )
		$out = 'ungefär en dag';
	elseif( $timeDiff < 6 * 24 * 3600 )
		$out = round($timeDiff / (24 * 3600)).' dagar';
	elseif( $timeDiff < 29 * 24 * 3600 )
		$out = round($timeDiff / (7 * 24 * 3600)).' veckor';
	elseif( $timeDiff < 360 * 24 * 3600 )
		$out = round($timeDiff / (30 * 24 * 3600)).' m&aring;nader';
	else
		$out = round($timeDiff / (365 * 24 * 3600)).' &aring;r';
	
	$out .= $suffix;
	
	if($hover)
		$out = '<span class="date" title="'.date($hoverDateFormat, $timestamp).'">'.$out.'</span>';
	
	return $out;
}

function input($type, $name, $label = '', $value = '', $error = '') {
	$prefix = $suffix = '';
	
	if(empty($error) && function_exists('form_error'))
		$error = form_error($name);
	
	if(function_exists('set_value'))
		$value = set_value($name, $value);
	
	if( ! empty($label)) {
		if($type == 'checkbox') {
			$prefix = "<label id='form-label-{$name}' for='form-item-{$name}'>{$label}";
			$suffix = '</label>';
		} else {
			$prefix = "<label id='form-label-{$name}' for='form-item-{$name}'>{$label}</label>";
		}
	}
	
	$classes = 'form-item-'.$type;
	
	if( ! empty($error)) {
		$suffix .= "<span class='form-error-description'>{$error}</span>";
		$classes .= ' form-item-error';
	}
	
	return "{$prefix}<input type='{$type}' name='{$name}' class='{$classes}' value='{$value}' id='form-item-{$name}'/>{$suffix}";
}

function textarea($name, $label = '', $value = '', $error = '') {
	$prefix = $suffix = '';
	
	if(empty($error) && function_exists('form_error'))
		$error = form_error($name);
	
	if(function_exists('set_value'))
		$value = set_value($name, $value);
	
	if( ! empty($label))
		$prefix = "<label id='form-label-{$name}' for='form-item-{$name}'>{$label}</label>";
	
	$classes = 'form-item-textarea';
	
	if( ! empty($error)) {
		$suffix .= "<span class='form-error-description'>{$error}</span>";
		$classes .= ' form-item-error';
	}
	
	return "{$prefix}<textarea name='{$name}' class='{$classes}' id='form-item-{$name}'>{$value}</textarea>{$suffix}";
}

function submit($value = 'Hit it!') {
	return input('submit', 'submit', '', $value);
}

function rqForm( $content ) {
	if( $content != "" ) {
		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );
		$content = str_replace( "[br]", "\r\n", $content );
	}
	return $content;
}

function isset_fallback(&$object, $element, $fallback) {
	if( ! isset($object->$element))
		$object->$element = $fallback;
}

function teaser($data, $truncate = TRUE) { 
	foreach(array('updated', 'creator', 'created', 'subtitle', 'userid') as $element)
		isset_fallback($data, $element, 0);
	isset_fallback($data, 'actions', array());
	?>
	<div class="teaser">
	<?php if(isset($data->title)): ?>
		<h3 class="title"><?php if($data->href): ?><a href="<?php echo $data->href; ?>"><?php echo $data->title; ?></a><?php else: ?><?php echo $data->title; ?><?php endif; ?>
			<?php if($data->userid || $data->created || $data->poster || $data->updated): ?>
				<span>
					<?php if($data->created >= $data->updated): ?> skapades <?php echo fuzzytime($data->created); ?><?php if($data->creator): ?> av <?php echo userlink($data->creator); ?><?php endif; ?>
					<?php elseif($data->updated > $data->created): ?> uppdaterades <?php echo fuzzytime($data->updated); ?> <?php if($data->updater): ?> av <?php echo userlink($data->updater); ?><?php endif; ?><?php endif; ?>
					<?php if($data->userid): ?> av <?php echo userlink($data); ?><?php endif; ?>
				</span>
			<?php endif; ?>
		</h3>
		<?php if($data->subtitle): ?>
			<h4 class="subtitle"><?php echo $data->subtitle; ?></h4>
		<?php endif; ?>
		<?php if($data->body): ?>
			<div class="teaser-text body">
			<?php if($truncate): ?>
				<?php echo truncate(remove_tags($data->body), 100); ?>
			<?php else: ?>
				<?php echo rq($data->body); ?>
			<?php endif; ?>
			<?php echo actions($data->actions); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php }

function sublinks(Array $links = array()) {
	if( ! empty($links)) {
		$out = '<ul class="sublinks">';
		foreach($links as $link) {
			$link['title'] = str_replace(' ', '&nbsp;', $link['title']);
			$out .= "<li> <a href='{$link['href']}'>{$link['title']}</a> </li>";
		}
		$out .= '</ul>';
		return $out;
	}
}

function datepicker($name = 'date', $years_ahead = 3, $years_back = 3, $value = NULL) {
	if(is_null($value) || $value == 0)
		$value = time();
	
	$year = date('Y', $value);
	$month = date('m', $value);
	$day = date('d', $value);
		
	$years = array_combine(range(date('Y') - $years_back, date('Y') + $years_ahead), range(date('Y') - $years_back, date('Y') + $years_ahead));
	$months = array_combine(range(1, 12), range(1, 12));
	$days = array_combine(range(1, 31), range(1, 31));
	
	return form_dropdown($name.'[year]', $years, $year).'/'.form_dropdown($name.'[month]', $months, $month).'/'.form_dropdown($name.'[day]', $days, $day);
}

function datepicker_timestamp($name) {
	return mktime(0, 0, 0, (int) $_POST[$name]['month'], (int) $_POST[$name]['day'], (int) $_POST[$name]['year']);
}

function datespan($start, $end) {
	if($end < $start)
		return date('Y/m/d', $start);
		
	$start_year = date('Y', $start);
	$end_year = date('Y', $end);
	$start_month = date('n', $start);
	$end_month = date('n', $end);
	$start_day = date('j', $start);
	$end_day = date('j', $end);

	if($start_year == $end_year) {
		if($start_month == $end_month) {
			if($start_day == $end_day) {
				return "{$start_day}/{$start_month}/{$start_year}";
			} else {
				return "{$start_day} - {$end_day}/{$end_month} {$start_year}";
			}
		} else {
			return "{$start_day}/{$start_month} - {$end_day}/{$end_month} {$start_year}";
		}
	} else {
		return "{$start_day}/{$start_month}/{$start_year} - {$end_day}/{$end_month}/{$end_year}";
	}
}

function calendar($events, $month, $year) {
	$timestamp_start = mktime(0, 0, 0, $month, 1, $year);
	$days_in_month = date('t', $timestamp_start);
	$days_to_skip = date('N', $timestamp_start);
	$days_to_skip = $days_to_skip - 1;
	$first_week = date('W', $timestamp_start);
	$first_week = $first_week - 1;

	$number_of_cells = $days_in_month + $days_to_skip;
	$number_of_rows_kinda = $number_of_cells / 7;
	$rows_in_calendar = ceil($number_of_rows_kinda);
	
	$day_of_month = 0; ?>
<table class="calendar">
<?php for($row = 1; $row <= $rows_in_calendar; $row++): ?>
	<tr>
		<td class="week">
			<?php if($month == 1) {
				$timestamp_start = mktime(0, 0, 0, $month, $day_of_month + 1, $year);
				$first_week = date('W', $timestamp_start);
				$first_week = $first_week - 1;
				} ?>
			<?php echo $first_week + $row; ?>
			</td>
		<?php if($row == 1): ?>
			<?php if($days_to_skip > 0): ?>
				<?php for($j = 1; $j <= $days_to_skip; $j++): ?>
					<td class="day empty skip"> </td>
				<?php endfor; ?>
			<?php endif; ?>
			<?php for($j = $days_to_skip; $j <= 6; $j++): ?>
				<?php $day_of_month++; ?>
				<?php $day_class = isset($events[$day_of_month]) ? ' has-events' : ' no-events'; ?>
				<td class="day<?php echo $day_class; ?>"><a href="/calendar/browse/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day_of_month; ?>"><?php echo $day_of_month; ?></a>
					<ul class="events flat">
					<?php if(isset($events[$day_of_month])) foreach($events[$day_of_month] as  $event): ?>
					<li><a href="<?php echo $event->href; ?>"><?php echo $event->title; ?></a></li>
					<?php endforeach; ?>
					</ul>
				</td>
			<?php endfor; ?>
		<?php else: ?>
			<?php for($j = 1; $j <= 7; $j++): ?>
				<?php $day_of_month++; ?>
				<?php if($day_of_month > $days_in_month): ?>
					<td class="day empty skip"> </td>
				<?php else: ?>
				<?php $day_class = isset($events[$day_of_month]) ? ' has-events' : ' no-events'; ?>
				<td class="day<?php echo $day_class; ?>"><a href="/calendar/browse/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day_of_month; ?>"><?php echo $day_of_month; ?></a>
					<ul class="events flat">
						<?php if(isset($events[$day_of_month])) foreach($events[$day_of_month] as $event): ?>
						<li><a href="<?php echo $event->href; ?>"><?php echo $event->title; ?></a></li>
						<?php endforeach; ?>
					</ul>
					</td>
				<?php endif; ?>
			<?php endfor; ?>
		<?php endif; ?>
	</tr>
<?php endfor; ?>
</table><?php
}

function datepager($prefix, $year, $month = NULL, $day = NULL) { ?>
	<div class="datepager pager">
	<?php if( ! is_null($day)) { ?>
		<a href="<?php echo $prefix.date('Y/m/d',mktime(0,0,0,$month, $day - 1, $year)); ?>" class="previous"><?php echo strftime('%e %B',mktime(0,0,0,$month, $day - 1, $year)); ?> &laquo;</a> 
		<span class="current"><?php echo ucfirst(strftime('%A %e',mktime(0,0,0,$month, $day, $year))); ?> <a href="<?php echo $prefix.$year.'/'.$month; ?>"><?php echo strftime('%B',mktime(0,0,0,$month, $day, $year)); ?></a> <a href="<?php echo $prefix.$year; ?>"><?php echo $year; ?></a></span> 
		<a href="<?php echo $prefix.date('Y/m/d',mktime(0,0,0,$month, $day + 1, $year)); ?>" class="previous">&raquo; <?php echo strftime('%e %B',mktime(0,0,0,$month, $day + 1, $year)); ?></a>
	<?php } elseif( ! is_null($month)) { ?>
			<a href="<?php echo $prefix.date('Y/m',mktime(0,0,0,$month - 1, 1, $year)); ?>" class="previous"><?php echo strftime('%B',mktime(0,0,0,$month - 1)); ?> &laquo;</a> 
			<span class="current"><?php echo strftime('%B',mktime(0,0,0,$month)); ?> <a href="<?php echo $prefix.$year; ?>"><?php echo $year; ?></a></span> 
			<a href="<?php echo $prefix.date('Y/m',mktime(0,0,0,$month + 1, 1, $year)); ?>" class="previous">&raquo; <?php echo strftime('%B',mktime(0,0,0,$month + 1)); ?></a>
	<?php } else { ?>
			<a href="<?php echo $prefix.($year - 1); ?>" class="previous"><?php echo $year - 1; ?> &laquo;</a> <span class="current"><?php echo $year; ?></span> <a href="<?php echo $prefix.($year + 1); ?>" class="previous">&raquo; <?php echo $year + 1; ?></a>
		<?php } ?>
	</div>
<?php }

function userlist_item($user) { ?>
<div class="userlist">
	<?php echo userimage($user, TRUE).userlink($user); ?>
	<?php if(isset($user->birthday)) echo ' - '.age($user->birthday).' år'; ?>
	<?php if(isset($user->location)) echo ' - '.$user->location; ?>
	<?php if(isset($user->online)) echo $user->online ? ' - <span class="online">Online</span>' : ''; ?>
	<?php if(isset($user->body)) echo '<div>'.$user->body.'</div>'; ?>
	<span class="clear">&nbsp;</span></div>
<?php }

function messages(Array $messages) { 
	if( ! empty($messages)): ?>
	<div id="messages">
		<?php foreach($messages as $type => $message): if( ! empty($message)): ?>
			<div class="<?php echo $type; ?>"><?php echo $message; ?></div>
		<?php endif; endforeach; ?>
	</div>
<?php endif; }

function breadcrumbs(Array $breadcrumbs) { ?>
	<span class="breadcrumb">
		<?php foreach($breadcrumbs as $crumb): ?>
			<a href="<?php echo $crumb['href']; ?>"><?php echo $crumb['title']; ?></a> &raquo; 
		<?php endforeach; ?>
	</span>
<?php }

function age($timestamp) {
	$diff = time( ) - $timestamp;
	$age = $diff / ( 3600 * 24 );
	$age = floor( round($age / 365, 1) * 10 ) / 10;
	return $age;
}

function natural_implode($array, $and = 'and') {
	$count = count($array);
	if($count == 1)
		return current($array);
	elseif($count > 1) {
		$last = array_pop($array);
		return implode(', ', $array).' '.$and.' '.$last;
	}
}

function thumbnail($image) {
	return "<a href='/gallery/view/{$image->imageId}' class='thumbnail image-{$image->imageId}' style='background-image: url(\"/uploads/galleryImages/tn_{$image->imageId}.jpg\")' title='{$image->imageName}'> </a>";
}

function tagcloud(Array $tags, $prefix) {
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
	<?php foreach($tags as $tag): ?>
		<a class="tag tag-level-<?php echo $tag->level; ?>" href="<?php echo $prefix.$tag->slug; ?>"><?php echo $tag->tag; ?> (<?php echo $tag->size; ?>)</a>
	<?php endforeach; ?>
	</div>
<?php }

function widget($widget) { 
	ob_start();
	widget::run($widget);
	$result = trim(ob_get_clean());
	if( ! empty($result)) { ?>
	<div class="widget" id="widget-<?php echo $widget; ?>">
		<?php echo $result; ?>
	</div>
<?php } 
}

function widgets($region_name) {
	$widget_names = get_instance()->widgets->get($region_name);
	if( ! empty($widget_names)) {
		echo "<div class='region' id='region-{$region_name}'>";
		foreach($widget_names as $name)
			widget($name);
		echo "</div>";
	}
}

function has_widgets($region_name) {
	return count(get_instance()->widgets->get($region_name)) > 0;
}

function wisdom_item($item) { ?>
	<div class="wisdom"><?php echo rq($item->body); ?><br/><?php echo userlink($item); ?> - <?php echo date('Y-m-d', $item->created); ?> - <a href="/admin/wisdom/<?php echo $item->id; ?>">Redigera</a></div>
<?php }

function guestbook_form($user_id, $prefix = NULL) {
	return form_open('/guestbook/view/'.$user_id, NULL, array('prefix' => $prefix)).textarea('body', 'Gästboksmeddelande').submit('Pytsa in\'ett i gästboka!').form_close();
}