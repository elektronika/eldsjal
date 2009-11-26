<?php
class Calendar extends MY_Controller {
	function get_index() {
		$this->upcoming = $this->models->event->get_upcoming(5);
		$this->attending = $this->models->event->get_upcoming_by_attendance($this->session->userId());
    }

	function get_browse($year = NULL, $month = NULL, $day = NULL) {
		if( ! is_null($year)) {
			if( ! is_null($day))
				$this->get_day($year, $month, $day);
			elseif( ! is_null($month))
				$this->get_month($year, $month);
			else
				$this->get_year($year);
		}
		else
			$this->get_upcoming();
	}

	function get_year($year) {
		$timestamp_start = $this->util->timestamp_start($year);
		$timestamp_end = $this->util->timestamp_end($year);

		$this->events = $this->models->event->get_interval($timestamp_start, $timestamp_end);
		$this->events = $this->models->event->group_by_month($this->events);
		foreach($this->events as &$month)
			$month = $this->models->event->group_by_day($month);
		
		$this->year = $year;
		$this->template = 'calendar_year.tpl';
	}
	
	function get_month($year, $month) {
		$timestamp_start = $this->util->timestamp_start($year, $month);
		$timestamp_end = $this->util->timestamp_end($year, $month);

		$this->events = $this->models->event->get_interval($timestamp_start, $timestamp_end);
		$this->events = $this->models->event->group_by_day($this->events);
		
		$this->year = $year;
		$this->month = $month;
		
		$this->template = 'calendar_month.tpl';
	}
	
	function get_day($year, $month, $day) {
		$timestamp_start = $this->util->timestamp_start($year, $month, $day);
		$timestamp_end = $this->util->timestamp_end($year, $month, $day);

		$this->events = $this->models->event->get_interval($timestamp_start, $timestamp_end);
		
		$this->year = $year;
		$this->month = $month;
		$this->day = $day;
		
		$this->template = 'calendar_day.tpl';
	}

	function get_upcoming() {
		$this->events = $this->models->event->get_upcoming();
	}
	
	function get_view($event_id) {
		$this->event = $this->models->event->get_by_id($event_id);
		unset($this->event->href); // Så eventet inte visas med länk till sig själv
		$this->attendees = $this->models->event->get_attendees($event_id);
		$this->user_has_signed_up = $this->models->event->user_has_signed_up($this->session->userId(), $event_id);
		if( ! is_null($this->event->topic_id))
			$this->posts = $this->models->forum->get_posts_for_topic($this->event->topic_id);
		$this->user_can_comment = $this->session->isLoggedIn();
		$this->models->event->delete_notifications($event_id, $this->session->userid());
	}
	
	function post_view($event_id) {
		$this->event = $this->models->event->get_by_id($event_id);
		
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Men du, är det så bra med tomma inlägg, egentligen?');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_view($event_id);
		} else {
			$new_reply = (object) $this->input->post_array(array('body', 'title'));
			$new_reply->userid = $this->session->userId();
			if( ! is_null($this->event->topic_id) && $this->event->topic_id != 0) {
				$new_reply->topicid = $this->event->topic_id;
				$this->models->forum->create_post($new_reply);				
			} else {
				$new_reply->category = 21;
				$new_reply->userid = $this->session->userid();
				$topic_id = $this->models->forum->create_topic($new_reply);
				$this->models->event->set_topic_id($event_id, $topic_id);
			}
			$this->session->message('Inlägg sparat. Yay!');
			$this->redirect('/calendar/view/'.$event_id);
		}
	}
	
	function get_new() {
		$this->locations = $this->location->get_all();
		$this->form_action = '/calendar/new';
		$this->template = 'calendar_handle.tpl';
	}
	
	function post_new() {
		$this->_event_handle();
	}
	
	function _event_handle($event_id = 0) {
		$action = ($event_id == 0) ? 'get_new' : 'get_edit';
		
		$config['upload_path'] = './tmp_upload/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);
		$this->load->library('image_lib');
				
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Beskrivning', 'trim|xss_clean|required');
		$this->form_validation->set_rules('date', 'Datum', 'trim|xss_clean|required|integer');
		$this->form_validation->set_rules('location', 'Datum', 'trim|xss_clean|required|integer');
		$this->form_validation->set_message('required', 'Glöm inte att fylla i "%s", din lille spelevink.');
				
		if($this->form_validation->run() == FALSE) {
			$this->$action($event_id);
		} else {
			// Spara skrotet
			$new_event = (object) $this->input->post_array(array('title', 'body', 'location'));
			$new_event->date = $this->input->post('date') / 1000;
			$new_event->creator = $this->session->userId();

			if($event_id != 0)
				$new_event->id = $event_id;
			
			$event_id = $this->event->save($new_event);

			// Ladda upp bilden
			if( ! $this->upload->do_upload('file') ) {
				$this->dwootemplate->assign('upload_errors', $this->upload->display_errors());
			} else {
				$upload_data = $this->upload->data();
				$error = '';
				
				$original_file = $this->util->setting('event_image_folder').$event_id.$upload_data['file_ext'];
				rename($upload_data['full_path'], $original_file);

				$image_size = getimagesize($original_file);
				// 0 = width, 1 = height
				$resize_axis = $image_size[0] > $image_size[1] ? 'height' : 'width';
				$other_axis = $resize_axis == 'height' ? 'width' : 'height';
				
				// Dona thumbnailen
				$config = array(
					'source_image' => $original_file,
					'maintain_ratio' => TRUE,
					'new_image' => $this->util->setting('event_image_folder').'tn_'.$event_id.'.'.$this->util->setting('default_image_extension'),
					$resize_axis => 100,
					$other_axis => 300
				);
				$this->image_lib->initialize($config);
				if( ! $this->image_lib->resize()) {
					$error .= $this->image_lib->display_errors();
				}
				
				$this->event->flag_as_having_image($event_id);
			}
			
			$this->redirect('/calendar/view/'.$event_id);
		}
	}
	
	function acl_new() {
		return $this->session->isLoggedIn();
	}
	
	function get_edit($event_id) {
		$this->event = $this->models->event->get_by_id($event_id);
		$this->locations = $this->location->get_all();		
		$this->form_action = '/calendar/edit/'.$event_id;
		$this->template = 'calendar_handle.tpl';
	}
	
	function post_edit($event_id) {
		$this->_event_handle($event_id);
	}
	
	function acl_edit($event_id) {
		return $this->session->isLoggedIn(); // Men ska såklart checka mer sen.
	}
	
	function get_history() {
		$this->dwootemplate->display('calendar_history.tpl');
	}
	
	function acl_history() {
		return $this->session->isLoggedIn();
	}
	
	function post_signup($event_id) {
		$this->models->event->signup($event_id, $this->session->userId());
		$this->redirect('/calendar/view/'.$event_id);
	}
	
	function acl_signup() {
		return $this->session->isLoggedIn();
	}
	
	function post_signoff($event_id) {
		$this->models->event->signoff($event_id, $this->session->userId());
		$this->redirect('/calendar/view/'.$event_id);		
	}
	
	function acl_signoff() {
		return $this->session->isLoggedIn();
	}
}