<?php
class Header extends Widget {
	public function run() {
		$this->site_name = $this->settings->get('site_name');
	}
}