<?php
class Loginform extends Widget {
	public function run() {
		$this->username = isset( $_COOKIE['username'] ) ? $_COOKIE['username'] : '';
	}
}