<?php
Class Models extends Library {
	protected $models = array();
	
	public function __construct() {
		parent::__construct();
		spl_autoload_register(array('models', 'autoload'));
	}
	
	public function __get($name) {
		// Ladda en model om den finns, langa fram en default-model för tabellen annars
		if(isset($this->models[$name]))
			return $this->models[$name];
		elseif($this->model_exists($name)) {
			$class = ucfirst($name).'Model';
			$this->models[$name] = new $class();
			return $this->models[$name];
		}
		else
			return new AutoModel($name);
	}
	
	protected function model_exists($model) {
		return class_exists($model.'Model');
	}
	
	public static function autoload($class) {
		$class = strtolower($class);
		if(file_exists(APPPATH.'models/'.$class.'.php'))
			require_once(APPPATH.'models/'.$class.'.php');
		elseif(file_exists(APPPATH.'models/'.$class.'_model.php'))
			require_once(APPPATH.'models/'.$class.'_model.php');
	}
}