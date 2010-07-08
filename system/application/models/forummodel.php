<?php
class ForumModel extends AutoModel {
	public function get_categories_for_usertype($usertype = 0, $user_id = 0, $last_visit = NULL, $right = 'read') {
		// WOHO, nästan vettigt normaliserat! :D
		
		/*
			Ehm, den här metoden borde egentligen ta en array med kategori-id'n. Att göra sig beroende av ACL-libbet är lite dumt i längden.
		*/
		
		$acls = $this->acl->get_by_right('read');
		
		$categories = $this->db->query(
			"SELECT
				fc.forumCategoryName AS title,
				fc.forumCategoryDesc AS description,
				COUNT(ft.topicid) AS threads,
				UNIX_TIMESTAMP(MAX(ft.latestentry)) AS updated,
				MAX(ft.topicid) AS newest_topic,
				fc.forumCategoryId AS id,
				MAX(fts.time) AS track_latest
			FROM forumcategory AS fc
			LEFT JOIN forumtopics AS ft
				ON fc.forumcategoryid = ft.forumcategoryid
			LEFT JOIN forumtracks AS fts
				ON ft.topicid = fts.topic_id 
				AND fts.user_id = {$user_id}
			WHERE fc.forumcategoryid IN (".implode(',',$acls).")
			GROUP BY fc.forumcategoryid
			ORDER BY fc.forumcategorysortorder"
		)->result();
		
		// WHERE GREATEST(IFNULL(user_acl.{$right}, 0), IFNULL(default_acl.{$right}, 0)) > 0
				
		if(is_null($last_visit))
			$last_visit = time();
		else
			$last_visit = $this->util->assureTimestamp($last_visit);
			
		foreach($categories as &$cat) {
			$cat->href = '/forum/category/'.$cat->id;
			$cat->classes = array();
			
			if( ! is_null($cat->track_latest)) {
				if($cat->track_latest < $cat->updated)
					$cat->classes[] = 'new';
			} elseif($cat->updated > $last_visit) {
				$cat->classes[] = 'new';
			}
		}
		
		return $categories;
	}
	
	public function get_categories_for_usertype_assoc($usertype = 0) {
		$categories = $this->get_categories_for_usertype($usertype);
		$out = array();
		foreach($categories as $category)
			$out[$category->id] = $category->title;
		return $out;
	}
	
	public function get_categories_for_user_assoc($user_id = 0) {
		$categories = $this->get_categories_for_usertype(0, $user_id);
		$out = array();
		foreach($categories as $category)
			$out[$category->id] = $category->title;
		return $out;
	}
	
	public function acl($user_id, $category_id, $right = 'read') {
		// Kolla först för alla användare, sen för den specifika
		return $this->acl_check(0, $category_id, $right) || $this->acl_check($user_id, $category_id, $right);
	}
	
	protected function acl_check($user_id, $category_id, $right) {
		return $this->db->where(array('user_id' => $user_id, 'category_id' => $category_id, $right => 1))->count_all_results('acl') > 0;
	}
	
	public function get_category_acl($category_id) {
		return $this->db->where('category_id', $category_id)->get('acl')->result();
	}
	
	public function get_default_acl($category_id) {
		$acl = $this->db->where('category_id', $category_id)->where('user_id', 0)->get('acl')->row();
		if( ! isset($acl->user_id))
			$acl = (object) array('user_id' => 0, 'category_id' => $category_id, 'read' => FALSE, 'create' => FALSE, 'reply' => FALSE, 'admin' => FALSE);
		return $acl;
	}
	
	public function get_user_acls($category_id) {
		return $this->db
			->select('acl.*, users.username, users.userid')
			->join('users', 'acl.user_id = users.userid')
			->where('category_id', $category_id)
			->where('user_id !=', 0)
			->get('acl')->result();
	}
	
	public function set_acl($user_id, $category_id, $read = FALSE, $create = FALSE, $reply = FALSE, $admin = FALSE) {
		$this->db->where('category_id', $category_id)->where('user_id', $user_id)->delete('acl');
		if($read)
			$this->db->insert('acl', 
				array(
					'user_id' => $user_id, 
					'category_id' => $category_id,
					'read' => $read,
					'create' => $create,
					'reply' => $reply,
					'admin' => $admin
				)
			);
	}
	
	public function create_topic(stdClass $new_topic) {
		$topic = new stdClass();
		$topic->topicname = $new_topic->title;
		$topic->forumcategoryid = $new_topic->category;
		$topic->topicdate = $this->util->mysql_date();
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
		$post->messagedate = $this->util->mysql_date();
		
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
		$this->db->update('forumcategory', array(
			'forumcategorythreads' => $topic_count, 
			'forumcategorylatestpost' => $latest_post), 
			array('forumcategoryid' => $id));
	}
	
