<?php
class Userfavorites extends Widget {
	public function run() {
		if(isset($_GET['userfavorites_filter']) && $this->session->isLoggedIn())
			if(in_array($_GET['userfavorites_filter'], array('all', 'online')))
				$this->settings->set('userfavorites_filter', $_GET['userfavorites_filter'], $this->session->userId());
				
		if($this->settings->get('userfavorites_filter') == 'online')
			$only_online = TRUE;
		else
			$only_online = FALSE;
		
		$this->url = $this->uri->ruri_string();
		$this->filter = $this->settings->get('userfavorites_filter');
		$this->items = $this->models->user->get_favorites($this->session->userId(), $only_online);
	}
}