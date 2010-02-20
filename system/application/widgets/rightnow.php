<?php
class Rightnow extends Widget {
	public function run() {
		$this->whatsup = $this->models->whatsup->get();
	}
}