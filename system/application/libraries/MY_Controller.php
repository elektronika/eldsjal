<?php
class MY_Controller extends Controller {
	public $redirect = FALSE;
	public $show_profiler = FALSE;
	
	public function __construct() {		
		parent::Controller();
	
		if($this->settings->get('enable_profiler'))
			$this->show_profiler = TRUE;
			
		$this->view->template = $this->router->fetch_class().'_'.str_replace(array('get_', 'post_'), '', $this->router->fetch_method());
		$this->view->slogan = $this->settings->get('slogan');
		$this->view->site_name = $this->settings->get('site_name');
		$this->view->css = explode(',', $this->settings->get('css'));
		$this->view->body_class = $this->view->template.' '.$this->settings->get('body_class');
		$this->view->sublinks = array();
		$this->view->breadcrumbs = array();
		$this->view->messages = $this->session->getMessages();
		$this->view->display_header = TRUE;
		
		// Borde egentligen vara widgets {
		if(file_exists('revision')) {
			$this->view->revision_date = date('d/m/y, H:i', filemtime('revision'));
			$this->view->revision_name = 'rev. '.file_get_contents('revision');
		} else {
			$this->view->revision_date = 'DEV';
			$this->view->revision_name = 'DEV';
		}		
		$this->view->messages = $this->session->getMessages();
		$this->view->usersonline = $this->models->user->online_count();
		// }
		
		if($this->session->isLoggedIn()) {
			$this->view->isloggedin = TRUE;
			$this->view->widgets = array(
				'left' => explode(',', $this->settings->get('widgets_left')),
				'right' => $this->settings->get('widgets_right') == '' ? array() : explode(',', $this->settings->get('widgets_right'))
			);
		} else {
			$this->view->widgets = array(
				'left' => explode(',', $this->settings->get('widgets_left_guest')),
				'right' => $this->settings->get('widgets_right_guest') == '' ? array() : explode(',', $this->settings->get('widgets_right_guest'))
			);
		}
		$this->view->widgets['header'] = $this->settings->get('widgets_header') == '' ? array() :explode(',', $this->settings->get('widgets_header'));
		$this->view->widgets['main'] = explode(',', $this->settings->get('widgets_main'));
		$this->view->widgets['footer'] = explode(',', $this->settings->get('widgets_footer'));
	}
	
	protected function redirect($url) {
		$this->redirect = TRUE;
		$this->load->helper('url');
		redirect($url);
	}
}