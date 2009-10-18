<?php 
if( $conn->type == 'mssql' )
	$sql = "select top 1 wisdom from wisebox order by newid()";
else
	$sql = "select wisdom from wisebox order by rand() limit 1";
$wisdom = $conn->execute( $sql );
print rq( $wisdom['wisdom'] );
?>
