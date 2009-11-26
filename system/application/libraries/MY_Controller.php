<?php
class MY_Controller extends Controller {
	public $libraries = array('db', 'dwootemplate', 'session', 'arguments', 'form_validation', 'util', 'alert', 'pagination', 'load', 'input', 'uri', 'config', 'models', 'image_lib', 'upload', 'output');
	protected $libraries2 = array('dwootemplate', 'session', 'arguments', 'form_validation', 'util', 'pagination', 'input', 'config', 'models', 'image_lib', 'upload', 'output', 'profiler');
	public $template;
	public $redirect = FALSE;
	public $show_profiler = FALSE;
	
	public function __construct() {		
		parent::Controller();
	
		if($this->session->isAdmin())
			$this->show_profiler = TRUE;
			
		$this->template = $this->router->fetch_class().'_'.str_replace(array('get_', 'post_'), '', $this->router->fetch_method().'.tpl');
		$this->load->library($this->libraries2);
		
		// Dona model!
		$this->wisdom = $this->models->wisdom->get_random();
		$this->messages = $this->session->getMessages();
		$this->usersonline = $this->util->onlineCount();
		if($this->isloggedin = $this->session->isLoggedIn()) {
			$this->alert_count = $this->models->alert->total_count();
			$this->active_userlink = $this->util->userlink($this->session->userId(), $this->session->username());
			$this->whatsup = $this->models->whatsup->get();
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