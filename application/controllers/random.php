<?php
class Random extends MY_Controller {
	function get_index() {
		$alternatives = array('/gallery/random', '/forum/random');
		$this->redirect($alternatives[array_rand($alternatives)]);
	}
}