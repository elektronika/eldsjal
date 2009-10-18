<?php
session_start( );


$dont_display_header = TRUE;
require_once('header.php');
ob_start( );
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
      "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
</head><body>
<pre>
<?php 

// CLEAR THEM LOGINS THAT HAS INCORRECTLY LOGGED OUT
// DELETE THIS IF IT GETS TO SLOW!

// $conn->execute("update users set online = 0 where userid not in (select userid from seen)"); // Ska bytas bort

$conn->execute("update users set online = 0 where TIMESTAMPDIFF(MINUTE, lastseen, now()) > 10");
// 
// $dbSets = $conn->execute("select userid, lastseen from seen");
// 
// if(!is_array(current($dbSets)))
// 	$dbSets = array($dbSets);
// // print_r($dbSets);
// 	
// foreach( $dbSets as $dbSet ) {
// 	$lastSeen = time() - strtotime($dbSet['lastseen']);
// 	if( $lastSeen > 600 ) {
// 		// print 'mer än 10 minuter har gått, offlinear användare med id '.$dbSet['userid']."\n";
// 		$conn->execute("update users set online = 0 where userid = ".$dbSet['userid']); // Ska bytas bort
// 		$conn->execute("delete from seen where userid = ".$dbSet['userid']); // Ska bytas bort
// 	}
// }
?>
</pre>
</body></html>
