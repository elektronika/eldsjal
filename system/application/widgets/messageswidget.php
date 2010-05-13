<?php
class Messageswidget extends Widget {
	public function run() {
		$this->messages = $this->session->getMessages();
	}
}