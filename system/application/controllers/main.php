<?php
class Main extends MY_Controller {
	function get_index() {
		$this->widgets->set('right', $this->settings->get_array('widgets_right_front'));

		$this->widgets->remove('content', 'defaultheader');
		$this->widgets->remove('content', 'region_content');
		
		$this->widgets->set('content', $this->settings->get_array('widgets_front'));
		
		if( ! $this->session->isLoggedIn())
			$this->widgets->add('highlight', 'frontintro');
		else
			$this->widgets->add('highlight', 'quicklinks');

		// Den här sidan består bara av widgets, så den behöver inte någon egen view.
		$this->view->template = 'layout';
	}
}