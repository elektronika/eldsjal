<?php
class Usermenu extends Widget {
	public function run() {
		$this->items = array();
		
		$this->items[] = (object) array('href' => '/userPresentation.php?userid='.$this->session->userid(), 'title' => 'Hem', 'class' => 'home');
		
		$gb_count = $this->models->alert->count_gb();
		$this->items[] = (object) array('href' => '/guestbook.php?userid='.$this->session->userid(), 'title' => 'Gästbok'.$this->counter($gb_count), 'class' => $gb_count ? 'guestbook new' : 'guestbook');
		
		$msg_count = $this->models->alert->count_mess();
		$this->items[] = (object) array('href' => '/messages.php?userid='.$this->session->userid(), 'title' => 'Meddelanden'.$this->counter($msg_count), 'class' => $msg_count ? 'messages new' : 'messages');
		
		$this->items[] = (object) array('href' => '/diary.php?userid='.$this->session->userid(), 'title' => 'Tankar', 'class' => 'thoughts');
		
		$event_count = $this->models->alert->count_event();
		$this->items[] = (object) array('href' => '/calendarView.php?mode=userList', 'title' => 'Aktiviteter'.$this->counter($event_count), 'class' => $event_count ? 'events new' : 'events');

		if($this->session->hasPrivilege('useradmin')) {
			$pending = $this->db->query("select count(userid) as users from users where usertype = 0 and email <> '' and userid not in (select userid from pendingdelete)")->row()->users;
			$this->items[] = (object) array('href' => '/userAdmin.php', 'title' => 'Ny medlem'.$this->counter($pending), 'class' => 'fadder');
			
			if($this->db->query('select count(userid) as number from users where approvedby = '.$this->session->userid())->row()->number > 0) {
				$adoption = $this->db->query("select count(pendingadoptionid) as count from pendingadoption where parentuserid = ".$this->session->userid())->row()->count;
				$this->items[] = (object) array('href' => '/parentHood.php', 'title' => 'Fadderbarn'.$this->counter($adoption), 'class' => 'fadderbarn');
			}
		}
		
		if($this->session->hasPrivilege('wisdomadmin'))
			$this->items[] = (object) array('href' => '/insertWisdom.php', 'title' => 'Visheter', 'class' => 'wisdom');						
			
		$this->items[] = (object) array('href' => '/userEdit.php?mode=editAccount&userid='.$this->session->userid(), 'title' => 'Inställningar', 'class' => 'settings');
		$this->items[] = (object) array('href' => '/logout', 'title' => 'Logga ut', 'class' => 'logout');
	}
	
	protected function counter($number) {
		return $number > 0 ? " <span class='counter'>($number)</span>" : '';
	}
}