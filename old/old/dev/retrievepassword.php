<?php
session_start( );






require_once( 'header.php' );?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );?>	
	</td>

		<td width="448" height="190"><?php if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}?><img src="images/nyhet1.gif" width="468" height="189">
<?php if( $_GET['mode'] == "remind" ) {
	if( $_POST['email'] == "" ) {
		$reponse->redirect( "retrievePassword.php?message=Ingen email angiven, f&ouml;rs&ouml;k igen!" );
	}
	$email = cq( $_POST['email'] );
	$sql = "select username, password, first_name, last_name from users where email = '".$email."'";
	$remind = $conn->execute( $sql );
	if( $remind ) {
		header( "Location: "."retrievePassword.php?message=Det finns ingen medlem med den emailen h&auml;r, skrev du kanske fel?" );
	}
	else {
		$strHost = "127.0.0.1;mail.eldsjal.org";

		// $Mail is of type "Persits.MailSender"
		// enter valid SMTP host

		$Mail->Host = $strHost;
		$Mail->From = "glemme@eldsjal.org";

		// From address

		$Mail->FromName = "Eldsj&auml;l";
		$Mail->AddAddress$email$remind['first_name']." ".$remind['last_name'];

		// message subject

		$Mail->Subject = "Dina inloggningsuppgifter p&aring; www.eldsjal.org!";

		// message body

		$Mail->Body = "Hejsan!"."\r\n"."N&aring;gon, f&ouml;rhoppningsvis du, har beg&auml;rt att bli p&aring;mind om inloggningsuppgifterna som finns registrerade till denna email p&aring; www.eldsjal.org. Med hj&auml;lp av dessa kommer du att kunna logga in igen."."\r\n"."\r\n"."Det var allt f&ouml;r denna g&aring;ng, fridens liljor!"."\r\n"."\r\n"."Mvh. Eldsj&auml;l!"."\r\n"."\r\n"."Inloggningsuppgifter till http://www.eldsjal.org/ "."\r\n"."Anv&auml;ndarnamn: ".$remind['username']."\r\n"."L&ouml;senord: ".$remind['password'];
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
			$message = "Ett mail har nu skickats till ".$email." med uppgifterna!";
		}
		$mail->reseAll;
		header( "Location: "."main.php?message=".$message );
	}
	$remind = null;
}
else {
	?>
		<div class="plainThead2">
		Slarvat bort ditt l&ouml;senord?
		</div>
		<br/>
		<div class="plainText">
			
			<br/> <br/>
	        Titt som t&auml;tt gl&ouml;mmer man vad man hade f&ouml;r l&ouml;senord, vad man hette osv. det &auml;r trots allt m&aring;nga
	        sajter och m&aring;nga grejer att h&aring;lla i huvudet. Men det &auml;r bara att ta det kallt, r&auml;ddningen &auml;r n&auml;ra!
	        Allt som beh&ouml;vs &auml;r att stoppa in den emailaddress du angav n&auml;r du skapade ditt konto i l&aring;dan nedan
	        s&aring; kommer dina kontouppgifter att skickas till dig inom n&aring;gra minuter.
	        <br/> <br/>
			<form name="remind" action="retrievePassword.php?mode=remind" method="post">
			email: <input type="text" name="email"/>
			<input type="image" src="right.gif" name="submit"/>
			</form>
			
		</div><br/>
<?php
}?>
		</td>
		
		
		<td>
		
		<!-- BOXAR -->

		</td>
	</tr>
<?php require_once( 'footer.php' );?>
