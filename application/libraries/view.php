<?php
Class view {
	public function display() {
		get_instance()->load->view($this->template, $this);
	}
}