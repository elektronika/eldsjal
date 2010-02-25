<?php
class Welcome extends MY_Controller {
	public function get_index() {
		if($this->session->isLoggedIn())
			$this->redirect('/main');
	}
}
?>