<?php
ob_implicit_flush(true);
require_once 'topInclude.php';
print '<td colspan="3">';
if( $conn->type == 'mssql' )
	die('Nope, funkar inte med mssql');
$tables = $conn->execute('SHOW TABLES');

foreach ($tables as $table)
	$t[] = current($table);

$tables = $t;

foreach ($tables as $table) {
	set_time_limit(600);
	// rename table
	$old_name = $table;
	$new_name = str_replace('_', '', strtolower($table));
	print '<h2>'.$old_name.' -&gt; '.$new_name.'</h2>';
	flush();
	if( $table != strtolower(str_replace('_', '', $table))) {
 		$conn->execute('RENAME TABLE '.$table.' TO _'.strtolower($table));
		$table = '_'.strtolower($table);
		$conn->execute('RENAME TABLE '.$table.' TO '.str_replace('_', '', $table));
		$table = str_replace('_', '', $table);
	}
	
	//rename fields
	$fields = $conn->execute('SHOW COLUMNS FROM '.$table);
	// print '<pre>';
	// 	print_r($fields);
	// 	print '</pre>';
	foreach($fields as $field) {
		$old_name = $field['Field'];
		$new_name = str_replace('_', '', strtolower($field['Field']));
	 	$sql = 'ALTER TABLE '.$table.' CHANGE '.$field['Field'].' '.strtolower($field['Field']).' '.$field['Type'].' '.$field['Extra'];
		//print $sql;
		$conn->execute($sql);
		print '<h3>'.$old_name.' -&gt; '.$new_name.'</h3>';
		flush();
 	}
}

print '<h1>Nu vare konverterat!</h1>';
print '</td>';
require_once 'bottomInclude.php';
?>