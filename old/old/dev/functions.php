<?php
class MysqlConn {

	private $conn;
	public $type = 'mysql';

	public function __construct( ) {
		$this->conn = mysql_pconnect( 'localhost', 'root', 'kebabhatt' );
		// print phpversion();
		// mysql_set_charset('utf8');
		mysql_select_db( 'eldsjal_new', $this->conn );
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $this->conn);
	}

	public function execute( $sql ) {
		// print '<br/>'.$sql.'<br/>';
		$sql = str_replace('getdate()', 'now()', $sql);
		$sql = str_replace('[date]', 'date', $sql);
		$result = mysql_query( $sql, $this->conn );
		if( mysql_errno($this->conn) > 0 ) {
			print 'MySQL error ('.mysql_errno($this->conn).') '.mysql_error($this->conn);
			return false;
		}
		else {
			if( $result === TRUE ) 
				return TRUE;
			elseif( $result !== FALSE ) {
				if( mysql_num_rows( $result ) > 0 ) {
					while( $result && $row = mysql_fetch_assoc( $result ) ) 
						$rows[] = array_change_key_case($row);
					if( count( $rows ) == 1 ) 
						$rows = current( $rows );
					return $rows;
				}
				else 
					return 0;
			}
			else 
				return false;
		}
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->conn);
	}
	

	public function close( ) {
		mysql_close( $this->conn );
	}
	
	public function insert_id() {
		return mysql_insert_id( $this->conn );
	}
}


function makePager( $url, $numberOfItems, $currentPage = 1, $itemsPerPage = 15 ) {
	$numberOfPages = ceil( $numberOfItems / $itemsPerPage );
	if( $numberOfPages > 1 ) {
		print "<table border=\"0\" width=\"100%\"><tr>";
		if( $currentPage > 1 ) 
			print "<td width=\"100\"><a href=\"".$url.( $currentPage - 1 )."\" class=\"a2\">&laquo; sidan innan</a></td>";
		else 
			print "<td width=\"100\">&nbsp;</td>";
		print "<td>".$currentPage." / ".$numberOfPages."</td>";
		if( $currentPage < $numberOfPages ) 
			print "<td width=\"100\"><a href=\"".$url.( $currentPage + 1 )."\" class=\"a2\">n&auml;sta sida &raquo;</a></td>";
		else 
			print "<td width=\"100\">&nbsp;</td>";
		print "</tr></table>";
	}
}

function paginate( $items, $currentPage = 1, $itemsPerPage = 15 ) {
	return array_slice( $items, (( $currentPage - 1 ) * $itemsPerPage ), $itemsPerPage );
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

function age($timestamp) {
	$diff = time( ) - $timestamp;
	$age = $diff / ( 3600 * 24 );
	$age = floor( round($age / 365, 1) * 10 ) / 10;
	return $age;
}

function __autoload( $class ) {
	$class = strtolower( $class );
	if( file_exists('classes/'.$class.'.class.php') )
		require_once('classes/'.$class.'.class.php');
	else
		require_once( 'lib/'.$class.'/'.$class.'.class.php' );
}


function skapaNuDatum( ) {
	extract( $GLOBALS );
	$Y = strftime( "%Y", time( ) );
	$M = strftime( "%m", time( ) );
	if( strlen( $M ) == 1 ) {
		$M = "0".$M;
	}
	$D = $day[time( )];
	if( strlen( $D ) == 1 ) {
		$D = "0".$D;
	}
	$function_ret = $Y."-".$M."-".$D;
	return $function_ret;
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


//Check and validate user input

function cq( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		//content = Server.HTMLEncode(content)

		$content = str_replace( "\r\n", "[br]", $content );
		$content = str_replace( "<br/>", "[br]", $content );
		$content = str_replace( "<b>", "[b]", $content );
		$content = str_replace( "</b>", "[/b]", $content );
		htmlspecialchars( substr( $content, 0, 1 ) );
		$content = str_replace( ";", "&#59;", $content );
		$content = str_replace( ",", "&#44;", $content );
		$content = str_replace( "'", "&#39;", $content );
		$content = str_replace( "\"", "&#34;", $content );
		$content = str_replace( "<", "[", $content );
		$content = str_replace( ">", "]", $content );

		//Disabled to remove HTML-support in input
		//content= replace(content, "<", "&lt;")
		//content= replace(content, ">", "&gt;")
		//$function_ret=$content;
	}
	return $content;
}

function rqJS( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		//content = Server.HTMLEncode(content)

		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "\\'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );
		$content = str_replace( "\r\n", "<br/>", $content );
		$content = str_replace( "[br]", "<br/>", $content );
		$content = str_replace( "[b]", "<b>", $content );
		$content = str_replace( "[/b]", "</b>", $content );
		$content = str_replace( "\"", "", $content );

		//$function_ret=$content;
	}
	return $content;
}

