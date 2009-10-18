<?php
class DummyView extends Spiffy_View {
	public function __construct() {
		ob_start();
	}
	
	public function render() {
		$output = ob_get_contents();
		ob_clean();
		return $output;
	}
	
	public function redirect() {
		
	}
}