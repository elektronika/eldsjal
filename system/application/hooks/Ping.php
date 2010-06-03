<?php
function ping() {
	$CI =& get_instance();
	if($CI->session->isLoggedIn() && time() - $CI->session->userdata('ping') > $CI->settings->get('ping_interval')) {
		$CI->db->update('users', array('ping' => time()), array('userid' => $CI->session->userid()));
		$CI->session->set_userdata('ping', time());
	}
}