<?php
class Userfavorites extends Widget {
	public function run() {
		if(isset($_GET['userfavorites_filter']) && $this->session->isLoggedIn())
			if(in_array($_GET['userfavorites_filter'], array('all', 'online', 'local')))
				$this->settings->set('userfavorites_filter', $_GET['userfavorites_filter'], $this->session->userId());
		
		$only_online = ($this->settings->get('userfavorites_filter') == 'online');
		$location = $this->settings->get('userfavorites_filter') == 'local' ? $this->session->userdata('location') : FALSE;
		
		$this->url = $this->uri->ruri_string();
		$this->filter = $this->settings->get('userfavorites_filter');
		$this->items = $this->models->user->get_favorites($this->session->userId(), $only_online, $location);
	}
}