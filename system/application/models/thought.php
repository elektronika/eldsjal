<?php
class Thought extends Model {
	public function __construct() {
		parent::Model();
	}
	
	public function get_todays_thought($userid) {
		return $this->db
			->select('diarytopic AS title, diary AS body')
			->where('date(diarydate) = date(now())', NULL, FALSE)
			->where('userid', $this->user->userId())
			->get('diary')
			->row();
	}
	
	public function set_todays_thought(stdClass $new_thought, $userid) {
		$thought_exists = $this->get_todays_thought($this->user->userId());
		
		$new_thought->userid = $userid;
		$new_thought->diarydate = $this->util->mysql_date();
			
		if($thought_exists) {
			$this->db->update('diary', $new_thought, array('diaryid' => $thought_exists->diaryId));
			$thought_id = $thought_exists->diaryId;
		} else {
			$this->db->insert('diary', $new_thought);
			$thought_id = $this->db->insert_id();
		}
		
		return $thought_id;
	}
	
	public function get_by_id($id) {
		return $this->db
			->select('u.username, u.userid, d.diarytopic AS title, d.diary AS body, d.diarydate AS created')
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
		$thoughts_per_page = $this->user->setting('thoughts_per_page');
		return $this->db->query("SELECT diary.diarytopic AS title, diary.diary AS body, diary.diarydate AS created, users.username, users.userid, CONCAT('/thoughts/view/', diaryid) AS href FROM diary JOIN users on diary.userid = users.userid ORDER BY diary.diarydate DESC LIMIT {$page}, {$thoughts_per_page}")->result();
	}
	
	public function total_amount() {
		return $this->db->query("SELECT COUNT(*) AS count FROM diary")->row()->count;
	}
}