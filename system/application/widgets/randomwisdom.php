<?php
class Randomwisdom extends Widget {
	public function run() {
		$this->wisdom = $this->models->wisdom->get_random();
	}
}