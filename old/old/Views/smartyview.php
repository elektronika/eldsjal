<?php
class SmartyView extends Spiffy_View {
	protected $smarty;
	
	public function __construct() {
		$this->smarty = new Smarty();
	}
	
	public function render($templateName = 'default.tpl') {
		$this->smarty->assign('page', $this->data);
		return $this->smarty->fetch($templateName);
	}
	
	public function redirect() {
		
	}
}