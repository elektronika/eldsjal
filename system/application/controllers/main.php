<?php
class Main extends MY_Controller {
	function get_index() {
		if($this->session->isLoggedIn())
			$this->view->widgets['left'] = explode(',', $this->settings->get('widgets_left_front'));
		else
			$this->view->widgets['left'] = explode(',', $this->settings->get('widgets_left_front_guest'));
		
		$this->view->widgets['right'] = $this->settings->get('widgets_right_front') == '' ? array() : explode(',', $this->settings->get('widgets_right_front'));

		$this->view->frontimage = $this->db->query("select imageid,filetype, imagename, width, height from images where private = 0 and approved = 1 order by rand() limit 1")->row();
	}
}