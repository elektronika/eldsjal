<?php
class Randomwisdom extends Widget {
	public function run() {
		$this->wisdom = $this->models->wisdom->get_random();
		$this->can_edit = $this->acl->check($this->settings->get('wisdom_category'));
	}
}