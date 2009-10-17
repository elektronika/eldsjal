<?php
class Forum_model extends Model {
	public function __construct() {
		parent::Model();
	}
	
	public function get_categories_for_usertype($usertype = 0, $user_id = NULL, $last_visit = NULL) {
		// WOHO, nästan vettigt normaliserat! :D
		$categories = $this->db->query(
			"SELECT 
				fc.forumCategoryName AS title,
				fc.forumCategoryDesc AS description,
				COUNT(ft.topicid) AS threads,
				MAX(ft.latestentry) AS updated,
				MAX(ft.topicid) AS newest_topic,
				fc.forumCategoryId AS id
			FROM forumcategory AS fc
			JOIN forumtopics AS ft
				ON fc.forumcategoryid = ft.forumcategoryid
			WHERE fc.forumsecuritylevel <= {$usertype}
			GROUP BY ft.forumcategoryid
			ORDER BY fc.forumcategorysortorder"
		)->result();
		
		$t_cats = $this->tracked_categories($user_id);
		
		foreach($categories as &$cat) {
			$cat->href = '/forum/category/'.$cat->id;
			$cat->classes = array();
			
			if( ! is_null($user_id) && ! is_null($last_visit)) {
				$last_visit = $this->util->assureTimestamp($last_visit);
				if(isset($t_cats[$cat->id]->track_latest)) {
					if($t_cats[$cat->id]->track_latest < $t_cats[$cat->id]->post_latest)
						$cat->classes[] = 'new';
					elseif($t_cats[$cat->id]->track_latest < $this->util->assureTimestamp($cat->updated))
						$cat->classes[] = 'new';
				} elseif($this->util->assureTimestamp($cat->updated) > $last_visit) {
					$cat->classes[] = 'new';
				}
			}
		}
		return $categories;
	}
	
