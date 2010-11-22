<?php
class MY_Controller extends Controller {
	public $redirect = FALSE;
	public $show_profiler = TRUE;
	protected $show_in_maintenance_mode = FALSE;
	protected $check_dsn = TRUE;
	
	public function __construct() {		
		parent::Controller();
		
		// Kolla om allt är installerat och så
		if($this->check_dsn) {
			if( ! file_exists('system/application/dsn')) {
				$this->redirect('/install/install');
			} else {
				$dsn = file_get_contents('system/application/dsn');
				$this->load->database($dsn);
				$this->load->library('settings'); //Kräver databas, så kan inte laddas mha autoload.php
			}
		} 		
		
		// Lite profiler kanske?
		if($this->settings->get('enable_profiler'))
			$this->show_profiler = TRUE;
		
		// Är sajten i maintenance mode?
		if($this->settings->get('maintenance_mode') && ! $this->show_in_maintenance_mode) {
			$this->redirect('/');
			die();
		}
			
		// Alerts för cache etc
		if($this->alerts->count('flush')) {
			$this->acl->flush();
			$this->settings->flush();
			$this->session->flush();
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
		
		// JS-variabler
		$this->view->js->isLoggedIn = $this->session->isLoggedIn();
		if($this->session->isLoggedin()) {
			$this->view->js->userId = $this->session->userId();
			$this->view->js->username = $this->session->username();
		}
		
		// Styr upp widgets och sånadäringa prylar
		
		// Egentligen borde settings-systemet känna av om man är inloggad eller inte, men vafan.
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