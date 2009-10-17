<?php

class Welcome extends Controller {

	function __construct()
	{
		parent::Controller();	
	}
	
	function get_index()
	{
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */