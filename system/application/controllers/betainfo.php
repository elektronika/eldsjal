<?php

class Betainfo extends Controller {

	function __construct()
	{
		parent::Controller();	
	}
	
	function get_index()
	{
		$this->dwootemplate->display('beta.tpl');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */