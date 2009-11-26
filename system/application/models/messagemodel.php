<?php
class MessageModel extends AutoModel {
	public function add($title, $body, $from_user_id, $to_user_id) {
		$message = new stdClass();
		$message->messagetopic = $title;
		$message->message = $body;
		$message->userid = $to_user_id;
		$message->messagefrom = $from_user_id;
		$message->messagedate = $this->util->mysql_date();
		$message->readmessage = 0;
		$this->db->insert('messages', $message);
		return $this->db->insert_id();
	}
}