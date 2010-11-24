<?php
class Inbox extends MY_Controller {
	function get_index() {
		$this->alerts = $this->models->alert->get_all_for_user($this->session->userId());
	}
}