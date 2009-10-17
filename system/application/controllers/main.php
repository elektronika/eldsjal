<?php

class Main extends Controller {

	function __construct()
	{
		parent::Controller();	
	}
	
	function get_index()
	{
		$this->dwootemplate->display('main.tpl');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */