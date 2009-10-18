<?php 

$sql = "select gender, first_name, username, last_name, born_year, born_month, born_date from users where userid = ".$_GET['userid'];
$dbUser = $conn->execute( $sql );

///////////// &Aring;ldersber&auml;kning ////////////////////

$birthdate = mktime( 0, 0, 0, $dbUser['born_month'], $dbUser['born_date'], $dbUser['born_year'] );
$diff = time( ) - $birthdate;
$age = $diff / ( 3600 * 24 );
$age = round( $age / 365, 1 );

//////////////////////////////////////////////////

if( $dbUser['first_name'] != $dbUser['username'] ) {
	print $dbUser['first_name']." <b>'".$dbUser['username']."'</b> ".$dbUser['last_name'].", ";
}
else {
	print "<b>".$dbUser['username']."</b> ".$dbUser['last_name'].", ";
}
if( $dbUser['gender'] == 0 ) {
	print "kille, ".$age." &aring;r";
}
else {
	print "tjej, ".$age." &aring;r";
}

//response.write(dbUser("city"))

?>
