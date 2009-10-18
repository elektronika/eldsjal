<?php
//session_start();

session_register( "userid_session" );
?>
<?php 
if( $_SESSION['userid'] != "" ) {
	if( $conn->type == 'mssql' )
		$sql = "select top 1 message from history where security = 0 and userid <> ".$_SESSION['userid']." order by id desc";
	else
		$sql = "select message from history where security = 0 and userid <> ".$_SESSION['userid']." order by id desc limit 1";
	$history = $conn->execute( $sql );
	print $history['message'];
	$history = null;
}
else {
	print "inte inloggad";
}
?>
