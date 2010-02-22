<?php
class Timeline extends Widget {
	public function run() {
		$this->items = $user_ids = array();
		
		foreach($this->models->forum->get_latest_posts($this->session->usertype(), 20) as $post) {
			$user_ids[$post->posterId] = $post->posterId;
			$item = (object) array('type' => 'forum', 'topic_id' => $post->topicId);
			$item->title = $post->topicname;
			$item->href = '/forum/redirecttopost/'.$post->messageId;
			$item->body = mb_substr($post->message, 0, 30).'...';
			$this->items[$post->timestamp.'_forum_'.$item->topic_id] = $item;
		}

		$usernames = $this->models->user->get_names_for($user_ids);
		
		foreach($this->models->thought->get_timeline() as $item) {
			$item->type = 'thought';
			$item->timestamp = $this->util->assureTimestamp($item->created);
			$item->body = mb_substr($item->body, 0, 30).'...';
			$this->items[$item->timestamp.'_thought_'.$item->id] = $item;
		}
		
		krsort($this->items);
		$this->items = array_slice($this->items, 0, $this->settings->get('timeline_items'));

		// $this->events = $this->models->event->get_upcoming(5);
		// $this->birthdays = $this->models->user->get_by_birthday(date('m'), date('d'));
		// $login_count = count($this->birthdays) > 5 ? count($this->birthdays) : 5;
		// $this->latest_logins = $this->models->user->get_latest_logins($login_count);
	}
}