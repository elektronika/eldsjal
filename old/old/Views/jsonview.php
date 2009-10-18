<?php
class JsonView extends Spiffy_View {	
	public function render() {
		header('Content-type: text/javascript');
		return json_encode($this->data);
	}
	
	public function redirect() {
		
	}
}