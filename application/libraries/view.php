<?php
Class View {
	public function display() {
		get_instance()->load->view($this->template, $this);
	}
}