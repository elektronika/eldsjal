<?php
class Usermenu extends Widget {
	public function run() {		
		$this->items = array();

		$this->items[] = (object) array('href' => '/user/'.$this->session->userid(), 'title' => 'Hem', 'class' => 'home');
		$this->items[] = (object) array('href' => '/guestbook/view/'.$this->session->userid(), 'title' => 'Gästbok'.$this->alert_counter('guestbook'), 'class' => $this->alert_counter('guestbook') ? 'guestbook new' : 'guestbook');
		$this->items[] = (object) array('href' => '/messages', 'title' => 'Meddelanden'.$this->alert_counter('message'), 'class' => $this->alert_counter('message') ? 'messages new' : 'messages');
		
		$this->items[] = (object) array('href' => '/people', 'title' => 'Folk', 'class' => 'people');
		$this->items[] = (object) array('href' => '/thoughts', 'title' => 'Tankar', 'class' => 'thoughts');

		if($this->acl->check($this->settings->get('fadder_category'))) {
			$pending = $this->db->query("select count(userid) as users from users where usertype = 0 and email <> ''")->row()->users;
			$this->items[] = (object) array('href' => '/userAdmin.php', 'title' => 'Ny medlem'.$this->counter($pending), 'class' => 'fadder');
			
			$adoption = $this->db->query("select count(pendingadoptionid) as count from pendingadoption where parentuserid = ".$this->session->userid())->row()->count;
			if($adoption > 0)
				$this->items[] = (object) array('href' => '/parentHood.php', 'title' => 'Fadderbarn'.$this->counter($adoption, 'adoption'), 'class' => 'fadderbarn');
		}

		if($this->acl->check($this->settings->get('wisdom_category')))
			$this->items[] = (object) array('href' => '/admin/wisdom', 'title' => 'Visheter', 'class' => 'wisdom');

		if($this->session->isAdmin()) {
			$this->items[] = (object) array('href' => '/admin/settings', 'title' => 'Inställningar', 'class' => 'admin-settings');
			$this->items[] = (object) array('href' => '/admin/board', 'title' => 'Rättigheter', 'class' => 'admin-permissions');
			$this->items[] = (object) array('href' => '/admin/log', 'title' => 'Logg'.$this->alert_counter('log'), 'class' => 'admin-log');			
			$this->items[] = (object) array('href' => '/admin/massmail', 'title' => 'Massmail', 'class' => 'admin-massmail');			
			$this->items[] = (object) array('href' => '/admin/messages', 'title' => 'Systemmeddelanden', 'class' => 'admin-messages');			
			$this->items[] = (object) array('href' => '/admin/flushall', 'title' => 'Flusha alla', 'class' => 'admin-flushall');			
			$this->items[] = (object) array('href' => '/admin/console', 'title' => 'SQL-konsol', 'class' => 'admin-console');			
		}

		$this->items[] = (object) array('href' => '/user/'.$this->session->userid().'/edit', 'title' => 'Inställningar', 'class' => 'settings');
		$this->items[] = (object) array('href' => '/logout', 'title' => 'Logga ut', 'class' => 'logout');
	}

	protected function counter($number, $type = 'random') {
		return " <span class='counter' id='alert-counter-{$type}'>".($number > 0 ? "($number)" : '').'</span>';
	}

	protected function alert_counter($type) {
		return $this->counter($this->alerts->count($type), $type);
	}
}