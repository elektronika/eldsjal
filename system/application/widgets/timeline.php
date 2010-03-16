<?php
class Timeline extends Widget {
	public function run() {
		$this->items = $user_ids = array();
		
		foreach($this->models->forum->get_latest_posts($this->session->usertype(), 20) as $post) {
			$user_ids[$post->posterId] = $post->posterId;
			$item = (object) array('type' => 'forum', 'topic_id' => $post->topicId);
			if($post->is_event)
				$item->type = 'event';
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
		
		foreach($this->db->order_by('register_date', 'desc')->get('users', 10)->result() as $item) {
			$item->type = 'user';
			$item->timestamp = $this->util->assureTimestamp($item->register_date);
			$item->title = $item->username;
			$item->body = mb_substr($item->presentation, 0, 30).'...';
			$item->id = $item->userId;
			$item->href = '/user/'.$item->id;
			$this->items[$item->timestamp.'_user_'.$item->id] = $item;
		}
		
		foreach($this->db->order_by('imageuploaddate', 'desc')->get('images', 20)->result() as $item) {
			$item->type = 'image';
			$item->timestamp = $this->util->assureTimestamp($item->imageUploadDate);
			$item->title = $item->imageName;
			$item->body = mb_substr($item->imageDesc, 0, 30).'...';
			$item->id = $item->imageId;
			$item->href = '/gallery/view/'.$item->id;
			$this->items[$item->timestamp.'_image_'.$item->id] = $item;
		}
		
		krsort($this->items);
		$this->items = array_slice($this->items, 0, $this->settings->get('timeline_items'));

		// $this->events = $this->models->event->get_upcoming(5);
		// $this->birthdays = $this->models->user->get_by_birthday(date('m'), date('d'));
		// $login_count = count($this->birthdays) > 5 ? count($this->birthdays) : 5;
		// $this->latest_logins = $this->models->user->get_latest_logins($login_count);
	}
}