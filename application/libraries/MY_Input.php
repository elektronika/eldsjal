<?php
class MY_Input extends CI_INPUT {
	public function __construct() {
		parent::CI_Input();
	}
	
	public function post_array(Array $fields) {
		$out = array();
		foreach($fields as $field)
			$out[$field] = $this->post($field);
		return $out;
	}
}