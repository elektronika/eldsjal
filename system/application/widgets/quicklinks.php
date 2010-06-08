<?php
class Quicklinks extends Widget {
	public function run() {
		$this->user = $this->models->user->get_by_id($this->session->userId());
		unset($this->user->ping);
		$this->quicklinks = array();
		$this->quicklinks[] = array('href' => '/thoughts/today', 'title' => 'Skriv tanke');
		$this->quicklinks[] = array('href' => '/forum/new/2/?event=1', 'title' => 'Skapa event');
		$this->quicklinks[] = array('href' => '/gallery/upload', 'title' => 'Ladda upp bild');
		$this->quicklinks[] = array('href' => '/random', 'title' => 'Slumpa!');
		
		$news_forum_id = $this->settings->get('news_widget_forum');
		if($this->acl->check($news_forum_id, 'create'))
			$this->quicklinks[] = array('href' => '/forum/new/'.$news_forum_id, 'title' => 'Publicera nyhet');
		
		if($this->session->isAdmin()) {
			$this->quicklinks[] = array('href' => '/random', 'title' => 'Kartan (hemlig)');
			$this->quicklinks[] = array('href' => '/random', 'title' => 'Släpp V3');
		}	
	}
}