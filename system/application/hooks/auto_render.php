<?php
function auto_render() {
	$CI =& get_instance();
	
    if( ! $CI->redirect)
		$CI->view->display();
	print $CI->output->get_output();
	if($CI->show_profiler)
		print $CI->profiler->run();
}