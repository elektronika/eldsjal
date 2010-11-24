<?php
class Development extends MY_Controller {
	public function get_index() {
		$this->view->widgets['right'] = array('devinfo');
		$this->view->log = file_exists('svnlog.xml') ? new SimpleXMLElement(file_get_contents('svnlog.xml')) : FALSE;
		$this->view->page_title = 'Hemsidesutveckling';
		$this->util->trail("kollar så Elektronika gör sitt jobb.");
	}
}
?>