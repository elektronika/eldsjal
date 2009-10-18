<?php
class Spiffy_App {
	protected $config = array();
	
	public function getVar($var) {
		return $this->config[$var];
	}
	
	public function readConfigFromIni($file) {
		$this->config = parse_ini_file($file);
	}
	
	public function takeOff() {
		$controllerName = $this->getVar('mainController');
		$controller = new $controllerName();
		$viewName = $this->getVar('defaultView');
		$view = new $viewName();
		$emergencyView = $view;
		
		try {
			$result = $controller->handle(new Spiffy_Request(), $view, $this);
		} catch(ControllerException $e) {
			$result = $emergencyView->set('error', $e->getMessage())->render();
		}
		
		return $result;
	}
}