<?php
//require_once('util.class.php');

class MysqliExtended extends mysqli {	
	public function execute( $sql) {
      $t1 = microtime();
		$sql = str_replace('getdate()', 'now()', $sql);
		$sql = str_replace('[date]', 'date', $sql);
		// print $sql;
      $results = parent::query( $sql );
      $diff = Util::timediff($t1,microtime());
		if( $this->errno > 0 ) {
			print 'MySQL error ('.$this->errno .') '.$this->error;
			$out = false;
		}
		else {
			if( $results === TRUE ) 
				$out = TRUE;
			elseif( $results !== FALSE ) {
				if( $results->num_rows > 0 ) {
					while( $results && $row = $results->fetch_assoc() ) 
						$rows[] = array_change_key_case($row);
					// print_r($rows);
					if( count( $rows ) == 1 ) 
						$rows = current( $rows );
					$out = $rows;
				}
				else 
					$out = 0;
			}
			else 
				$out = false;
		}

      if($this->error)
        DEV::log('sql', Array('time'=>$diff,'query'=>$sql, 'error'=>$this->error));
      else if(strtolower(substr(trim($sql),0,6))=='insert')
        DEV::log('sql', Array('time'=>$diff,'query'=>$sql, 'insert_id'=>$this->insert_id));
      else if(strtolower(substr(trim($sql),0,6))=='update' || strtolower(substr(trim($sql),0,6))=='delete' )
        DEV::log('sql', Array('time'=>$diff,'query'=>$sql, 'affected_rows'=>$this->affected_rows));
      else
        DEV::log('sql', Array('time'=>$diff,'query'=>$sql, 'num_rows'=>is_object($results)?$results->num_rows:null));

      return $out;
	}
}

class DB {
  private static $connection;
  private function __construct()
  {
  }
  
  // The singleton method
  public static function mysql()
  {
    if (!isset(self::$connection)) {
      self::$connection = new MysqliExtended("localhost", "root", "kebabhatt", "eldsjal_new");
      mysqli_set_charset(self::$connection, "utf8");
	  self::$connection->execute("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    }
    
    return self::$connection;
  }
  
  // Example method

  public function __clone()
  {
    trigger_error('Clone is not allowed.', E_USER_ERROR);
  } 
}

?>