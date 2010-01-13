<?php
function auto_render() {
	$CI =& get_instance();
	
	foreach($CI as $var => $val)
		if( ! in_array($var, $CI->libraries))
			$CI->dwootemplate->assign($var, $val);
    if( ! $CI->redirect)
		$CI->dwootemplate->display($CI->template);
	print $CI->output->get_output();
	if($CI->show_profiler)
		print $CI->profiler->run();
}