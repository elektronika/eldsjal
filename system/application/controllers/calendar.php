<?php
class Calendar extends Controller {

    function __construct() {
        parent::Controller();
		$this->load->model('event');
		$this->load->model('location');
		// $this->output->enable_profiler(TRUE);
    }

    function get_index() {
		$upcoming = $this->event->get_upcoming(5);
		$attending = $this->event->get_upcoming_by_attendance($this->user->userId());
		
		$this->dwootemplate->assign('upcoming', $upcoming);
		$this->dwootemplate->assign('attending', $attending);
    	$this->dwootemplate->display('calendar_index.tpl');
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

		$events = $this->event->get_interval($timestamp_start, $timestamp_end);
		$events = $this->event->group_by_month($events);
		foreach($events as &$month)
			$month = $this->event->group_by_day($month);
		
		$this->dwootemplate->assign('events', $events);
		$this->dwootemplate->assign('year', $year);
		$this->dwootemplate->display('calendar_year.tpl');		
	}
	
	function get_month($year, $month) {
		$timestamp_start = $this->util->timestamp_start($year, $month);
		$timestamp_end = $this->util->timestamp_end($year, $month);

		$events = $this->event->get_interval($timestamp_start, $timestamp_end);
		$events = $this->event->group_by_day($events);
		
		$this->dwootemplate->assign('events', $events);
		$this->dwootemplate->assign('year', $year);
		$this->dwootemplate->assign('month', $month);
		$this->dwootemplate->display('calendar_month.tpl');		
	}
	
	function get_day($year, $month, $day) {
		$timestamp_start = $this->util->timestamp_start($year, $month, $day);
		$timestamp_end = $this->util->timestamp_end($year, $month, $day);

		$events = $this->event->get_interval($timestamp_start, $timestamp_end);
		
		$this->dwootemplate->assign('events', $events);
		$this->dwootemplate->assign('year', $year);
		$this->dwootemplate->assign('month', $month);
		$this->dwootemplate->assign('day', $day);
		$this->dwootemplate->display('calendar_day.tpl');		
	}

	function get_upcoming() {
		$events = $this->event->get_upcoming();
		
		$this->dwootemplate->assign('events', $events);
		$this->dwootemplate->display('calendar_upcoming.tpl');
	}
	
	function get_view($event_id) {
		$event = $this->event->get_by_id($event_id);
		unset($event->href); // Så eventet inte visas med länk till sig själv
		$attendees = $this->event->get_attendees($event_id);
		$user_has_signed_up = $this->event->user_has_signed_up($this->user->userId(), $event_id);
		
		$this->dwootemplate->assign('user_has_signed_up', $user_has_signed_up);
		$this->dwootemplate->assign('event', $event);
		$this->dwootemplate->assign('attendees', $attendees);
		$this->dwootemplate->display('calendar_view.tpl');
	}
	
	function get_new() {
		$locations = $this->location->get_all();
		$this->dwootemplate->assign('form_action', '/calendar/new');
		$this->dwootemplate->assign('locations', $locations);
		$this->dwootemplate->display('calendar_handle.tpl');
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
		$this->load->helper('url');
				
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Beskrivning', 'trim|xss_clean|required');
		$this->form_validation->set_rules('date', 'Datum', 'trim|xss_clean|required|integer');
		$this->form_validation->set_rules('location', 'Datum', 'trim|xss_clean|required|integer');
		$this->form_validation->set_message('required', 'Glöm inte att fylla i "%s", din lille spelevink.');
				
		if($this->form_validation->run() == FALSE) {
			$this->$action($event_id);
		} else {
			// Spara skrotet
			$new_event = new stdClass();
			$new_event->title = $this->input->post('title');
			$new_event->body = $this->input->post('body');
			$new_event->date = $this->input->post('date') / 1000;
			$new_event->location = $this->input->post('location');
			$new_event->creator = $this->user->userId();

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
			
			redirect('/calendar/view/'.$event_id);
		}
	}
	
	function acl_new() {
		return $this->user->isLoggedIn();
	}
	
	function get_edit($event_id) {
		$event = $this->event->get_by_id($event_id);
		$locations = $this->location->get_all();
		
		$this->dwootemplate->assign('form_action', '/calendar/edit/'.$event_id);
		$this->dwootemplate->assign('event', $event);
		$this->dwootemplate->assign('locations', $locations);		
		$this->dwootemplate->display('calendar_handle.tpl');
	}
	
	function post_edit($event_id) {
		$this->_event_handle($event_id);
	}
	
	function acl_edit($event_id) {
		return $this->user->isLoggedIn(); // Men ska såklart checka mer sen.
	}
	
	function get_history() {
		$this->dwootemplate->display('calendar_history.tpl');
	}
	
	function acl_history() {
		return $this->user->isLoggedIn();
	}
	
	function post_signup($event_id) {
		$this->event->signup($event_id, $this->user->userId());
		$this->load->helper('url');
		redirect('/calendar/view/'.$event_id);
	}
	
	function acl_signup() {
		return $this->user->isLoggedIn();
	}
	
	function post_signoff($event_id) {
		$this->event->signoff($event_id, $this->user->userId());
		$this->load->helper('url');
		redirect('/calendar/view/'.$event_id);		
	}
	
	function acl_signoff() {
		return $this->user->isLoggedIn();
	}
}