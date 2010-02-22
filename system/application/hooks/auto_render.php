<?php
function auto_render() {
	$CI =& get_instance();
	$CI->benchmark->mark('view_start');
    if( ! $CI->redirect)
		$CI->view->display();
	print $CI->output->get_output();
	$CI->benchmark->mark('view_end');
	if($CI->show_profiler)
		print $CI->profiler->run();
}