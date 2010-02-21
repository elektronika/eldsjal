<?php
class MY_Controller extends Controller {
	public $redirect = FALSE;
	public $show_profiler = FALSE;
	
	public function __construct() {		
		parent::Controller();
	
		if($this->session->isAdmin())
			$this->show_profiler = TRUE;
			
		$this->view->template = $this->router->fetch_class().'_'.str_replace(array('get_', 'post_'), '', $this->router->fetch_method());
		$this->view->slogan = $this->settings->get('slogan');
		
		// Borde egentligen vara en widget
		if(file_exists('revision')) {
			$this->view->revision_date = date('d/m/y, H:i', filemtime('revision'));
			$this->view->revision_name = 'rev. '.file_get_contents('revision');
		} else {
			$this->view->revision_date = 'DEV';
			$this->view->revision_name = 'DEV';
		}
		
		$this->view->messages = $this->session->getMessages();
		$this->view->usersonline = $this->util->onlineCount();
		if($this->session->isLoggedIn()) {
			$this->view->isloggedin = TRUE;
			$this->view->widgets = array(
				'left' => array('usermenu', 'rightnow', 'calendar', 'randomwisdom', 'latestthoughts', 'latestlogins', 'latestimages'),
				'right' => array());
		} else {
			$this->view->widgets = array('left' => array('loginform', 'calendar', 'randomwisdom', 'latestthoughts', 'latestlogins', 'latestimages'));
		}
	}
	/**
	 * Automatic loading of libraries, yay!
	 *//*
	public function __get($name) {
		if( ! isset($this->$name) && in_array($name, $this->libraries) && $name != 'load')
			$this->load->library($name);
		return $this->$name;
	}*/
	
	protected function redirect($url) {
		$this->redirect = TRUE;
		$this->load->helper('url');
		redirect($url);
	}
}