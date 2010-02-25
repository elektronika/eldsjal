<?php
class Usermenu extends Widget {
	public function run() {
		$this->items = array();
		
		$this->items[] = (object) array('href' => '/userPresentation.php?userid='.$this->session->userid(), 'title' => 'Hem', 'class' => 'home');
		
		$gb_count = $this->db->query("SELECT COUNT(unread) AS count FROM guestbook WHERE touserid = ".$this->session->userId()." AND unread = 1")->row()->count;
		$this->items[] = (object) array('href' => '/guestbook.php?userid='.$this->session->userid(), 'title' => 'Gästbok'.$this->counter($gb_count), 'class' => $gb_count ? 'guestbook new' : 'guestbook');
		
		$msg_count = $this->db->query("SELECT COUNT(readmessage) AS count FROM messages WHERE userid = ".$this->session->userId()." AND readmessage = 0")->row()->count;
		$this->items[] = (object) array('href' => '/messages.php?userid='.$this->session->userid(), 'title' => 'Meddelanden'.$this->counter($msg_count), 'class' => $msg_count ? 'messages new' : 'messages');
		$this->items[] = (object) array('href' => '/forum', 'title' => 'Forum', 'class' => 'forum');		
		$this->items[] = (object) array('href' => '/gallery.php', 'title' => 'Galleri', 'class' => 'gallery');		
		$this->items[] = (object) array('href' => '/members.php', 'title' => 'Folk', 'class' => 'people');
		$this->items[] = (object) array('href' => '/thoughts', 'title' => 'Tankar', 'class' => 'thoughts');
		
		$event_count = $this->db->query("SELECT COUNT(calendarnotifyid) AS count FROM calendarnotify WHERE userid = ".$this->session->userId())->row()->count;
		$this->items[] = (object) array('href' => '/calendar', 'title' => 'Kalender'.$this->counter($event_count), 'class' => $event_count ? 'events new' : 'events');

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
		if($this->session->isAdmin()) {
			$this->items[] = (object) array('href' => '/admin/settings', 'title' => 'Inställningar', 'class' => 'admin-settings');
			$this->items[] = (object) array('href' => '/admin/board', 'title' => 'Rättigheter', 'class' => 'admin-permissions');
			$logs = $this->db->query('SELECT COUNT(*) AS count FROM log')->row()->count;
			$this->items[] = (object) array('href' => '/admin/log', 'title' => 'Logg'.$this->counter($logs), 'class' => 'admin-log');			
		}
			
		$this->items[] = (object) array('href' => '/userEdit.php?mode=editAccount&userid='.$this->session->userid(), 'title' => 'Inställningar', 'class' => 'settings');
		$this->items[] = (object) array('href' => '/logout', 'title' => 'Logga ut', 'class' => 'logout');
	}
	
	protected function counter($number) {
		return $number > 0 ? " <span class='counter'>($number)</span>" : '';
	}
}