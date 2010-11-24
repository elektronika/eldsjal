<?php
class ThoughtModel extends AutoModel {
	public function __construct() {
		$this->table = 'diary';
		$this->remap = array(
			'diaryId' => 'id',
			'diaryTopic' => 'title',
			'diary' => 'body',
			'diaryDate' => 'created',
			'userId' => 'userid'
		);
	}
	
	public function get_todays_thought($userid) {
		$thought = $this->db
			->select('diarytopic AS title, diary AS body, diaryid AS id')
			->where('date(diarydate) = date(now())', NULL, FALSE)
			->where('userid', $this->session->userId())
			->get('diary')
			->row();
		return $thought;
	}
	
	public function set_todays_thought(stdClass $new_thought, $userid) {
		$thought_exists = $this->get_todays_thought($this->session->userId());
		
		$thought = new stdClass();
		$thought->diaryTopic = $new_thought->title;
		$thought->diary = $new_thought->body;
		$thought->userid = $userid;
		$thought->diarydate = $this->util->mysql_date();
			
		if($thought_exists) {
			$this->db->update('diary', $thought, array('diaryid' => $thought_exists->id));
			$thought_id = $thought_exists->id;
		} else {
			$this->db->insert('diary', $thought);
			$thought_id = $this->db->insert_id();
		}
		
		return $thought_id;
	}
	
	public function get_by_id($id) {
		return $this->db
			->select('u.username, u.userid, u.ping, u.hasimage, d.diarytopic AS title, d.diary AS body, d.diarydate AS created')
			->from('diary AS d')
			->join('users AS u', 'd.userid = u.userid')
			->where('diaryid', intval($id))
			->get()
			->row();
	}
	
	public function get_by_user($userid) {
		return $this->db
			->select("diarytopic AS title, diary AS body, diarydate AS created, diaryid AS id, CONCAT('/thoughts/view/', diaryid) AS href", FALSE)
			->where('userid', intval($userid))
			->order_by('diaryid DESC')
			->get('diary')
			->result();
	}
	
	public function get_timeline($page = 0) {
		if(intval($page) > 0)
			$page = intval($page);
		else
			$page = 0;
		$thoughts_per_page = $this->settings->get('thoughts_per_page'); // Borde inte vara där
		return $this->db->query("SELECT diary.diaryid AS id, diary.diarytopic AS title, diary.diary AS body, diary.diarydate AS created, users.username, users.userid, users.ping, CONCAT('/thoughts/view/', diaryid) AS href FROM diary JOIN users on diary.userid = users.userid ORDER BY diary.diarydate DESC LIMIT {$page}, {$thoughts_per_page}")->result();
	}
	
	public function total_amount() {
		return $this->db->query("SELECT COUNT(*) AS count FROM diary")->row()->count;
	}
}