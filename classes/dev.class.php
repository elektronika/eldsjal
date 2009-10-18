<?php
class Dev {
	private $log;
	private static $dev;
	
	private function __construct() {
		$this->log = array();	
	}
	
	public static function get_dev(  ) {
    if ( !isset(self::$dev) )
      	self::$dev = new DEV();
    return self::$dev;
  	}
  	
    public static function has_dev() {
      return isset(self::$dev);
    }

  	public static function log( $type, $what) {
 		$dev = Dev::get_dev();
  		$dev->log[$type][] = $what;
  	}
  	
  	public function get_logs() {
  		return $this->log;
  	}
  	
  	public function get_globals() {
  		$globals = array('$_SESSION' => $_SESSION, '$_GET'=>$_GET, '$_POST'=>$_POST, '$_COOKIE'=>$_COOKIE, '$_SERVER' => $_SERVER);
  		$out = array();
  		foreach($globals as $name => $global)
  			$out[$name] = print_r($global, TRUE);
  		return $out;
  	}
}