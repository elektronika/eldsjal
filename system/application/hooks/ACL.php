<?php
function checkAclHook() {
	global $RTR, $URI; // Well, that's pretty much the only way to do it.

	$CI =& get_instance();
	$acl_method = str_replace(strtolower($_SERVER['REQUEST_METHOD']).'_', 'acl_', strtolower($RTR->fetch_method()));

	if(method_exists($CI, $acl_method)) {
		if(!call_user_func_array(array($CI, $acl_method), array_slice($URI->rsegments, 2)))
			show_error('Permission denied');		
	} 
	elseif(method_exists($CI, 'acl_controller')) {
		if(!call_user_func_array(array($CI, 'acl_controller'), array_slice($URI->rsegments, 2)))
			show_error('Permission denied');
	}

}