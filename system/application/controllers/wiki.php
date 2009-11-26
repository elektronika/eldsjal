<?php
class Wiki extends MY_Controller {
    function get_index() {}

	public function acl_controller() {
		return $this->session->isLoggedIn();
	}
}