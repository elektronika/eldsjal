<?php
class MessageModel extends AutoModel {
	public function add($title, $body, $from_user_id, $to_user_id, $reply_to = NULL) {
		$message = new stdClass();
		$message->messagetopic = $title;
		$message->message = $body;
		$message->userid = $to_user_id;
		$message->messagefrom = $from_user_id;
		$message->messagedate = $this->util->mysql_date();
		$message->readmessage = 0;
		$message->reply_to = $reply_to;
		$this->db->insert('messages', $message);
		return $this->db->insert_id();
	}
	
	public function get_messages_to($user_id, $offset, $limit) {
		$messages = $this->db
			->select('messageid AS id, messagetopic AS title, reply_to, messagedate AS created, receiver.username AS receiver_name, receiver.userid AS receiver_id, sender.username AS sender_name, sender.userid AS sender_id, readmessage AS is_read')
			->join('users AS receiver', 'receiver.userid = messages.userid')
			->join('users AS sender', 'sender.userid = messages.messagefrom')
			->where('messages.userid', $user_id)
			->where('reply_to IS NULL')
			->or_where('messages.messagefrom', $user_id)
			->where('reply_to IS NULL')
			->order_by('messagedate', 'desc')
			->get('messages', $offset, $limit)->result();
		foreach($messages as &$message) {
			$message->classes = array();
			if( ! $message->is_read)
				$message->classes[] = 'unread';
			$message->href = is_null($message->reply_to) ? '/messages/view/'.$message->id : '/messages/view/'.$message->reply_to;
			$message->sender = (object) array('username' => $message->sender_name, 'userid' => $message->sender_id);
			$message->receiver = (object) array('username' => $message->receiver_name, 'userid' => $message->receiver_id);
		}
		return $messages;
	}
	
	public function get_conversation($message_id) {
		return $this->db
			->select('messagetopic AS title, message AS body, messagedate AS created, messagefrom AS userid, username, readmessage AS is_read, messageid AS id')
			->join('users', 'users.userid = messages.messagefrom')
			->where('messageid', $message_id)
			->or_where('reply_to', $message_id)
			->order_by('messagedate', 'asc')
			->get('messages')->result();
	}
	
	public function get_by_id($message_id) {
		return $this->db->where('messageid', $message_id)->get('messages')->row();
	}
	
	public function count_messages_to_user($user_id) {
		return $this->db->select('COUNT(*) AS count', FALSE)->where('userid', $user_id)->where('reply_to IS NULL')->get('messages')->row()->count;
	}
	
	// Borde egentligen kombineras ihop med alertsena när dom kommer
	public function mark_as_read($message_id) {
		return $this->db->update('messages', array('readmessage' => 1), array('messageid' => $message_id));
	}
}