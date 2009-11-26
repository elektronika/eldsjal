<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Util {
	protected $settings = array();
	
	public function __construct() {
		$this->CI =& get_instance();
		log_message('debug', "Util Class Initialized");
		
		// Den här borde laddas från databasen tycker jag. Eller iaf inte ligga i den här klassen. *morr*
		$this->settings = array(
			'topics_per_page' => 20,
			'images_per_page' => 40,
			'thoughts_per_page' => 20,
			'guestbook_posts_per_page' => 20,
			'gallery_folder' => './uploads/galleryImages/',
			'original_image_folder' => './original_images/',
			'gallery_url' => '/uploads/galleryImages/',
			'default_image_extension' => 'jpg',
			'event_image_folder' => './uploads/eventImages/',
			'user_image_folder' => './uploads/userImages/',
			'original_user_image_folder' => './original_images/users/',
			'forum_posts_per_page' => 20
		);
	}
	
	public function timestamp_start($year, $month = 1, $day = 1) {
		return mktime(0, 0, 0, $month, $day, $year);
	}
	
	public function timestamp_end($year, $month = 12, $day = 0) {
		return mktime(23, 59, 59, $month, ($day == 0 ? $this->days_in_month($month) : $day), $year);
	}
	
	public function days_in_month($month) {
		return date('t', mktime(0, 0, 0, $month));
	}
	
	public function mysql_date($timestamp = NULL) {
		if(is_null($timestamp))
			$timestamp = time();
		return date('Y-m-d H:i:s', $timestamp);
	}
	
	/**
	 * Omvandlar $string till ett URL-vänligt format och returnerar det.
	 *
	 * @param string $string 
	 * @return string
	 * @author Johnny Karhinen
	 */
	public function slugify($string) {
		$slug = trim(strtolower($string));
		$replace = array(
			'å' => 'ao',
			'ä' => 'ae',
			'ö' => 'oe'
		);
		$slug = str_replace(array_keys($replace), $replace, $slug);
		$slug = preg_replace(array('/[^a-z0-9-]/', '/-+/'), '-', $slug);
		
		return $slug;
	}
	
	/**
	 * Returnerar värdet av en inställning.
	 *
	 * @param string $key 
	 * @return mixed
	 * @author Johnny Karhinen
	 */
	public function setting($key) {
		return $this->settings[$key];
	}
	
	/**
	 * Loopar igenom ett objekt/array och mappar om index(en).
	 *
	 * @param mixed $object 
	 * @param array $map $old_key => $new_key
	 * @return mixed
	 * @author Johnny Karhinen
	 */
	public function remap($object, Array $map) {
		if($was_array = is_array($object))
			$object = (object) $object;
			
		foreach($map as $from => $to)
			if(isset($object->$from)) {
				$object->$to = $object->$from;
				unset($object->$from);
			}
		
		if($was_array)
			$object = (array) $object;
			
		return $object;
	}
	
	public function reverseRemap($object, Array $map) {
		return $this->remap($object, array_flip($map));
	}
	
	/**
	 * Loopar igenom en array och mappar om varje objekt/array.
	 *
	 * @param mixed $objects Arrayen med objekt/arrayer att loopa igenom.
	 * @param array $map $old_key => $new_key
	 * @return array
	 * @author Johnny Karhinen
	 */
	public function remapLoop($objects, Array $map) {
		foreach($objects as &$object)
			$object = $this->remap($object, $map);
		return $objects;
	}
	
	// Hade det varit gjort "ordentligt" så hade man sluppit loopa igenom _alla_ attributen.
	public function ormify(&$object) {
		$orm_delimiter = '__';
		
		foreach($object as $attribute => $value) {
			if(strpos($attribute, $orm_delimiter)) {
				$parts = explode($orm_delimiter, $attribute);
				if(!isset($object->$parts[0])) {
					$object->$parts[0] = new stdClass();
				}
				$object->$parts[0]->$parts[1] = $value;
				unset($object->$attribute);			
			}
		}
	}
	
	public function fuzzytime( $timestamp, $prefix = NULL, $suffix = NULL, $hover = TRUE, $hoverDateFormat = 'Y-m-d H:i' ) {

		if(!is_numeric($timestamp)) {
			$timestamp = strtotime($timestamp);
		}

		$timeDiff = time() - $timestamp;
		if( is_null($prefix)) {
			if($timeDiff < 0) {
				$timeDiff = $timeDiff * -1;
				$prefix = 'om ';
				$suffix = '';
			} else {
				$prefix = 'för ';
				$suffix = ' sedan';
			}
		}
		
		$out = $prefix;

		if( $timeDiff < 60 )
			$out .= 'ett strax';
		elseif( $timeDiff < 7 * 60 )
			$out .= 'n&aring;gra minuter';
		elseif( $timeDiff < 17 * 60 )
			$out .= 'typ en kvart';
		elseif( $timeDiff < 27 * 60 )
			$out .= 'n&auml;stan en halvtimme';
		elseif( $timeDiff < 40 * 60 )
			$out .= 'lite mer &auml;n en halvtimme';
		elseif( $timeDiff < 55 * 60 )
			$out .= 'n&auml;stan en timme';
		elseif( $timeDiff < 90 * 60 )
			$out .= 'typ en timme';
		elseif( $timeDiff < 22 * 3600 )
			$out .= round($timeDiff / 3600).' timmar';
		elseif( $timeDiff < 30 * 3600 )
			$out .= 'ungefär en dag';
		elseif( $timeDiff < 37 * 3600 )
			$out .= 'lite mer än en dag';
		elseif( $timeDiff < 6 * 24 * 3600 )
			$out .= round($timeDiff / (24 * 3600)).' dagar';
		elseif( $timeDiff < 10 * 24 * 3600 )
			$out .= 'ungefär en vecka';
		elseif( $timeDiff < 29 * 24 * 3600 )
			$out .= round($timeDiff / (7 * 24 * 3600)).' veckor';
		elseif( $timeDiff < 360 * 24 * 3600 )
			$out .= round($timeDiff / (30 * 24 * 3600)).' m&aring;nader';
		else
			$out .= round($timeDiff / (365 * 24 * 3600)).' &aring;r';

		$out .= $suffix;

		if($hover)
			$out = '<span class="date" title="'.date($hoverDateFormat, $timestamp).'">'.$out.'</span>';

		return $out;
	}
	
	public function userlink($userid, $username, $slug = NULL) {
		if(is_null($slug))
			$slug = $this->slugify($username);
		return '<a href="/user/'.$slug.'" class="user u'.$userid.'">'.$username.'</a>';
	}
	
	public function onlineCount() {
		return $this->CI->db->query('SELECT COUNT(*) AS count FROM users WHERE online = 1')->row()->count;
	}
	
	public function titlify($title) {
		$titles = array(
			'event' => 'Aktiviteter',
			'guestbook' => 'Gästboksinlägg',
			'forum' => 'Foruminlägg',
			'message' => 'Meddelanden'
		);
		return isset($titles[(string) $title]) ? $titles[(string) $title] : (string) $title;
	}
	
	public function fuzzyage($timestamp) {
		$diff = time() - $this->assureTimestamp($timestamp);
		return floor( round(($diff / 86400) / 365, 1) * 10 ) / 10;
	}
	
	public function nicedate($timestamp) {		
		return ucfirst(strftime('%Aen den %e %B', $this->assureTimestamp($timestamp)));
	}
	
	public function shortdate($timestamp) {
		return date('y-m-d', $this->assureTimestamp($timestamp));
	}
	
	public function assureTimestamp($timestamp) {
		return (is_numeric($timestamp) ? $timestamp : strtotime($timestamp));
	}
}