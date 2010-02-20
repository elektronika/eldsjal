<?php
function auto_render() {
	$CI =& get_instance();
	
	// foreach($CI as $var => $val)
	// 	if( ! in_array($var, $CI->libraries))
	// 		$CI->view->$var = $val;
    if( ! $CI->redirect)
		$CI->view->display($CI->template);
	print $CI->output->get_output();
	if($CI->show_profiler)
		print $CI->profiler->run();
}