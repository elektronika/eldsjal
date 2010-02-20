<?php
function region_contents($name, $contents = NULL) {
	static $regions = array();
	if( ! is_null($contents)) {
		if(isset($regions[$name]))
			return FALSE;
		else
			return $regions[$name] = $contents;
	}
	else
		return isset($regions[$name]) ? $regions[$name] : FALSE;
}

function region_name($name = NULL) {
	static $region_name = NULL;
	if( ! is_null($name))
		$region_name = $name;
	return $region_name;
}

function region($name) {
	region_name($name);
	ob_start();
}

function end_region() {
	$contents = ob_get_clean();
	$name = region_name();
	if( ! region_contents($name, $contents))
		print region_contents($name);
}

function clear_region($name) {
	region($name); end_region();
}