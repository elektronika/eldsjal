<?php
class Welcome extends MY_Controller {
	protected $show_in_maintenance_mode = TRUE;
	
	public function get_index() {
		if($this->settings->get('maintenance_mode'))
			$this->view->template = 'maintenance_mode';
		elseif($this->session->isLoggedIn())
			$this->redirect('/main');
	}
}
?>