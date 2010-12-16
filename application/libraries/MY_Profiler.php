<?php
class MY_Profiler extends CI_Profiler {
	protected $custom_data = array();
	
	public function __construct() {
		parent::CI_profiler();
	}
	
	public function add_data($section, $data) {
		$this->custom_data[$section][] = $data;
	}
	
	function _compile_custom_data() {
		ob_start();
		foreach($this->custom_data as $section => $data): ?>
		
			<fieldset style="border:1px solid #555;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">
			<legend style="color:#555;">&nbsp;&nbsp;<?php print $section; ?>&nbsp;&nbsp;</legend>
			<?php if(is_array(current($data))): ?>
				<table>
				<tr>
				<?php foreach(current($data) as $field => $value): ?>
					<th><?php print $field?></th>
				<?php endforeach; ?>
				</tr>
				<?php foreach($data as $row): ?>
					<tr>
						<?php foreach($row as $field => $data): ?>
							<td><?php print $data; ?></td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php else: ?>
				<?php foreach($data as $line): ?>
					<div style='color:#000;font-weight:normal;padding:4px 0 4px 0'><?php print $line; ?></div>
				<?php endforeach; ?>
			<?php endif; ?>
			</fieldset>
		
		<?php endforeach;
		return ob_get_clean();
	}
	
	/**
	 * Run the Profiler
	 *
	 * @access	private
	 * @return	string
	 */	
	public function run()
	{
		$output = "<div id='codeigniter_profiler' style='clear:both;background-color:#fff;padding:10px;'>";

		$output .= $this->_compile_uri_string();
		$output .= $this->_compile_controller_info();
		$output .= $this->_compile_memory_usage();
		$output .= $this->_compile_benchmarks();
		$output .= $this->_compile_get();
		$output .= $this->_compile_post();
		$output .= $this->_compile_queries();
		$output .= $this->_compile_custom_data();

		$output .= '</div>';

		return $output;
	}
}