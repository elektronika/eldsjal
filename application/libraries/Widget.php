<?php

class Widget {
    function run($name) {        
		$filename = APPPATH.'widgets/'.$name.EXT;
        if(file_exists($filename)) {
	    	require_once $filename;
	        $name = ucfirst($name);
	        $widget = new $name();
		} else {
			require_once APPPATH.'widgets/static'.EXT;
			$widget = new StaticWidget();
		}
        
		$widget->run();
		$widget->render(strtolower($name), (array) $widget);
    }
    
    function render($view, $data = array()) {
        extract($data);
        include APPPATH.'widgets/views/'.$view.EXT;
    }

    function __get($var) {
        return $ci = get_instance()->$var;
    }
}