<?php
class RootController extends Spiffy_Controller {
	public function handleRequest(Request $request) {
		$this->request = $request;
		
		$arg = $this->request->nextArg();

		if( !empty($arg) ) {
			$controllerName = ucfirst($arg).'Controller';
		} else {
			$controllerName = $this->app->getVar('defaultControllerName');
			$this->request->undoNextArg();
		}
		
		if(!class_exists($controllerName))
			throw new ControllerMissingException($controllerName);

		return $this->delegate(new $controllerName());
	}
}