	protected function tracked_categories($user_id) {
		$categories = $this->db->query(
			"SELECT
				ft.forumcategoryid AS id,
				MAX(fts.time) AS track_latest,
				UNIX_TIMESTAMP(MAX(ft.topicdate)) AS post_latest
			FROM forumtopics AS ft 
			LEFT JOIN forumtracks AS fts 
				ON ft.topicid = fts.topic_id 
			WHERE fts.user_id = '{$user_id}'
			GROUP BY ft.forumcategoryid
			ORDER BY fts.time DESC")->result();
		$out = array();
		foreach($categories as $cat)
			$out[$cat->id] = $cat;
		return $out;
	}
	
	public function get_categories_for_usertype_assoc($usertype = 0) {
		$categories = $this->get_categories_for_usertype($usertype);
		$out = array();
		foreach($categories as $category) {
			$out[$category->id] = $category->title;
		}
		return $out;
	}
	
	public function acl_topic($id, $usertype) {
		return ($this->db->query("SELECT fc.forumcategoryid FROM forumcategory AS fc JOIN forumtopics AS ft ON fc.forumcategoryid = ft.forumcategoryid WHERE fc.forumsecuritylevel <= {$usertype} AND ft.topicid = ".intval($id))->num_rows > 0);
	}
	
	public function acl_category($id, $usertype) {
		return ($this->db->query("SELECT forumcategoryid FROM forumcategory WHERE forumsecuritylevel <= {$usertype} AND forumcategoryid = ".intval($id))->num_rows > 0);
	}	
	
	public function create_topic(stdClass $new_topic) {
		$topic = new stdClass();
		$topic->topicname = $new_topic->title;
		$topic->forumcategoryid = $new_topic->category;
		$topic->topicdate = date('Y-m-d H:i:s');
		$topic->topicposterid = $new_topic->userid;
		$topic->latestentry = $topic->topicdate;
		$topic->totalentrys = 0;
		$topic->sticky = 0;
		
		$this->db->insert('forumtopics', $topic);
		$topic_id = $this->db->insert_id();
		
		$post = new stdClass();
		$post->topicid = $topic_id;
		$post->posterid = $topic->topicposterid;
		$post->message = $new_topic->body;
		$post->messagedate = $topic->topicdate;
		
		$this->db->insert('forummessages', $post);
		
		// Denna skola icke behövas, ty normalisering äro den enda sanna vägen!
		$this->reindex_category($topic->forumcategoryid);
		
		return $topic_id;
	}
	
	public function create_post(stdClass $new_post) {
		$post = new stdClass();
		$post->topicid = $new_post->topicid;
		$post->posterid = $new_post->userid;
		$post->message = $new_post->body;
		$post->messagedate = date('Y-m-d H:i:s');
		
		$this->db->insert('forummessages', $post);	
		$post_id = $this->db->insert_id();
		
		// Denna skola icke behövas, ty normalisering äro den enda sanna vägen!
		$this->reindex_thread($post->topicid);
		
		return $post_id;
	}
	
	// Ska byggas bort!
	public function reindex_category($id) {
		$topic_count = $this->db->query("SELECT COUNT(*) AS count FROM forumtopics WHERE forumcategoryid = {$id}")->row()->count;
		$latest_post = $this->db->query("SELECT latestentry FROM forumtopics WHERE forumcategoryid = {$id} ORDER BY latestentry DESC LIMIT 1")->row()->latestentry;
		$this->db->update('forumcategory', array('forumcategorythreads' => $topic_count, 'forumcategorylatestpost' => $latest_post), array('forumcategoryid' => $id));
	}
	
	// Ska byggas bort!
	public function reindex_thread($id, $reindex_category = TRUE) {
		$post_count = $this->db->query("SELECT COUNT(*) AS count FROM forummessages WHERE topicid = {$id}")->row()->count;
		$latest_post = $this->db->query("SELECT messagedate FROM forummessages WHERE topicid = {$id} ORDER BY messagedate DESC LIMIT 1")->row()->messagedate;
		$latest_poster = $this->db->query("SELECT posterid FROM forummessages WHERE topicid = {$id} ORDER BY messagedate DESC LIMIT 1")->row()->posterid;
		$this->db->update('forumtopics', array('totalentrys' => $post_count, 'latestentry' => $latest_post, 'latestentryby' => $latest_poster), array('topicid' => $id));
		$category_id = $this->db->query("SELECT forumCategoryID AS id FROM forumtopics WHERE topicid = {$id}")->row()->id;
		if($reindex_category)
			$this->reindex_category($category_id);
	}
	
	public function count_topics_in_category($cat_id) {
		return $this->db->query("SELECT COUNT(*) AS count FROM forumtopics WHERE forumcategoryid = {$cat_id}")->row()->count;
	}
	
	public function get_topics_in_category($cat_id, $offset, $limit, $user_id = NULL, $last_visit = NULL) {
		$topics = $this->db->query(
			"SELECT 
				f.topicname AS title, 
				f.sticky, 
				f.locked, 
				f.topicid AS id, 
				f.topicdate AS created, 
				COUNT(fm.messageid) - 1 AS replies,
				MAX(fm.messagedate) AS updated,
				0 AS is_news, 
				creator.username AS creator__username, 
				creator.userid AS creator__userid, 
				updater.username AS updater__username, 
				updater.userid AS updater__userid 
			FROM forumtopics AS f 
			JOIN users AS creator 
				ON creator.userid = f.topicposterid 
			JOIN users AS updater 
				ON updater.userid = f.latestentryby 
			JOIN forummessages AS fm
				ON f.topicid = fm.topicid
			WHERE f.forumcategoryid = ".intval($cat_id)." 
			GROUP BY f.topicid
			ORDER BY sticky DESC, latestEntry DESC 
			LIMIT ".intval($offset).", {$limit}"
		)->result();	
		
		if( ! is_null($user_id))
			$tracked_topics = $this->get_tracked_topics($user_id);
		
		foreach($topics as &$topic) {
			$this->util->ormify($topic);
			
			$topic->classes = array();
			if($topic->locked)
				$topic->classes[] = 'locked';
			if($topic->sticky)
				$topic->classes[] = 'sticky';
			if($topic->replies == 0)
				$topic->classes[] = 'no-replies';

			if( ! is_null($user_id) && ! is_null($last_visit)) {
				$last_visit = $this->util->assureTimestamp($last_visit);
				if(isset($tracked_topics[$topic->id])) {
					// Topicen trackas, och den uppdaterades efter att den lästes av $user_id sist
					if($tracked_topics[$topic->id]->time < $this->util->assureTimestamp($topic->updated))
						$topic->classes[] = 'new';
				} elseif($this->util->assureTimestamp($topic->updated) > $last_visit) {
					// Topicen trackas inte, men den uppdaterades efter förra besöket
					$topic->classes[] = 'new';
				}
			}
		}
		$this->add_topic_actions($topics);
		return $topics;
	}
	
	protected function add_topic_actions(&$topics) {
		foreach($topics as &$topic) {
			$topic->actions = array();
			if($this->user->isAdmin()) { // || $this->user->userId() == $topic->userid) {
				$topic->actions[] = array('title' => 'Redigera', 'href' => '/forum/edit/'.$topic->id, 'class' => 'edit');
				$topic->actions[] = array('title' => 'Radera tråden', 'href' => '/forum/delete/'.$topic->id, 'class' => 'delete confirm');				
			}
			
			if($this->user->isAdmin()) {
				if($topic->is_news)
					$topic->actions[] = array('title' => 'Ta bort som nyhet', 'href' => '/forum/unmarkasnews/'.$topic->id, 'class' => 'unmakenews');								
				else
					$topic->actions[] = array('title' => 'Gör till nyhet', 'href' => '/forum/markasnews/'.$topic->id, 'class' => 'makenews');								
			}
		}
	}
	
	protected function get_tracked_topics($user_id) {
		$tracked_topics = $this->db->where('user_id', $user_id)->get('forumtracks')->result();
		$topics = array();
		foreach($tracked_topics as $topic)
			$topics[$topic->topic_id] = $topic;
		return $topics;
	}
	
	public function add_track($topic_id, $user_id) {
		$this->db->query("REPLACE INTO forumtracks (topic_id, user_id, time) VALUES ('{$topic_id}', '{$user_id}', '".time()."')");
	}
	
	public function get_posts_for_topic($topic_id) {
		$posts = $this->db->query(
			"SELECT 
				f.message AS body, 
				f.messagedate AS created, 
				f.messageid AS id, 
				u.username, 
				u.userid 
			FROM forummessages AS f 
			JOIN users AS u 
				ON u.userid = f.posterid 
			WHERE f.topicid = ".intval($topic_id)." 
			ORDER BY messageid ASC"
		)->result();
		$this->add_post_actions($posts);
		return $posts;
	}
	
	private function add_post_actions(&$posts) {
		foreach($posts as &$post) {
			$post->actions = array();
			if($this->user->isAdmin() || $this->user->userId() == $post->userid) {
				$post->actions[] = array('title' => 'Redigera', 'href' => '/forum/edit/'.$post->id, 'class' => 'edit');
				$post->actions[] = array('title' => 'Radera inlägget', 'href' => '/forum/delete/'.$post->id, 'class' => 'delete confirm');				
			}
		}
	}
	
	public function get_category_by_id($cat_id) {
		return $this->db->query("SELECT * FROM forumcategory WHERE forumcategoryid = ".intval($cat_id))->row();
	}
	
	public function get_topic_by_id($topic_id) {
		$remap = array(
			'topicName' => 'title',
			'topicPosterId' => 'creator',
			'topicDate' => 'created',
			'topicId' => 'id',
			'totalEntrys' => 'replies',
			'latestEntry' => 'updated',
			'latestEntryBy' => 'updater',
			'forumCategoryId' => 'category_id',
		);
		$topic = $this->db->query("SELECT * FROM forumtopics AS ft JOIN forumcategory AS fc ON fc.forumcategoryid = ft.forumcategoryid WHERE ft.topicid = ".intval($topic_id))->row();		
		return $this->util->remap($topic, $remap);
	}
	
	public function get_post_by_id($post_id) {
		$remap = array(
			'messageId' => 'id',
			'message' => 'body',
			'messageDate' => 'created',
			'posterId' => 'creator',
			'topicId' => 'topic_id'
		);
		$post = $this->db
			->where('messageid', $post_id)
			->get('forummessages')->row();
		return $this->util->remap($post, $remap);
	}
	
	public function post_is_first($post_id) {
		$topic_id = $this->db->select('topicid')->where('messageid', $post_id)->get('forummessages')->row()->topicid;
		$first_post = $this->db->query("SELECT messageid FROM forummessages WHERE topicid = {$topic_id} ORDER BY messageid ASC")->row()->messageid;
		return ($post_id == $first_post);
	}
	
	public function topic_id_for_post($post_id) {
		return $this->db->select('topicid')->where('messageid', $post_id)->get('forummessages')->row()->topicid;
	}
	
	public function rename_topic($topic_id, $title) {
		$this->db->update('forumtopics', array('topicname' => $title), array('topicid' => $topic_id));
	}
	
	public function update_post($post_id, $body) {
		$post = new stdClass();
		$post->message = $body;
		$post->messagedate = $this->util->mysql_date();
		$this->db->update('forummessages', $post, array('messageid' => $post_id));
		$this->reindex_thread($this->topic_id_for_post($post_id));
	}
	
	public function get_random_topic($userlevel) {
		return $this->db->query("SELECT ft.topicid FROM forumtopics AS ft JOIN forumcategory AS fc ON ft.forumcategoryid = fc.forumcategoryid WHERE fc.forumsecuritylevel <= {$userlevel} ORDER BY RAND() LIMIT 1")->row()->topicid;
	}
	
	public function delete_post($post_id) {
		$topic_id = $this->topic_id_for_post($post_id);
		$this->db->delete('forummessages', array('messageid' => $post_id));
		$this->reindex_thread($topic_id);
	}
	
	public function post_creator($post_id) {
		return $this->db->where('messageid', $post_id)->get('forummessages')->row()->posterId;
	}
}