<?php ob_start( );
$strHost = "192.168.1.11;mail.eldsjal.org;morrison.kanzieland.com;127.0.0.1;";

// $Mail is of type "Persits.MailSender"
// enter valid SMTP host

$Mail->Host = $strHost;
$Mail->From = "eldsjal@eldsjal.org";
$Mail->FromName = $_POST['member'];
$Mail->Addaddress$application['adminemail'];

// message subject

$Mail->Subject = "(ELDSJ&Auml;L) ".$_POST['subject'];

// message body

$Mail->Body = "Fr&aring;n: ".$_POST['email']."\r\n"."\r\n".$_POST['message'];
$strErr = "";
$bSuccess = false;

// catch errors

$Mail->Send;

// send message

if( $err != 0 ) {
	// error occurred

	$message =

	/* don't know how to convert err.Description */;
}
else {
	$bSuccess = true;
}
if( $bSuccess ) {
	print "SKICKAT";
}
else {
	header( "Location: "."main.php?message=FEL: ".$message );
}
?>
