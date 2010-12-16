<?php
Class Events extends Library {
	protected $events = array();
	
	public function trigger($event) {
		$this->event_loop($event, array_slice(func_get_args(), 1));
	}
	
	public function trigger_chained($event) {
		$args = array_slice(func_get_args(), 1);
		
		$args_ref = array();
		foreach($args as $arg)
			$args_ref[] =& $arg;
			
		$this->event_loop($event, $args_ref);
				
		return count($args_ref) > 1 ? $args_ref : current($args_ref);
	}
	
	protected function event_loop($event, $args = array()) {
		if($this->profiler && is_callable(array($this->profiler, 'add_data')))
			$this->profiler->add_data('Triggered events', $event);
			
		if(isset($this->events[$event]))
			foreach($this->events[$event] as $callback)
				call_user_func_array($callback, $args);
	}
	
	public function register($event, $callback) {
		$this->events[$event][] = $callback;
	}
}