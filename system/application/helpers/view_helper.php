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

	function Dwoo_Plugin_remove_tags( Dwoo $dwoo, $content ) {
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
		
		function Dwoo_Plugin_nicedate( Dwoo $dwoo, $timestamp) {
			$CI =& get_instance();
			return $CI->util->nicedate($timestamp);
		}
		
		function Dwoo_Plugin_shortdate( Dwoo $dwoo, $timestamp) {
			$CI =& get_instance();
			return $CI->util->shortdate($timestamp);
		}
		
		function Dwoo_Plugin_truncate(Dwoo $dwoo, $value, $length=80, $etc='...', $break=false, $middle=false)
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