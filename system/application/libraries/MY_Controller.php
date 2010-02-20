<?php
class MY_Controller extends Controller {
	public $libraries = array('db', 'view', 'session', 'arguments', 'form_validation', 'util', 'alert', 'pagination', 'load', 'input', 'uri', 'config', 'models', 'image_lib', 'upload', 'output');
	protected $libraries2 = array('view', 'session', 'arguments', 'form_validation', 'util', 'pagination', 'input', 'config', 'models', 'image_lib', 'upload', 'output', 'profiler');
	public $template;
	public $redirect = FALSE;
	public $show_profiler = FALSE;
	
	public function __construct() {		
		parent::Controller();
	
		if($this->session->isAdmin())
			$this->show_profiler = TRUE;
			
		$this->template = $this->router->fetch_class().'_'.str_replace(array('get_', 'post_'), '', $this->router->fetch_method());
		
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
			// $this->view->alert_count = $this->models->alert->total_count();
			// $this->view->active_userlink = $this->util->userlink($this->session->userId(), $this->session->username());
			// $this->view->whatsup = $this->models->whatsup->get();
			$this->view->widgets = array('left' => array('usermenu', 'rightnow', 'calendar', 'randomwisdom', 'latestthoughts', 'latestlogins', 'latestimages'));
		} else {
			$this->view->widgets = array('left' => array('loginform'));
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