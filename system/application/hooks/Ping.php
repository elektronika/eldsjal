<?php
function ping() {
	$CI =& get_instance();
	
	if( $CI->session->isLoggedIn() ) {
		$CI->db->query("UPDATE users SET online = 1, lastseen = NOW() WHERE userid = ".$CI->session->userid());
		$CI->db->query("UPDATE users SET online = 0 WHERE TIMESTAMPDIFF(MINUTE, lastseen, NOW()) > 10");
	}
}