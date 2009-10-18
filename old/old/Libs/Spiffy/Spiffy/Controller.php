<?php
class Spiffy_Controller {
	protected $request;
	protected $view;
	protected $app;
	protected $defaultAclPolicy = TRUE;
	protected $defaultAclPolicyExceptions = array();
	
	public function handle(Spiffy_Request $request, Spiffy_View &$view, Spiffy_App &$app) {
		$this->handleView($view);
		$this->handleApp($app);
		return $this->handleRequest($request);
	}
	
	protected function handleRequest(Spiffy_Request $request) {
		$this->request = $request;	
		
		if( !($method = $this->getMethodName()) )
		 	throw new Spiffy_MissingMethodException('någon metod', get_class());
		
		/*
			TODO This one should be optional, pluginish, or something
		*/
		if( !$this->aclCheck($method) )
			throw new Spiffy_PermissionDeniedException();

		return $this->runMethod($method);	
	}
	
	protected function handleView(Spiffy_View $view) {
		if(empty($this->view))
			$this->view = $view;		
	}
	
	protected function handleApp(Spiffy_App $app) {
		if(empty($this->app))
			$this->app = $app;	
	}
	
	protected function delegate(Spiffy_Controller $controller) {
		return $controller->handle($this->request, $this->view, $this->app);
	}
	
	protected function getMethodName() {
		$methodNames = array(
			$this->request->requestMethod().'_'.$this->request->nextArg(),
			$this->request->requestMethod().'_'.$this->app->getVar('defaultControllerMethod')
		);
				
		foreach( $methodNames as $methodName )
			if( is_callable(array($this, $methodName)) )
				return $methodName;
		
		return FALSE;
	}
	
	protected function aclCheck($method) {
		$methodNames = array(
			'acl_'.$method,
			'acl_'.str_replace($this->request->requestMethod().'_', '', $method),
			'acl_default'
		);
		
		foreach( $methodNames as $methodName )
			if( is_callable(array($this, $methodName)) )
				return call_user_func(array($this, $methodName));

		return $this->defaultAclPolicy;
	}
	
	protected function runMethod($method) {
		return call_user_func_array(array($this, $method), $this->request->restOfArgs());
	}
}