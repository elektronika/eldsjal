<?php
class Birthdays extends Widget {
	public function run() {
		$this->birthdays = $this->models->user->get_by_birthday(date('m'), date('d'));
	}
}