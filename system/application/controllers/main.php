<?php
class Main extends MY_Controller {
	function get_index() {
		// if($this->session->isLoggedIn())
		// 			$this->widgets->set('left', $this->settings->get_array('widgets_left_front'));
		// 		else
		// 			$this->widgets->set('left', $this->settings->get_array('widgets_left_front_guest'));			
		
		$this->widgets->set('right', $this->settings->get_array('widgets_right_front'));

		$this->widgets->remove('content', 'defaultheader');
		$this->widgets->remove('content', 'region_content');
		// $this->settings->get_array('widgets_front')
		if($this->session->isLoggedIn())
			$this->widgets->add('highlight', 'quicklinks');

		foreach(array('new_timeline') as $widget)
			$this->widgets->add('content', $widget);
		
		if( ! $this->session->isLoggedIn())
			$this->widgets->add('highlight', 'frontintro');
		
		// Den här sidan består bara av widgets, så den behöver inte någon egen view.
		$this->view->template = 'layout';
	}
}