//reverse user input

function rq( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );
		$content = str_replace( "\r\n", "<br/>", $content );
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

//reverse user input in forms

function rqForm( $content ) {
	//extract($GLOBALS);

	if( $content != "" ) {
		$content = str_replace( "&#59;", ";", $content );
		$content = str_replace( "&#44;", ",", $content );
		$content = str_replace( "&#39;", "'", $content );
		$content = str_replace( "&#34;", "\"", $content );
		$content = str_replace( "&lt;", "<", $content );
		$content = str_replace( "&gt;", ">", $content );

		//content= replace(content, vbCrlf, "<br/>")

		$content = str_replace( "[br]", "\r\n", $content );

		//$function_ret=$content;
	}
	return $content;
}

function theme_box($header, $content) {
	return "<div class='box'>\n\t<h3 class='boxheader'>{$header}</h3>\n\t<div class='boxContents'>{$content}</div>\n</div>";
}

function getMonth( $monthNr ) {
	extract( $GLOBALS );
	switch( $monthNr ) {
		case 1:
			$manad = "Januari";
			break;

		case 2:
			$manad = "Februari";
			break;

		case 3:
			$manad = "Mars";
			break;

		case 4:
			$manad = "April";
			break;

		case 5:
			$manad = "Maj";
			break;

		case 6:
			$manad = "Juni";
			break;

		case 7:
			$manad = "Juli";
			break;

		case 8:
			$manad = "Augusti";
			break;

		case 9:
			$manad = "September";
			break;

		case 10:
			$manad = "Oktober";
			break;

		case 11:
			$manad = "November";
			break;

		case 12:
			$manad = "December";
			break;
	}
	$function_ret = $manad;
	return $function_ret;
}

function getDays( $monthNr ) {
	extract( $GLOBALS );
	switch( $monthNr ) {
		case 1:
			$days = 31;

			//Case 2 days = 28

			break;

		case 2:
			$days = 29;

			//&Oring;kad med ett f&ouml;r att st&ouml;dja skott&aring;r &aring;r 2004:

			break;

		case 3:
			$days = 31;
			break;

		case 4:
			$days = 30;
			break;

		case 5:
			$days = 31;
			break;

		case 6:
			$days = 30;
			break;

		case 7:
			$days = 31;
			break;

		case 8:
			$days = 31;
			break;

		case 9:
			$days = 30;
			break;

		case 10:
			$days = 31;
			break;

		case 11:
			$days = 30;
			break;

		case 12:
			$days = 31;
			break;
	}
	$function_ret = $days;
	return $function_ret;
}

function getNext( $s ) {
	extract( $GLOBALS );

	// s = sign (eg +,-)
	// am = aktuell m&aring;nad
	// ay = aktuellt &aring;r

	if( $s == "+" ) {
		if( $mm == 12 ) {
			$am = 1;
			$ay = $yyyy + 1;
		}
		else {
			$am = $mm + 1;
			$ay = $yyyy;
		}
	}
	else {
		if( $mm == 1 ) {
			$am = 12;
			$ay = $yyyy - 1;
		}
		else {
			$am = $mm - 1;
			$ay = $yyyy;
		}
	}
	if( strlen( $am ) <= 1 ) {
		$am = "0".$am;
	}
	$function_ret = $am."&yy=".$ay;
	return $function_ret;
}

function smarty_function_time($param, &$smarty) {
    return Util::timediff();
}