	// Ska byggas bort!
	public function reindex_thread($id, $reindex_category = TRUE) {
		$post_count = $this->count_posts_in_topic($id);
		$latest_post = $this->db->query("SELECT messagedate FROM forummessages WHERE topicid = {$id} ORDER BY messagedate DESC LIMIT 1")->row()->messagedate;
		$latest_poster = $this->db->query("SELECT posterid FROM forummessages WHERE topicid = {$id} ORDER BY messagedate DESC LIMIT 1")->row()->posterid;
		$this->db->update('forumtopics', array('totalentrys' => $post_count, 'latestentry' => $latest_post, 'latestentryby' => $latest_poster), array('topicid' => $id));
		$category_id = $this->db->query("SELECT forumCategoryID AS id FROM forumtopics WHERE topicid = {$id}")->row()->id;
		if($reindex_category)
			$this->reindex_category($category_id);
	}
	
	public function count_posts_in_topic($topic_id) {
		return $this->db->query("SELECT COUNT(*) AS count FROM forummessages WHERE topicid = {$topic_id}")->row()->count;
	}
	
	public function count_topics_in_category($cat_id) {
		return $this->db->query("SELECT COUNT(*) AS count FROM forumtopics WHERE forumcategoryid = {$cat_id}")->row()->count;
	}
	
	public function get_topics_in_category($cat_id, $offset, $limit, $user_id = 0, $last_visit = NULL) {
		$topics = $this->db->query(
			"SELECT 
				f.topicname AS title, 
				f.sticky, 
				f.locked, 
				f.is_event,
				f.is_wiki,
				f.topicid AS id, 
				f.topicdate AS created,
				MIN(fm.messageid) AS first_post,
				COUNT(fm.messageid) - 1 AS replies,
				COUNT(fm.messageid) AS posts,
				UNIX_TIMESTAMP(MAX(fm.messagedate)) AS updated,
				0 AS is_news, 
				creator.username AS creator__username, 
				creator.userid AS creator__userid, 
				creator.deleted AS creator__deleted,
				updater.username AS updater__username, 
				updater.userid AS updater__userid,
				updater.deleted AS updater__deleted,
				fts.time AS track
			FROM forumtopics AS f 
			JOIN users AS creator 
				ON creator.userid = f.topicposterid 
			LEFT JOIN users AS updater 
				ON updater.userid = f.latestentryby 
			JOIN forummessages AS fm
				ON f.topicid = fm.topicid
			LEFT JOIN forumtracks AS fts
				ON f.topicid = fts.topic_id AND fts.user_id = {$user_id}
			WHERE f.forumcategoryid = ".intval($cat_id)." 
			GROUP BY f.topicid
			ORDER BY sticky DESC, latestEntry DESC 
			LIMIT ".intval($offset).", {$limit}"
		)->result();	
		
		if( ! is_null($last_visit))
			$last_visit = $this->util->assureTimestamp($last_visit);		
		
		foreach($topics as &$topic) {
			$this->util->ormify($topic);
			$topic->classes = $topic->actions = array();
			
			if($topic->locked)
				$topic->classes['locked'] = 'locked';
			if($topic->sticky)
				$topic->classes['sticky'] = 'sticky';
			if($topic->is_event)
				$topic->classes['is_event'] = 'is_event';
			if($topic->is_wiki)
				$topic->classes['is_wiki'] = 'is_wiki';
			if($topic->replies == 0)
				$topic->classes['no-replies'] = 'no-replies';
            
			if( ! is_null($topic->track)) {
				if($topic->track < $topic->updated)
					$topic->classes['new'] = 'new';
			} elseif($topic->updated > $last_visit)
				$topic->classes['new'] = 'new';
				
			$this->add_topic_actions($topic);
		}
		
		return $topics;
	}
	
	protected function add_topic_actions(&$topic) {
		if($this->session->isAdmin()) { // || $this->user->userId() == $topic->userid) {
			$topic->actions[] = array('title' => 'Redigera', 'href' => '/forum/edit/'.$topic->first_post, 'class' => 'edit');
			$topic->actions[] = array('title' => 'Radera', 'href' => '/forum/delete/'.$topic->first_post, 'class' => 'delete confirm');				
		}
	}
	
	public function add_track($topic_id, $user_id) {
		$this->db->query("REPLACE INTO forumtracks (topic_id, user_id, time) VALUES ('{$topic_id}', '{$user_id}', '".time()."')");
	}
	
