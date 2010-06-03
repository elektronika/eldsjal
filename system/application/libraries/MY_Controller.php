<?php
class MY_Controller extends Controller {
	public $redirect = FALSE;
	public $show_profiler = FALSE;
	
	public function __construct() {		
		parent::Controller();
		
		// Lite profiler kanske?
		if($this->settings->get('enable_profiler'))
			$this->show_profiler = TRUE;
			
		// Alerts för cache etc
		if($this->alerts->count('flush')) {
			$this->acl->flush();
			$this->settings->flush();
			$this->alerts->remove('flush');
		}
		
		// Mekka bra-att-ha-variabler i viewen
		$this->view->template = $this->router->fetch_class().'_'.str_replace(array('get_', 'post_'), '', $this->router->fetch_method());
		$this->view->slogan = $this->settings->get('slogan');
		$this->view->site_name = $this->settings->get('site_name');
		$this->view->css = $this->settings->get_array('css');
		$this->view->sublinks = array();
		$this->view->breadcrumbs = array();
		$this->view->isloggedin = $this->session->isLoggedIn();
				
		$body_classes = array($this->settings->get('body_class'));
		$segments = array();
		foreach($this->uri->rsegment_array() as $segment) {
			$segments[] = $segment;
			$body_classes[] = 'page-'.implode('-', $segments);
		}
		$this->view->body_class = implode(' ', array_filter(array_unique($body_classes)));
		
		// Styr upp widgets och sånadäringa prylar
		if($this->session->isLoggedIn())
			$this->widgets->set('left',$this->settings->get_array('widgets_left'));
		else
			$this->widgets->set('left', $this->settings->get_array('widgets_left_guest'));
		
		$this->widgets->set('right', $this->settings->get_array('widgets_right'));
		$this->widgets->set('header', $this->settings->get_array('widgets_header'));
		$this->widgets->set('main', $this->settings->get_array('widgets_main'));
		$this->widgets->set('footer', $this->settings->get_array('widgets_footer'));
		$this->widgets->set('content', $this->settings->get_array('widgets_content'));
	}
	
	protected function redirect($url) {
		$this->redirect = TRUE;
		$this->load->helper('url');
		redirect($url);
	}
}