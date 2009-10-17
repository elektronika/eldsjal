<?php

class Wiki extends Controller {
    function get_index()
    {
    	$this->dwootemplate->display('wiki_index.tpl');
    }

	public function acl_controller() {
		return $this->user->isLoggedIn();
	}
}