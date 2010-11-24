<?php
class Defaultheader extends Widget {
	public function run() {
		if(isset($this->view->page_title))
			$this->page_title = $this->view->page_title;
		$this->breadcrumbs = $this->view->breadcrumbs;
		$this->sublinks = $this->view->sublinks;
	}
}