<?php
class NotificationsModule extends Module {
	public function __construct() {
		$this->events->register('guestbook_add', array($this, 'guestbook_add'));
		$this->events->register('message_add', array($this, 'message_add'));
	}
	
	public function guestbook_add($user, $post) {
		$this->load->library('notifications');
		$this->notifications->notify($user->id, 'guestbook');
	}
	
	public function message_add($user, $post) {
		$this->load->library('notifications');
		$this->notifications->notify($user->id, 'message');		
	}
}