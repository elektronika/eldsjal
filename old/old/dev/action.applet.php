<?php 
if( $_SESSION['userid'] != "" ) {
	if( $conn->type == 'mssql' )
		$sql = "select top 1 message from history where security = 0 and userid <> ".$_SESSION['userid']." order by id desc";
	else
		$sql = "select message from history where security = 0 and userid <> ".$_SESSION['userid']." order by id desc limit 1";
	$history = $conn->execute( $sql );
	$content = $history['message'];
	$history = null;
}
else {
	$content = "inte inloggad";
}
print theme_box('just nu:', $content);