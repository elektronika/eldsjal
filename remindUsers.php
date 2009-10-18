<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>
<?php 
if( $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_SESSION['usertype'] < 2 ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}

// [unsupported] session.timeout=30;

?>
	<tr>
		<td valign="top">	
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>	
		</td>
		<td height="190" valign="top">	
	<?php 

print $_GET['message'];
if( $_GET['mode'] == "remind" ) {
	// $Mail is of type "Persits.MailSender"

	$footer = "______________________________________________________________"."\r\n"."Eldsj&auml;l &auml;r ett community f&ouml;r alla som har ett intresse f&ouml;r "."alternativkonst, vare sig det &auml;r eld, trummor, eller dans, enda kriteriet &auml;r att"."sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det praktiseras."."\r\n"."\r\n"."Du beh&ouml;ver "."inte vara medlem f&ouml;r att ta del av den information som delas ut p&aring; sidan."."Registrera dig om du k&auml;nner att du vill vara en del av denna massiva r&ouml;relse."."Som medlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder och "."filmer samt knyta kontakter landet runt. "."\r\n"."\r\n"."Mycket n&ouml;je! // Eldsj&auml;l"."\r\n"."______________________________________________________________";
	$givenDate = $formatDateTime[$dateAdd['m'][ - 2][time( )]][$vbShortDate];

	//This query does not take in to account when the last lognitime for the users was, but It is tested to work

	$sql = "select email, first_name, last_name, username, password, register_date, lastlogin, userid from users where redirect <> '' and email <> '' and userid not in (select userid from pendingdelete) and lastlogin <= '".$givendate."'";
	$userList = $conn->execute( $sql );
	print "Skickar p&aring;minnelse till:<br>";
	if( $userList ) {
		$userLists = $userList;
		foreach( $userLists as $userList ) {
			$strHost = "192.168.1.10;127.0.0.1;mail.kanzieland.com";
			$Mail->Host = $strHost;
			$Mail->From = "glemme@eldsjal.org";

			// From address

			$Mail->fromName = "Viktor Glemme";

			//Mail.AddAddress "eldskrift-subscribe@eldsjal.org"

			$Mail->AddAddress$userList['email']$userList['first_name']." ".$userList['last_name'];

			// message subject

			$Mail->Subject = "Har du gl&ouml;mt bort oss p&aring; Eldsj&auml;l?";

			// message body

			$Mail->Body = "Hej! Den ".$userList['register_date']." skapade du ett konto f&ouml;r att bli medlem hos oss i alternativkonst-communityn Eldsj&auml;l och sedan dess har det varit m&aring;nga turer, men jag ser att du inte loggat in p&aring; ganska l&auml;nge, sist var ".$userList['lastlogin']."."."\r\n"."\r\n"."Det h&auml;r &auml;r naturligtvis ett automatiskt skrivet brev, men det &auml;r faktiskt en vettig anledning till att jag skickas till dig. Vi som &auml;r medlemmar tycker det &auml;r otroligt tr&aring;kigt med en massa 'sovande' konton som kanske egentligen &auml;r helt d&ouml;da. Det &auml;r dags f&ouml;r oss att f&aring; bekanta oss med dig igen eller att vi stryker ett streck &ouml;ver alltihopa och tar bort ditt konto."."\r\n"."\r\n"."F&ouml;r att skaka liv i de sm&aring; gr&aring; s&aring; skickar vi med dina inloggningsuppgifter l&auml;ngst ner i mailet, v&auml;lkommen tillbaka!"."\r\n"."\r\n"."Om du inte har grejat till ditt konto hos oss inom ca: tv&aring; veckor s&aring; tar vi oss friheten att ta bort det!"."\r\n"."\r\n"."V&auml;nliga h&auml;lsningar, Viktor Glemme @ Eldsj&auml;l"."\r\n"."\r\n"."http://www.eldsjal.org"."\r\n"."Anv&auml;ndarnamn: ".$userList['username']."\r\n"."L&ouml;senord:".$userList['password']."\r\n"."Medlem sedan: ".$userList['register_date']."\r\n"."\r\n".$footer;
			$strErr = "";

			//bSuccess = False
			// catch errors

			$Mail->Send;

			// send message

			if( $err != 0 ) {
				// error occurred

				$message = $message.

				/* don't know how to convert err.Description */;
			}
			else {
				//bSuccess = True

				print "<li>".$userList['username']."</li>";
				$sql = "insert into pendingdelete (userid, pendingdate) values (".$userlist['userid'].", getdate())";

				//response.write(SQL)

				$conn->execute( $sql );
			}
			$Mail->resetAll;

			//      $userList->moveNext;
		}
	}
	else {
		print "Inga nya konton att p&aring;minna!";
	}
	print "<br><br>".$message;
	$sql = "select username, userid from users where email = ''";
	$userList = $conn->execute( $sql );
	if( $userList ) {
		print "Dessa anv&auml;ndare saknar emailadress:<br>";
		$userLists = $userList;
		foreach( $userLists as $userList ) {
			print "<a href=userPresentation.php?userid=".$userList['userid']." class=a2>".$userList['username']."</a><BR>";

			//      $userList->moveNext;
		}
	}
	$userList = null;
}
else {
	$footer = "______________________________________________________________<br>"."Eldsj&auml;l &auml;r ett community f&ouml;r alla som har ett intresse f&ouml;r "."alternativkonst, vare sig det &auml;r eld, trummor, eller dans, enda kriteriet &auml;r att"."sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det praktiseras.<br><br>Du beh&ouml;ver "."inte vara medlem f&ouml;r att ta del av den information som delas ut p&aring; sidan."."Registrera dig om du k&auml;nner att du vill vara en del av denna massiva r&ouml;relse."."Som medlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder och "."filmer samt knyta kontakter landet runt. <br><br>Mycket n&ouml;je! // Eldsj&auml;l<br>"."______________________________________________________________";
	print "Den h&auml;r funktionen sl&aring;r upp alla anv&auml;ndarnamn i databasen som inte har loggat in p&aring; 2 m&aring;nad. Den skickar sedan iv&auml;g ett mail till denne anv&auml;ndare som finns i exemplet nedan. Den visar sedan en lista &ouml;ver anv&auml;ndare som inte har n&aring;gon giltig email, f&ouml;r manuell v&auml;rdering av validitet.<br><br><a href=remindUsers.php?mode=remind class=a2>K&ouml;r &raquo;</a><br><br>";
	print "Hej! Den [userList(register_date)] skapade du ett konto f&ouml;r att bli medlem hos oss i alternativkonst-communityn Eldsj&auml;l och sedan dess har det varit m&aring;nga turer, men jag ser att du inte loggat in p&aring; ganska l&auml;nge, sist var [userList(lastlogin)]."."\r\n"."\r\n"."Det h&auml;r &auml;r naturligtvis ett automatiskt skrivet brev, men det &auml;r faktiskt en vettig anledning till att jag skickas till dig. Vi som &auml;r medlemmar tycker det &auml;r otroligt tr&aring;kigt med en massa 'sovande' konton som kanske egentligen &auml;r helt d&ouml;da. Det &auml;r dags f&ouml;r oss att f&aring; bekanta oss med dig igen eller att vi stryker ett streck &ouml;ver alltihopa och tar bort ditt konto."."\r\n"."\r\n"."F&ouml;r att skaka liv i de sm&aring; gr&aring; s&aring; skickar vi med dina inloggningsuppgifter l&auml;ngst ner i mailet, v&auml;lkommen tillbaka!"."\r\n"."\r\n"."Om du inte har grejat till ditt konto hos oss inom ca: tv&aring; veckor s&aring; tar vi oss friheten att ta bort det!<br><br>V&auml;nliga h&auml;lsningar, Viktor Glemme @ Eldsj&auml;l<br><br>http://www.eldsjal.org<BR>Anv&auml;ndarnamn: [userList(userName)]<BR>L&ouml;senord: [userList(password)]<br>Medlem sedan: [userList(register_Date)]<br><br>".$footer;
}
?>

		</td>
	</tr>
	
	
	
<?php require_once( 'bottomInclude.php' );?>
