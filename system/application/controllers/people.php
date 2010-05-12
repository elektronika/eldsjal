<?php
class People extends MY_Controller {
	public function acl_controller() {
		return $this->session->isLoggedIn();
	}
	
	public function _remap() {
		$this->get_search();
	}
	
    public function get_search() {
		$sort_options = array(
			'lastlogin' => 'Senast inloggad',
			'register_date' => 'Registreringsdatum',
			'username' => 'Användarnamn'
		);
		
		$sort_order = array(
			'lastlogin' => 'desc',
			'register_date' => 'desc',
			'username' => 'asc'
		);
		
		$items = $this->db
			->select("username, last_name, first_name, users.userid, born_month, born_year, born_date, presentation AS body, locationname AS location, hasimage, ping")
			->join('locations', 'city = locationid');
			
		if($this->input->get('faddrade'))
			$items->where('usertype >', 0);
		
		if($this->input->get('online'))
			$items->where('ping >', (time() - $this->settings->get('online_timeout')));
		
		if($city = $this->input->get('city'))
			if($city != 'all')
				$items->where('city', (int) $city);
					
		if($does = $this->input->get('does'))
			if($does != 'anything')
				$items->join('userartlist', 'users.userid = userartlist.userid')->where('artid', (int) $does);
		
		if($sort_by = $this->input->get('sort_by')) {
			if(in_array($sort_by, array_keys($sort_options)))
				$items->order_by($sort_by, $sort_order[$sort_by]);
			else
				$items->order_by('lastlogin DESC');				
		} else {
			$items->order_by('lastlogin DESC');
		}
		
		if($query = $this->input->get('query'))
			$items->like('username', $query)->or_like('first_name', $query)->or_like('last_name', $query);
			
		$items = $items->where('deleted', 0)->get('users', 20)->result();
		
		// Om man bara hittar en person så kan man lika gärna visa den. Lika bra, fast bättre.
		if(count($items) == 1)
			$this->redirect('/user/'.current($items)->userid);
			
		foreach($items as &$item) {
			$item->body = truncate(remove_tags($item->body), 110);
			$item->birthday = mktime(0, 0, 0, $item->born_month, $item->born_date, $item->born_year);
			$item->username = $item->first_name.' "'.$item->username.'" '.$item->last_name;
			$item->online = ($item->ping > (time() - $this->settings->get('online_timeout')));
		}
		
		$locations = $this->models->location->get_all_assoc();
		$tags = $this->models->tag->get_all_assoc();
		
		$this->view->before = form_open('/people/search', array('method' => 'get'))
			.input('text', 'query', 'Namn/användarnamn', $this->input->get('query'))
			.form_label('Stad', 'city')
			.form_dropdown('city', array('all' => 'Alla') + $locations, $this->input->get('city'))
			.form_label('Sysslar med', 'does')
			.form_dropdown('does', array('anything' => 'Vad som helst') + $tags, $this->input->get('does'))
			.form_label('Sortera efter', 'sort_by')
			.form_dropdown('sort_by', $sort_options, $this->input->get('sort_by'))
			.form_label(form_checkbox('online', 1, $this->input->get('online')).'Visa bara folk som är online', 'does')
			.form_label(form_checkbox('faddrade', 1, $this->input->get('faddrade')).'Visa bara folk som har en fadder', 'faddrade')
			.submit('GE MIG DOM!')
			.form_close();
					
		$this->view->template = 'list';
		$this->view->page_title = 'Folk';
		$this->view->item_function = 'userlist_item';
		$this->view->items = $items;
		
		$texts = array('spanar in potentiella ragg', 'letar folk', 'gräver i medlemslistan');
		$this->util->trail($texts[array_rand($texts)]);
    }
}