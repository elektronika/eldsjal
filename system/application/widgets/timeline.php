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
		
		// foreach($topics as $topic_id => $topic) {
		// 			$item = (object) array('type' => 'forum', 'topic_id' => $topic_id);
		// 			$item->title = current($topic)->topicname.' i '.current($topic)->forumcategoryname;
		// 			$item->topic_name = current($topic)->topicname;
		// 			$item->category_name = current($topic)->forumcategoryname;
		// 			$item->category_id = current($topic)->forumcategoryid;
		// 			$item->time = current($topic)->messageDate;
		// 			foreach(array_slice($topic, 0, 3) as $post)
		// 				$item->items[] = (object) array(
		// 					'body' => character_limiter(str_replace(array('[br]', "\n"),' ',$post->message), 80, '...'), 
		// 					'userid' => $post->posterId, 
		// 					'created' => $post->messageDate, 
		// 					'username' => $usernames[$post->posterId]->username, 
		// 					'slug' => $usernames[$post->posterId]->slug
		// 				);
		// 			$this->items[current($topic)->timestamp.'_forum_'.$item->topic_id] = $item;
		// 		}
		
		foreach($this->models->thought->get_timeline() as $item) {
			$item->type = 'thought';
			$item->timestamp = $this->util->assureTimestamp($item->created);
			$item->body = mb_substr($item->body, 0, 30).'...';
			$this->items[$item->timestamp.'_thought_'.$item->id] = $item;
		}
		
		krsort($this->items);
		$this->items = array_slice($this->items, 0, $this->settings->get('timeline_items'));
		// 
		// $this->news = $this->models->forum->get_latest_news(3);
		// $this->events = $this->models->event->get_upcoming(5);
		// $this->birthdays = $this->models->user->get_by_birthday(date('m'), date('d'));
		// $login_count = count($this->birthdays) > 5 ? count($this->birthdays) : 5;
		// $this->latest_logins = $this->models->user->get_latest_logins($login_count);
	}
}