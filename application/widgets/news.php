<?php
class News extends Widget {
	public function run() {
		$forum_id = $this->settings->get('news_widget_forum');
		$number_of_items = $this->settings->get('news_widget_items');
		
		$this->items = $this->db
			->join('forummessages', 'forumtopics.topicid = forummessages.topicid')
			// ->join('users', 'forummessages.posterid = users.userid')
			->where('forumcategoryid', $forum_id)
			->group_by('forumtopics.topicid')
			->order_by('messagedate', 'desc')
			->get('forumtopics', $number_of_items)
			->result();
	}
}