	public function get_posts_for_topic($topic_id, $offset = 0, $limit = 10000) {
		$posts = $this->db->query(
			"SELECT 
				f.message AS body, 
				f.messagedate AS created, 
				f.messageid AS id, 
				u.username, 
				u.userid,
				u.deleted,
				u.hasimage,
				u.ping
			FROM forummessages AS f 
			JOIN users AS u 
				ON u.userid = f.posterid 
			WHERE f.topicid = ".intval($topic_id)." 
			ORDER BY messageid ASC
			LIMIT ".intval($offset).", ".intval($limit)
		)->result();
		$this->add_post_actions($posts);
		return $posts;
	}
	
	private function add_post_actions(&$posts) {
		foreach($posts as &$post) {
			$post->actions = array();
			if($this->session->isAdmin() || $this->session->userId() == $post->userid) {
				$post->actions[] = array('title' => 'Redigera', 'href' => '/forum/edit/'.$post->id, 'class' => 'edit');
				$post->actions[] = array('title' => 'Radera', 'href' => '/forum/delete/'.$post->id, 'class' => 'delete confirm');				
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
			'latestEntry' => 'updated',
			'latestEntryBy' => 'updater',
			'forumCategoryId' => 'category_id',
		);
		$topic = $this->db->query("SELECT ft.*, fc.*, COUNT(fm.messageid) - 1 AS replies, COUNT(fm.messageid) AS posts FROM forumtopics AS ft JOIN forumcategory AS fc ON fc.forumcategoryid = ft.forumcategoryid JOIN forummessages AS fm ON ft.topicid = fm.topicid WHERE ft.topicid = ".intval($topic_id))->row();		
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
	
	public function get_random_topic(Array $categories) {
		$categories = implode(',', $categories);
		return $this->db->query("SELECT topicid FROM forumtopics WHERE forumcategoryid IN ({$categories}) ORDER BY RAND() LIMIT 1")->row()->topicid;
	}
	
	public function delete_post($post_id) {
		$topic_id = $this->topic_id_for_post($post_id);
		$this->db->delete('forummessages', array('messageid' => $post_id));
		$this->reindex_thread($topic_id);
	}
	
	public function post_creator($post_id) {
		return $this->db->where('messageid', $post_id)->get('forummessages')->row()->posterId;
	}
	
	// public function get_latest_posts($usertype = 0, $limit = 20) {
	// 	return $this->db->query(
	// 		"SELECT 
	// 			fm.*, 
	// 			fm.posterid AS userid, 
	// 			fm.topicid AS topicid, 
	// 			UNIX_TIMESTAMP(fm.messagedate) AS timestamp, 
	// 			ft.topicname,
	// 			ft.is_event,
	// 			fc.forumcategoryname,
	// 			fc.forumcategoryid
	// 		FROM forummessages AS fm
	// 		JOIN forumtopics AS ft ON fm.topicid = ft.topicid
	// 		JOIN forumcategory AS fc ON ft.forumcategoryid = fc.forumcategoryid
	// 		WHERE fc.forumsecuritylevel <= {$usertype}
	// 		ORDER BY fm.messagedate DESC 
	// 		LIMIT {$limit}")->result();
	// }
	
	public function get_latest_posts_by_categories(Array $categories, $limit = 20) {
		$imploded_categories = implode(',', $categories);
		return $this->db->query(
			"SELECT 
				fm.*, 
				fm.posterid AS userid, 
				fm.topicid AS topicid, 
				UNIX_TIMESTAMP(fm.messagedate) AS timestamp, 
				ft.topicname,
				ft.is_event,
				fc.forumcategoryname,
				fc.forumcategoryid
			FROM forummessages AS fm
			JOIN forumtopics AS ft ON fm.topicid = ft.topicid
			JOIN forumcategory AS fc ON ft.forumcategoryid = fc.forumcategoryid
			WHERE fc.forumcategoryid IN({$imploded_categories})
			ORDER BY fm.messagedate DESC 
			LIMIT {$limit}")->result();
	}
	
	public function set_topic_fields($topic_id, Array $fields) {
		$this->db->update('forumtopics', $fields, array('topicid' => $topic_id));
	}
	
	public function set_message_fields($message_id, Array $fields) {
		$this->db->update('forummessages', $fields, array('messageid' => $message_id));
	}
	
	public function set_category($topic_id, $category_id) {
		$this->db->update('forumtopics', array('forumcategoryid' => $category_id), array('topicid' => $topic_id));
	}
	
	public function topic_is_wiki($topic_id) {
		return $this->db->where(array('topicid' => $topic_id, 'is_wiki' => 1))->count_all_results('forumtopics') > 0;
	}
	
	public function add_category($title) {
		$this->db->insert('forumcategory', array('forumcategoryname' => $title));
		return $this->db->insert_id();
	}
}