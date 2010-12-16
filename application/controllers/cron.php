<?php
class Cron extends Controller {
	public function __construct() {
		parent::Controller();
	}
	
	public function get_hourly($key = '') {
		$this->cron_event('hourly', $key);
	}
	
	public function get_daily($key = '') {
		$this->cron_event('daily', $key);
	}
	
	public function get_weekly($key = '') {
		$this->cron_event('weekly', $key);
	}
	
	protected function cron_event($period, $key) {
		if($this->key_is_valid($key))
			$this->event->trigger('cron_'.$period);
		else
			show_error('Sorry, access key not valid');
	}
	
	protected function key_is_valid($key) {
		return $this->settings->get('cron_key') == $key;
	}
}