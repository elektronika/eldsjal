<?php
class News extends Widget {
	public function run() {
		$forum_id = $this->settings->get('news_widget_forum');
		$number_of_items = $this->settings->get('news_widget_items');
		
		$sql = "SELECT fm.message, ft.topicname, fm.messagedate, fm.posterid, ft.topicid, u.username FROM forumtopics AS ft JOIN forummessages AS fm ON ft.topicid = fm.topicid JOIN users AS u ON fm.posterid = u.userid WHERE ft.forumcategoryid = {$forum_id} GROUP BY ft.topicid ORDER BY fm.messagedate DESC LIMIT {$number_of_items}";
		$this->items = $this->db->query( $sql )->result();
	}
}