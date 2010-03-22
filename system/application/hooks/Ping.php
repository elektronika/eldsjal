<?php
function ping() {
	$CI =& get_instance();
	if($CI->session->isLoggedIn())
		$CI->db->update('users', array('ping' => time()), array('userid' => $CI->session->userid()));
}