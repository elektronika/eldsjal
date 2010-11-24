<?php
class Timeline extends Widget {
	public function run() {
		$this->items = $user_ids = array();
		
		$this->body_length = $this->settings->get('timeline_body_length');
		$number_of_items = $this->settings->get('timeline_items');
		
		$categories = $this->acl->get_by_right('read');
		
		foreach($this->models->forum->get_latest_posts_by_categories($categories, $number_of_items) as $post) {
			$user_ids[$post->posterId] = $post->posterId;
			$item = (object) array('type' => 'forum', 'topic_id' => $post->topicId);
			if($post->is_event)
				$item->type = 'event';
			$item->title = $post->topicname;
			$item->href = '/forum/redirecttopost/'.$post->messageId;
			$item->body = $post->message;
			$this->items[$post->timestamp.'_forum_'.$item->topic_id] = $item;
		}

		$usernames = $this->models->user->get_names_for($user_ids);
		
		foreach($this->models->thought->get_timeline() as $item) {
			$item->type = 'thought';
			$item->timestamp = $this->util->assureTimestamp($item->created);
			$item->body = $item->body;
			$this->items[$item->timestamp.'_thought_'.$item->id] = $item;
		}
		
		foreach($this->db->order_by('register_date', 'desc')->where('username !=', '')->get('users', $number_of_items)->result() as $item) {
			$item->type = 'user';
			$item->timestamp = $this->util->assureTimestamp($item->register_date);
			$item->title = $item->username;
			$item->body = $item->presentation;
			$item->id = $item->userId;
			$item->href = '/user/'.$item->id;
			$this->items[$item->timestamp.'_user_'.$item->id] = $item;
		}
		
		foreach($this->db->order_by('imageuploaddate', 'desc')->get('images', $number_of_items)->result() as $item) {
			$item->type = 'image';
			$item->timestamp = $this->util->assureTimestamp($item->imageUploadDate);
			$item->title = $item->imageName;
			$item->body = $item->imageDesc;
			$item->id = $item->imageId;
			$item->href = '/gallery/view/'.$item->id;
			$this->items[$item->timestamp.'_image_'.$item->id] = $item;
		}
		
		krsort($this->items);
		$this->items = array_slice($this->items, 0, $number_of_items);
	}
}