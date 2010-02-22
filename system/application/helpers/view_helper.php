<?php
function Dwoo_Plugin_rq( Dwoo $dwoo, $content ) {
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
		
		function Dwoo_Plugin_fuzzytime( Dwoo $dwoo, $timestamp, $prefix = NULL, $suffix = NULL, $hoverDateFormat = 'Y-m-d H:i' ) {
			$CI =& get_instance();
			return $CI->util->fuzzytime($timestamp, $prefix, $suffix);
		}
		
		function fuzzytime( $timestamp, $prefix = NULL, $suffix = NULL, $hoverDateFormat = 'Y-m-d H:i' ) {
			return get_instance()->util->fuzzytime($timestamp, $prefix, $suffix);
		}
		
		function Dwoo_Plugin_nicedate( Dwoo $dwoo, $timestamp) {
			$CI =& get_instance();
			return $CI->util->nicedate($timestamp);
		}
		
		function Dwoo_Plugin_shortdate( Dwoo $dwoo, $timestamp) {
			$CI =& get_instance();
			return $CI->util->shortdate($timestamp);
		}
		
		function truncate( $value, $length=80, $etc='...', $break=false, $middle=false)
		{
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
		
		function Dwoo_plugin_alertcounter( Dwoo $dwoo ) {
			$CI =& get_instance();
			$alert_count = $CI->models->alert->total_count();
			return ($alert_count > 0 ? '('.$alert_count.')' : '');
		}
		
		function Dwoo_plugin_usersetting( Dwoo $dwoo, $key, $default ) {
			$CI =& get_instance();
			return $CI->session->setting($key, $default);
		}
		
		function Dwoo_plugin_slugify( Dwoo $dwoo, $string ) {
			$CI =& get_instance();
			return $CI->util->slugify($string);
		}
		
		function Dwoo_plugin_titlify( Dwoo $dwoo, $title ) {
			$CI =& get_instance();
			return $CI->util->titlify($title);
		}
		
		function Dwoo_plugin_age( Dwoo $dwoo, $timestamp ) {
			$CI =& get_instance();
			return $CI->util->fuzzyage($timestamp);
		}
		
		function Dwoo_Plugin_escape(Dwoo $dwoo, $value='', $format='html', $charset=null)
		{
			if ($charset === null) {
				$charset = $dwoo->getCharset();
			}

			switch($format)
			{

			case 'html':
				return htmlspecialchars((string) $value, ENT_QUOTES, $charset);
			case 'htmlall':
				return htmlentities((string) $value, ENT_QUOTES, $charset);
			case 'url':
				return rawurlencode((string) $value);
			case 'urlpathinfo':
				return str_replace('%2F', '/', rawurlencode((string) $value));
			case 'quotes':
				return preg_replace("#(?<!\\\\)'#", "\\'", (string) $value);
			case 'hex':
				$out = '';
				$cnt = strlen((string) $value);
				for ($i=0; $i < $cnt; $i++) {
					$out .= '%' . bin2hex((string) $value[$i]);
				}
				return $out;
			case 'hexentity':
				$out = '';
				$cnt = strlen((string) $value);
				for ($i=0; $i < $cnt; $i++)
					$out .= '&#x' . bin2hex((string) $value[$i]) . ';';
				return $out;
			case 'javascript':
				return strtr((string) $value, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));
			case 'mail':
				return str_replace(array('@', '.'), array('&nbsp;(AT)&nbsp;', '&nbsp;(DOT)&nbsp;'), (string) $value);
			default:
				return $dwoo->triggerError('Escape\'s format argument must be one of : html, htmlall, url, urlpathinfo, hex, hexentity, javascript or mail, "'.$format.'" given.', E_USER_WARNING);

			}
		}

	function Dwoo_plugin_natural_implode(Dwoo $dwoo, $array, $and = 'and') {
		$count = count($array);
		if($count == 1)
			return current($array);
		elseif($count > 1) {
			$last = array_pop($array);
			return implode(', ', $array).' '.$and.' '.$last;
		}
	
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
	// $slug = isset($user->slug) ? $user->slug : slugify($user->username);
	$slug = $user->userid;
	return '<a href="/userPresentation.php?userid='.$slug.'" class="user u'.$user->userid.'" title="'.$user->username.'">'.$user->username.'</a>';
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

function userimage($user) {
	return "<img class='userimage' src='/uploads/userImages/tn_{$user->userid}.jpg' alt='{$user->username}'/>";
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
				<?php echo fuzzytime($post->created); ?> <?php echo actions($post->actions, TRUE); ?>
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
		foreach($links as $link)
			$out .= "<li><a href='{$link['href']}'>{$link['title']}</a></li>";
		$out .= '</ul>';
		return $out;
	}
}