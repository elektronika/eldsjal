<?php
	session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "username_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
session_register( "username_session" );
session_register( "usertype_session" );
ob_start();
?>
<?php  require_once( 'topInclude.php' );?>
	<tr>
		<td valign="top">
		<div class="boxLeft">
		<?php  require_once( 'toolbox.applet.php' );?>
		</div>		
		<div class="boxLeft">
		<h3 class="boxHeader">
		Visheter:</h3>
		<h4 class="boxContent">
			<?php  require_once( 'wiseBox.applet.php' );?>
		</h4>
		</div>
		<div class="boxLeft">
		<h3 class="boxHeader">
		nya tankar:</h3>
		<h4 class="boxContent">
			<?php  require_once( 'diarys.applet.php' );?>
		</h4>
		</div>	
		<div class="boxLeft">
		<h3 class="boxHeader">
		senast inloggade:</h3>
		<h4 class="boxContent">
			<?php  require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>	
		</td>
<script LANGUAGE="JavaScript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}
</script>
		<td height="190" valign="top">	
		<?php
	
	if( isset( $_GET['message'] ) ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
?>
		<?php
	
	if( $_SESSION['usertype'] < $application['useradmin'] ) {
	header( "Location: "."main.php?message=Du har inte r&auml;ttigheter att g&ouml;ra detta" );
}

//application("userAdmin")

if( isset( $_GET['mode'] ) && $_GET['mode'] == "remind" ) {

	// $Mail is of type "Persits.MailSender"

	$footer = "______________________________________________________________"."\r\n"."Eldsj&auml;l &auml;r ett community f&ouml;r alla som har ett intresse f&ouml;r "."alternativkonst, vare sig det &auml;r eld, trummor, eller dans, enda kriteriet &auml;r att"."sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det praktiseras."."\r\n"."\r\n"."Du beh&ouml;ver "."inte vara medlem f&ouml;r att ta del av den information som delas ut p&aring; sidan."."Registrera dig om du k&auml;nner att du vill vara en del av denna massiva r&ouml;relse."."Som medlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder och "."filmer samt knyta kontakter landet runt. "."\r\n"."\r\n"."Mycket n&ouml;je! // Eldsj&auml;l"."\r\n"."______________________________________________________________";
	$givenDate = $formatDateTime[$dateAdd['m'][ - 2][time( )]][$vbShortDate];

	//This query does not take in to account when the last lognitime for the users was, but It is tested to work

	$sql = "select email, first_name, last_name, username, register_date, lastlogin, userid from users where (usertype < 1 and email <> '' and lastlogin <= '".$givendate."') and userid not in (select userid from pendingdelete)";
	$userList = $conn->execute( $sql );
	print "<table border=0 cellpadding=0 cellspacing=0><tr valign=top align=left><td>Skickar p&aring;minnelse till:<br>";
	if( $userList ) {
		$userLists = $userList;
		foreach( $userLists as $userList ) {
			$mail = new Mail();
			$mail->set_from("faddrar@eldsjal.org","Eldsjäls faddrar");
			$mail->add_to( $userList['email'], $userList['first_name'].' '.$userList['last_name'] );
			$mail->set_subject('Har du glömt bort oss på Eldsjäl?');
			// 
			// $Mail->Host = $strHost;
			// $Mail->From = "faddrar@eldsjal.org";
			// 
			// // From address
			// 
			// $Mail->fromName = "Eldsj&auml;ls faddrar";
			// 
			// //Mail.AddAddress "eldskrift-subscribe@eldsjal.org"
			// 
			// $Mail->AddAddress = $userList['email']." ".$userList['first_name']." ".$userList['last_name'];
			// 
			// // message subject
			// 
			// $Mail->Subject = "Har du gl&ouml;mt bort oss p&aring; Eldsj&auml;l?";
			// 
			// // message body

			$mail->add_bodypart("Hej! Den ".$userList['register_date']." skapade du ett konto för att bli medlem hos oss i alternativkonst-communityn Eldsjäl och sedan dess har det varit många turer, men jag ser att du inte loggat in på ganska länge, sist var ".$userList['lastlogin']."."."\r\n"."\r\n"."Det här är naturligtvis ett automatiskt skrivet brev, men det är faktiskt en vettig anledning till att jag skickas till dig. Vi som är medlemmar tycker det är otroligt tråkigt med en massa 'sovande' konton som kanske egentligen är helt döda. Det är dags för oss att få bekanta oss med dig igen eller att vi stryker ett streck över alltihopa och tar bort ditt konto."."\r\n"."\r\n"."Välkommen tillbaka!"."\r\n"."\r\n"."Om du inte har grejat till ditt konto hos oss inom ca: två veckor så tar vi oss friheten att ta bort det!"."\r\n"."\r\n"."Vänliga hälsningar, Faddrarna @ Eldsjäl"."\r\n"."\r\n"."http://www.eldsjal.org"."\r\n"."\r\n".$footer);
			$mail->send();
			
			
			$strErr = "";

			//bSuccess = False
			// catch errors

			$Mail->Send;

			// send message

			if( $err != 0 ) {

				// error occurred

				$message = $message;

				/* don't know how to convert err.Description */;
			}
			else {

				//bSuccess = True

				print "<li>".$userList['username']."</li>";
				$sql = "insert into pendingdelete (userid, pendingdate) values (".$userlist['userid'].", getdate())";

				//response.write(SQL)

				$conn->execute( $sql );
				$sql = "insert into parenthistory ([date], message, ownerid, userid) values (getdate(), '".$_SESSION['username']." skickade p&aring;minnelsemail till ".$userlist['username']."', ".$_SESSION['userid'].", ".$userlist['userid'].")";
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
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "notify" ) {
	if( $_GET['userid'] == "" ) {
		header( "Location: "."userAdmin.php?message=Ingen anv&auml;ndare vald eller anv&auml;ndaren finns inte!" );
	}
	$footer = "______________________________________________________________"."\r\n"."Eldsjäl är ett community för alla som har ett intresse för "."alternativkonst, vare sig det är eld, trummor, eller dans, enda kriteriet är att"."själen står i harmoni med människan när det praktiseras."."\r\n"."\r\n"."Du behöver "."inte vara medlem för att ta del av den information som delas ut på sidan."."Registrera dig om du känner att du vill vara en del av denna massiva rörelse."."Som medlem får du en egen sida, möjlighet att ladda upp dina bilder och "."filmer samt knyta kontakter landet runt. "."\r\n"."\r\n"."Mycket nöje! // Eldsjäl"."\r\n"."______________________________________________________________";
	$sql = "select email, first_name, last_name, username, register_date, lastlogin, userid from users where userid = ".intval( $_GET['userid'] );
	$userList = $conn->execute( $sql );

	//LOGGER

	$sql = "insert into history (action, userid, nick, message, [date], security) values ('parentmail',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." skickar mail och p&aring;minner en potentiell blivande medlem', getdate(), 0)";
	$conn->execute( $sql );
	?>
		<form name="notify" action="userAdmin.php?mode=notifyAct&letter=<?php echo $_GET['letter'];?>&userid=<?php echo $_GET['userid'];?>" method="post">
			<?php
		
		if( $_GET['letter'] == "remind" ) {
		print "Rubrik: <input type=text name=subject value=\"H&auml;lsa p&aring; oss!\" size=50 class=inputBorder><br>";
		print "Meddelande<br><textarea name=message class=addMessage cols=75 rows=30 wrap>Hej!"."\r\n"."Vi ser att du har anm&auml;lt ditt intresse f&ouml;r att bli medlem p&aring; eldsj&auml;l."."\r\n"."\r\n"."Det vi verkligen f&ouml;rs&ouml;ker med eldsj&auml;l &auml;r att hemsidan bara skall vara en f&ouml;rl&auml;ngning av det verkliga livet. Vi ser helst att du som vill bli medlem helst skall ha varit med p&aring; ett par tr&auml;ffar innan du blir medlem p&aring; communityn. Detta f&ouml;r att du skall vara s&auml;ker p&aring; att eldsj&auml;l &auml;r n&aring;got f&ouml;r just dig!"."\r\n"."\r\n"."Du kan naturligtvis g&aring; in p&aring; eldsj&auml;ls hemsida f&ouml;r att titta p&aring; vilka tr&auml;ffar och evenemang som sker p&aring; din ort. N&auml;r du varit p&aring; en eller fler tr&auml;ffar s&aring; &auml;r du naturligtvis v&auml;lkommen tillbaks till oss och d&aring; kommer vi ta in dig s&aring; fort tid finns."."\r\n"."\r\n"."Hoppas du f&ouml;rst&aring;r vad vi menar och det &auml;r bara att h&ouml;ra av dig till mig om du har n&aring;gra fr&aring;gor eller beh&ouml;ver hj&auml;lp med n&aring;got!"."\r\n"."\r\n"."V&auml;nliga h&auml;lsningar, ".$_SESSION['username']."@Eldsj&auml;l"."\r\n"."\r\n"."http://www.eldsjal.org"."\r\n"."\r\n".$footer."</textarea>";
		print "<input type=hidden name=mailtype value=remindmail>";
	}
	else {
		print "Rubrik: <input type=text name=subject value=\"Lite &auml;ndringar beh&ouml;vs p&aring; ditt eldsj&auml;l-konto!\" size=50 class=inputBorder><br>";
		print "Meddelande (kom ih&aring;g att komplettera med de &auml;ndringar medlemmen m&aring;ste g&ouml;ra!)<br><textarea name=message class=addMessage cols=75 rows=30 wrap>Hej!"."\r\n"."Den ".$userList['register_date']." skapade du ett konto f&ouml;r att bli medlem hos oss i alternativkonst-communityn Eldsj&auml;l och vi har nu tittat p&aring; de uppgifter du angett och har lite synpunkter."."\r\n"."\r\n"."F&ouml;r att beh&aring;lla en atmosf&auml;r av &ouml;ppenhet och tilltro medlemmarna emellan ser vi g&auml;rna att en presentation uppfyller vissa kriterier. Vi som &auml;r medlemmar tycker det &auml;r otroligt tr&aring;kigt med presentationer som &auml;r intets&auml;gande eller superreserverade. Vi vill s&aring; g&auml;rna kunna bekanta oss med dig och det &auml;r sv&aring;rt om f&ouml;rsta intrycket &auml;r fel, vilket det l&auml;tt blir om presentation inneh&aring;ller kalle anka-text, &auml;nnu v&auml;rre, ingen text alls."."\r\n"."\r\n"."F&ouml;r att underl&auml;tta f&ouml;r dig n&auml;r du kompletterar dina uppgifter s&aring; vill vi att du t&auml;nker p&aring; detta:"."\r\n"."\r\n"."En presentation skall inneh&aring;lla: "."\r\n"."* Fullst&auml;ndigt, riktigt namn"."\r\n"."* Riktig mailaddress (vilket du har om du l&auml;ser detta)"."\r\n"."* Ditt f&ouml;delsedatum "."\r\n"."* En presentation d&auml;r det bl.a. st&aring;r vem du &auml;r och vad du sysslar med"."\r\n"."* Minst en sysslar med-grej som du h&aring;ller p&aring; med (om du inte sysslar med n&aring;got men vill, s&aring; skriv d&aring; det i presentationen)"."\r\n"."\r\n"."Önskv&auml;rt som tusan &auml;r en bild som ska vara:"."\r\n"."* P&aring; dig "."\r\n"."* Inte st&ouml;tande "."\r\n"."* Inte 700 &aring;r gammal"."\r\n"."\r\n"."Du beh&ouml;ver bara logga in med dina uppgifter f&ouml;r att uppdatera och fixa det som saknas s&aring; det blir bra och vi godk&auml;nner din ans&ouml;kan direkt. "."\r\n"."\r\n"."Om du inte har grejat till ditt konto hos oss inom ca: tv&aring; veckor s&aring; tar vi oss friheten att ta bort det!"."\r\n"."\r\n"."H&ouml;r mer &auml;n g&auml;rna av dig om det &auml;r n&aring;got du undrar &ouml;ver"."\r\n"."\r\n"."V&auml;nliga h&auml;lsningar, ".$_SESSION['username']."@Eldsj&auml;l"."\r\n"."\r\n"."http://www.eldsjal.org"."\r\n"."\r\n".$footer."</textarea>";
		print "<input type=hidden name=mailtype value=updatemail>";
	}
	print "<input type=hidden name=email value=".$userList['email'].">";
	print "<input type=hidden name=firstName value=".$userList['first_name'].">";
	print "<input type=hidden name=lastName value=".$userList['last_name'].">";
	print "<input type=hidden name=username value=".$userList['username'].">";
	?><br>
			<input type="submit" value="Skicka">
		</form>
		<br>
		<?php if( $_GET['letter'] == "remind" ) {?>
		<a href="userAdmin.php?mode=notify&userid=<?php echo $_GET['userid'];?>" class="a2">&Auml;ndringsbrev &raquo;</a>
		<?php
	}
	else {?>
			<a href="userAdmin.php?mode=notify&letter=remind&userid=<?php echo $_GET['userid'];?>" class="a2">Kom &aring; lek-brev &raquo;</a>
		<?php
	}
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "notifyAct" ) {
	if( $_GET['userid'] == "" ) {
		header( "Location: "."userAdmin.php?message=Ingen anv&auml;ndare vald eller anv&auml;ndaren finns inte!" );
	}
	$email = $_POST['email'];
	$message = $_POST['message'];
	$subject = $_POST['subject'];
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];
	$username = $_POST['username'];
	$mailtype = $_POST['mailtype'];
	if( $email == "" ) {
		header( "Location: "."userAdmin.php?message=Ingen emailadress finns!" );
	}
	if( $message == "" ) {
		header( "Location: "."userAdmin.php?message=Du m&aring;ste skriva ett meddelande!" );
	}
	if( $subject == "" ) {
		header( "Location: "."userAdmin.php?message=Du m&aring;ste ange rubrik!" );
	}

	// $Mail is of type "Persits.MailSender"

	$sql = "select first_name, last_name, username, email from users where userid =".$_SESSION['userid'];
	$responsible = $conn->execute( $sql );
	// $strHost = "127.0.0.1;mail.kanzieland.com;192.168.1.11";
	
	$mail = new Mail();
	$mail->set_from($responsible['email'], $responsible['first_name'].' "'.$responsible['username'].'" '.$responsible['last_name']);
	$mail->add_to( $email, $firstName.' '.$lastName );
	$mail->set_subject($subject);
	$mail->add_bodypart($message);
	$mail->send();
	
	// $Mail->Host = $strHost;
	// $Mail->From = $responsible['email'];

	// From address

	// $Mail->fromName = $responsible['first_name'].' "'.$responsible['username'].'" '.$responsible['last_name'];

	//Mail.AddAddress "eldskrift-subscribe@eldsjal.org"

	// $Mail->AddAddress = $email.' '.$firstname." ".$lastname;

	//Mail.AddAddress "kanzie@home.se"
	// message subject

	// $Mail->Subject = $subject;

	// message body

	// $Mail->Body = $message;
	// $strErr = "";
	// 
	// //bSuccess = False
	// // catch errors
	// 
	// $Mail->Send;

	// send message

	if( $err != 0 ) {

		// error occurred

		$meddelande = $meddelande;

		/* don't know how to convert err.Description */;
	}
	else {

		//bSuccess = True

		$meddelande = "Meddelandet skickat";
		$sql = "select pendingdeleteid, userid from pendingdelete where userid = ".intval( $_GET['userid'] );
		$notified = $conn->execute( $sql );
		if( $notified ) {
			$sql = "insert into pendingdelete (userid, pendingdate) values (".intval( $_GET['userid'] ).", getdate())";
		}
		else {
			$sql = "update pendingdelete set pendingdate= getdate() where pendingdeleteid = ".$notified['pendingdeleteid'];
		}

		//response.write(SQL)
		//response.end

		$conn->execute( $sql );
		if( $mailtype == "remindmail" ) {
			$mailtype = "p&aring;minnelsemail";
		}
		elseif( $mailtype == "updatemail" ) {
			$mailtype = "&auml;ndringsmail";
		}
		$sql = "insert into parenthistory ([date], message, ownerid, userid) values (getdate(), '".$_SESSION['username']." skickade ".$mailtype." till ".$username."', ".$_SESSION['userid'].", ".intval( $_GET['userid'] ).")";
		$conn->execute( $sql );
	}
	$Mail->resetAll;
	header( "Location: "."userAdmin.php?message=".$meddelande );
	$notified = null;
	$responsible = null;
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "approve" ) {
	if( $_GET['userid'] == "" ) {
		header( "Location: "."userAdmin.php?Message=Ingen anv&auml;ndare angedd!" );
	}
	if( $_SESSION['userid'] == "" ) {
		header( "Location: "."main.php?message=Du &auml;r inte inloggad!" );
	}
	$parent = "Faddertext";
	$sql = "select email, username, password, first_name, last_name from users where userid = ".intval( $_GET['userid'] );
	$user = $conn->execute( $sql );
	$sql = "select email, username, first_name, last_name from users where userid = ".$_SESSION['userid'];
	$dbParent = $conn->execute( $sql );
	// $strHost = "127.0.0.1;mail.eldsjal.org;192.168.1.11";

	// $Mail is of type "Persits.MailSender"
	// enter valid SMTP host

	$mail = new Mail();
	$mail->set_from($dbParent['email'], $dbParent['first_name'].' "'.$dbParent['username'].'" '.$dbParent['last_name']);
	$mail->add_to( $user['email'], $user['first_name']." ".$user['last_name'] );
	$mail->set_subject('Du har blivit godkänd medlem på Eldsjäl!');
	// $mail->add_bodypart($message);

	// $Mail->Host = $strHost;
	// $Mail->From = $dbParent['email'];
	// 
	// // From address
	// 
	// $Mail->FromName = $dbParent['first_name'].' "'.$dbparent['username'].'" '.$dbParent['last_name'];
	// $Mail->AddAddress = $user['email'].' '.$user['first_name']." ".$user['last_name'];
	// 
	// // message subject
	// 
	// $Mail->Subject = "Du har blivit godk&auml;nd medlem p&aring; Eldsj&auml;l!";
	// 
	// // message body

	$mail->add_bodypart("Hej! Jag har fått äran att bli din fadder på Eldsjäl och det känns superkul att kunna hälsa dig välkommen som medlem hos oss. Detta betyder att vi har tillsammans godkänt din ansökan och tycker det känns supersmutt att du valt att ansluta dig till vår familj!"."\r\n"."\r\n"."Jag kommer att möta upp dig på communityn för att lära känna dig bättre och hjälpa dig igång! "."\r\n"."\r\n"."För säkerhetsskull skickar vi med dina användaruppgifter utifall du skulle ha glömt dem medans du väntade."."\r\n"."\r\n"."Användarnamn: ".$user['username']."\r\n"."Lösenord: ".$user['password']."\r\n"."http://www.eldsjal.org/"."\r\n"."\r\n"."Vänliga hälsningar, Eldsjäl!");
	$mail->send();

	$strErr = "";
	$bSuccess = false;

	// catch errors

	$Mail->Send;

	// send message

	if( $err != 0 ) {

		// error occurred

		$message = $message;

		/* don't know how to convert err.Description */;
	}
	else {
		$bSuccess = true;
	}
	$mail->reseAll;
	if( $bSuccess ) {
		$sql = "delete from pendingdelete where userid = ".intval( $_GET['userid'] );
		$conn->execute( $sql );
		$sql = "update users set approvedby = ".$_SESSION['userid'].", usertype = 1 where userid = ".intval( $_GET['userid'] );
		$conn->execute( $sql );
		$sql = "insert into friends (user_id, friend_id, friendtype, date, accepted) values (".intval( $_GET['userid'] ).", ".$_SESSION['userid'].", 14, getdate(),1)";
		$conn->execute( $sql );
		$sql = "select message, topic from systemmessages where systemmessagename = 'welcome'";
		$systemmessage = $conn->execute( $sql );
		$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".intval( $_GET['userid'] ).", '".$systemmessage['topic']."', '".$systemmessage['message']."', 0, getdate(), ".$_SESSION['userid'].")";
		$conn->execute( $sql );
		$sql = "select message, topic from systemmessages where systemmessagename = 'rules'";
		$systemmessage = $conn->execute( $sql );
		$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".intval( $_GET['userid'] ).", '".$systemmessage['topic']."', '".$systemmessage['message']."', 0, getdate(), ".$_SESSION['userid'].")";
		$conn->execute( $sql );

		//LOGGER

		$sql = "insert into history (action, userid, nick, message, [date], security) values ('parentapprove',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." godk&auml;nde just v&aring;r nyaste medlem \"".$user['username']."\"', getdate(), 0)";
		$conn->execute( $sql );
		$sql = "insert into parenthistory ([date], message, ownerid, userid) values (getdate(), '".$_SESSION['username']." godk&auml;nde ".$user['username']." som medlem', ".$_SESSION['userid'].", ".intval( $_GET['userid'] ).")";
		$conn->execute( $sql );
		header( "Location: "."userPresentation.php?userid=".$_GET['userid']."&message=Användaren godkänd och informationsmail skickat!" );
	}
	else {
		header( "Location: "."main.php?message=FEL: ".$message );
	}
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "delete" ) {
	if( $_GET['userid'] == "" || $_GET['userid'] == "0" ) {
		header( "Location: "."userAdmin.php?message=Ingen anv&auml;ndare angedd" );
	}
	if( $_SESSION['usertype'] < $application['useradmin'] ) {
		header( "Location: "."userAdmin.php?message=Denna funktion är låst, kontakta glemme" );
	}
	if( $_SESSION['usertype'] < 100 ) {
		header( "Location: "."main.php?message=Du har inte rättigheter att göra detta" );
		exit();
	}

	//application("userAdmin")

	$userid = intval( $_GET['userid'] );

	//R.I.P-account 1590
	//styr om fadderskapet
	//response.Write("&Auml;ndra fadderbarnens fadder - ")
	//SQL = "update users set approved_by = (select approved_by from users where userid = " & userid & ") where approved_by = " userid
	//conn.execute SQL, rowsaffected, adCmdText
	//response.Write(rowsaffected & " rader <br><br>")
	
	//Ta bort fr&#140;n adresshistoriken

	print "tar bort gamla adressrader - ";
	$sql = "delete from address where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader <br><br>";

	//Ta bort gamla namn

	print "tar bort gamla namn - ";
	$sql = "delete from history_name where user_id = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader <br><br>";

	// Update all inserted wisdom by the user

	print "&Auml;ndrar ansvarig p&aring; alla visheter som kommer fr&aring;n anv&auml;ndaren - ";
	$sql = "update wisebox set addedbyid = ".$application['ripuser']." where addedbyid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader <br><br>";

	// Update all inserted trivias by the user

	print "&Auml;ndrar ansvarig p&aring; all trivia som kommer fr&aring;n anv&auml;ndaren - ";
	$sql = "update trivia set insertedby = ".$application['ripuser']." where insertedby = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Update all approved trivias by the user

	print "&Auml;ndrar ansvarig p&aring; godk&auml;nd trivia av anv&auml;ndaren - ";
	$sql = "update trivia set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Changes the userid of all messages sent FROM the RIP-user

	print "&Auml;ndrar avs&auml;ndare p&aring; alla meddelanden skickade FR&Aring;N anv&auml;ndaren - ";
	$sql = "update messages set messagefrom = ".$application['ripuser']." where messagefrom = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Changes the userid of all news posted FROM the user

	print "&Auml;ndrar avs&auml;ndare p&aring; alla nyheter skickade FR&Aring;N anv&auml;ndaren - ";
	$sql = "update news set newsauthor = ".$application['ripuser']." where newsauthor = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Changes the userid to the RIP-user in login-statistics

	print "Styr om alla inloggningar f&ouml;r statistikens skull - ";
	$sql = "update loginhistory set userid = ".$application['ripuser']." where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Redirect all links submitted by the users to the RIP-account

	print "Styr om alla l&auml;nkar registrerade av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update links set posterid = ".$application['ripuser']." where posterid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Redirect all posts to users from the deleted user to the RIP-account

	print "Styr om alla bilduppladdningar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update images set uploadedby = ".$application['ripuser']." where uploadedby = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Redirect all posts to users from the deleted user to the RIP-account

	print "Styr om alla bildgodk&auml;nningar av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update images set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Redirect all posts to users from the deleted user to the RIP-account

	print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update guestbook set fromuserid = ".$application['ripuser']." where fromuserid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Update the posterID to the R.I.P-id on all messages posted by the user in the forum

	print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update forummessages set posterid = ".$application['ripuser']." where posterid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Update the topics that the user might have created

	print "Styr om alla forumtr&aring;dar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update forumtopics set topicposterid = ".$application['ripuser']." where topicposterid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// If the user ever registred an event, direct to the R.I.P-user

	print "Styr om alla aktiviteter registrerad av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update calendarevents set userid = ".$application['ripuser']." where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	//Remove user from Userlist

	print "Tar bort anv&auml;ndare ur listan - ";
	$sql = "delete from users where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// If the user was a member of the board, remove him from the list

	print "Tar bort anv&auml;ndare ur styrelsen - ";
	$sql = "delete from board where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Delete all pending notifications

	print "Tar bort alla kalendernotifieringar - ";
	$sql = "delete from calendarnotify where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Delete all traces of the people that read the diary first, before deleting the actual diarys,
	// or else we dont know which diarys to delete

	print "Tar bort alla l&auml;smarkeringar i tankar - ";
	$sql = "delete from diaryread where diaryid in (select diaryid from diary where userid = ".$userid.")";
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Delete all dairys

	print "Tar bort alla tankar - ";
	$sql = "delete from diary where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove all friendrelation to and from the user

	print "Tar bort alla v&auml;nrelation till och fr&aring;n anv&auml;ndaren - ";
	$sql = "delete from friends where user_id = ".$userid." or friend_id = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove all guestBookentrys to and from the user

	print "Tar bort alla g&auml;stboksinl&auml;gg till anv&auml;ndaren - ";
	$sql = "delete from guestbook where touserid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove all imagescoring from the user

	print "Rensar alla po&auml;ng anv&auml;ndare satt p&aring; bilder - ";
	$sql = "delete from imagescore where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove all traces of activities that the user has participated in

	print "Tar bort alla sp&aring;r av de aktiviteter anv&auml;ndaren varit med p&aring; - ";
	$sql = "delete from joinactivity where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove all messages sent TO the user

	print "Tar bort alla meddelanden anv&auml;ndaren har f&aring;tt - ";
	$sql = "delete from messages where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove all news notifications to the user

	print "Tar bort alla nyhetsnotifieringar anv&auml;ndaren har f&aring;tt - ";
	$sql = "delete from newsnotify where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove all adoption processes

	print "Tar bort alla adoptionsprocesser som p&aring;g&aring;r f&ouml;r anv&auml;ndaren - ";
	$sql = "delete from pendingadoption where adopteeuserid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove the user from pending delete-table

	print "Tar bort anv&auml;ndaren ur tabort-k&ouml;n - ";
	$sql = "delete from pendingdelete where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove the user from the logged in-table

	print "Om anv&auml;ndaren hakat upp sig i inloggadtabellen s&aring; rensar vi bort denne d&auml;r nu - ";
	$sql = "delete from seen where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove the user from the artlist table

	print "Tar bort alla aktiviter som anv&auml;ndaren sagt sig h&aring;lla p&aring; med - ";
	$sql = "delete from userartlist where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";

	// Remove the user from the artlist table

	print "Tar bort alla medlemsskapsbekr&auml;ftelser - ";
	$sql = "delete from user_years where userid = ".$userid;
	$conn->execute( $sql );

	//  $rowsaffected  $adCmdText;

	print $rowsaffected." rader<br><br>";
	print "Anv&auml;ndaren nu helt borttagen!";
	exit( );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "remindNoEmail" ) {
	$userList = null;
	$sql = "select userid from users where email =''";
	$userList = $conn->execute( $sql );
	$userLists = $userList;
	foreach( $userLists as $userList ) {
		$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".$userList['userid'].", 'Uppdatering av uppgifter krävs!', 'Hejsan! Vi har upptäckt att du saknar email-address vilket har blivit ett krav på eldsjäl. Vänligen korrigera detta snarast. Eftersom du saknar email kan vi inte kontakta dig annat än här vilket gör det svårt att veta om detta konto är dött eller inte, så om två veckor förutsätter vi att det är dött och tar bort det såtillvida ingen email har dykt upp! Tack på förhand, Elektronika!', 0, getdate(), ".$_SESSION['userid'].")";

		//response.Write(SQL)

		$conn->execute( $sql );
		$sql = "insert into pendingdelete (userid, pendingdate) values (".$userlist['userid'].", getdate())";
		$conn->execute( $sql );

		//    $userList->moveNext;
	}
	header( "Location: "."userAdmin.php?message=användarna informerade!" );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "fadder" ) {

	//if request.querystring("userid") <> "" AND session("boardMember") = 1 then

	if( $_GET['userid'] != "" && $_SESSION['usertype'] >= $application['useradmin'] ) {
		$sql = "update users set usertype = ".$application['useradmin']." where userid = '".$_GET['userid']."'";
		$conn->execute( $sql );
		$sql = "select username from users where userid = ".$_GET['userid'];
		$name = $conn->execute( $sql );
		$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('ny fadder (".$name['username'].") utsedd av ".$_SESSION['username']."', 'jag har nu utsett ".$name['username']." till fadder och lovar att medlemmen kommer att bruka detta f&ouml;rtroende med st&ouml;rsta ansvar. v&auml;nligen s&auml;kerst&auml;ll att medlemmen har en @eldsjal.org-address.', 0, getdate(), ".$_SESSION['userid'].", 5122)";
		$conn->execute( $sql );
		header( "Location: "."userPresentation.php?userid=".$_GET['userid']."&message=användaren är nu fadder, glöm inte att användaren behöver en @eldsjal.org-address i sina inställningar!" );
	}
	else {
		header( "Location: "."main.php?message=Ingen användare angedd" );
	}
}
else {

	//response.Write("<a href=userAdmin.php?mode=remind class=a2>P&aring;minn gamla anv&auml;ndare</a>")

	$sql = "select users.username, users.userid, locations.locationname from users inner join locations on users.city = locations.locationid where usertype >= 2 order by locations.locationname";
	$parents = $conn->execute( $sql );
	if( $parents ) {
		$list = "<table border=0>";
		$parentss = $parents;
		foreach( $parentss as $parents ) {

			//response.write("<a href=userPresentation.php?userid=" & parents("userid") & " class=a2>" & parents("username") & "</a><br>")

			$sql = "select count(userid) as antal from users where approvedby = ".$parents['userid'];
			$count = $conn->execute( $sql );
			$list = $list."<tr><td><a href=userPresentation.php?userid=".$parents['userid']." class=a2>".$parents['username']."</a></td><td><b>".$parents['locationname']."</b</td><td></td></tr>";

			//      $parents->moveNext;
		}
		$list = $list."</table>";
		print "< <b><a onMouseOver=\"return overlib('".$list."', STICKY, CAPTION, 'Kanzie &auml;r snygg!', MOUSEOFF, WRAP, CELLPAD, 5);\" onMouseOut=\"return nd();\" href=\"#\" class=\"a2\" target=\"_blank\">Vi &auml;r ocks&aring; faddrar</a></b> ><br><br>";
	}
	print "<a href=sendParentMessage.php class=a2>Fadderpost</a><br><br>";
	$sql = "select users.online, locations.locationname, users.eldsjalfind, users.username, users.userid, users.lastlogin from users inner join locations on users.city = locations.locationid where users.usertype = 0 and email <> '' order by lastlogin desc";
	$userList = $conn->execute( $sql );
	if( !$userList ) {
		print "Inga nya medlemmar att godk&auml;nna eller p&aring;minna, sk&ouml;nt! =)";
	}
	else {
		print "<B>Ej v&auml;lkomna personer!</B><br> Fredrik 'isse' Hillqvist - fiddster@hotmail.com<BR>Ivar 'seros' Ryding - seroster@live.se<P><B>Nya regler!</B><br>Man skall nu ha tr&auml;ffat en Eldsj&auml;l och i s&aring; stor utstr&auml;ckning som m&ouml;jligt varit p&aring; en Eldsj&auml;ltr&auml;ff, de ombeds vid registrering skriva vem som de tr&auml;ffat och hur. Jag har lagt till hur de h&ouml;rde talas om eldsj&auml;l som ni f&aring;r fram genom att peka p&aring; namnet, d&auml;r skall de numera referera till kontakt p&aring; Eldsj&auml;l.<P><table border=1 width=450><tr><td>Medlemsnamn:</td><td>Godk&auml;nn:</td><td>P&aring;minn</td><td>Ta bort</td><td>P&aring;mind:</td><td>Senast inloggad:</td><td>Online:</td></tr>";
		$userLists = $userList;
		foreach( $userLists as $userList ) {
			$sql = "select pendingdate from pendingdelete where userid = ".$userList['userid'];
			$reminder = $conn->execute( $sql );
			$sql = "select parenthistory.date, parenthistory.message, users.username from parenthistory inner join users on parenthistory.ownerid = users.userid where parenthistory.userid = ".$userList['userid'];
			$history = $conn->execute( $sql );
			$historik = "";
			$historys = $history;
			if( !empty( $historys ) && !is_array( current( $historys ) ) ) 
				$historys = array(
					$historys,
				);
			if( !empty( $historys ) ) 
				foreach( $historys as $history ) {
					$historik = $historik."<br>".$history['date']."<br>".$history['message']."<br>";

				//        $history->moveNext;
			}
			$lastLogin = round(( time( ) - strtotime( $userList['lastlogin'] ) ) / ( 3600 * 24 ) );
			if( $lastLogin > 0 ) {
				$lastLogin = $lastLogin." dagar sedan";
			}
			else {
				$lastLogin = "idag";
			}
			$reminderDate = "&nbsp;";
			if( $reminder ) {
				if( round(( time( ) - strtotime( $reminder['pendingdate'] ) ) / ( 3600 * 24 ) > 0 ) ) {
					$reminderDate = round(( time( ) - strtotime( $reminder['pendingdate'] ) ) / ( 3600 * 24 ) )." dagar sedan";
				}
				else {
					$reminderDate = "idag";
				}
			}
			$online = "<font color=RED><i>offline</i></font>";
			if( $userList['online'] == true ) {
				$online = "<font color=GREEN><i>online</i></font>";
			}
			print "<tr><td><a onMouseOver=\"return overlib('<b>".$userList['locationname']."</b><br><br>".rqJS( $userList['eldsjalfind'] )."<br><br>__Historik___<br>".$historik."');\" onMouseOut=\"return nd();\" href=\"userPresentation.php?userid=".$userList['userid']."\" class=\"a2\" target=\"_blank\">".$userList['username']."</a></td><td width=\"50\" align=\"middle\"><a href=userAdmin.php?mode=approve&userid=".$userList['userid']." onClick=\"return confirmSubmit('Vill du verkligen godk&auml;nna medlemmen?');\"><img src=\"images/buttons/vbutton.gif\" border=\"0\" alt=\"Godk&auml;nn anv&auml;ndaren!\"></a></td><td><a href=userAdmin.php?mode=notify&letter=change&userid=".$userList['userid']." class=a2><img src=\"images/buttons/vbutton.gif\" border=\"0\" alt=\"P&aring;minn anv&auml;ndaren!\"></a></td><td><a href=userAdmin.php?mode=delete&userid=".$userList['userid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort medlemmen?');\"><img src=\"images/buttons/xbutton.gif\" border=\"0\" alt=\"Ta bort anv&auml;ndaren!\"></a></td><td>".$reminderDate."&nbsp;</td><td>".$lastLogin."</td><td>".$online."</td></tr>";

			//      $userList->moveNext;
		}
		print "</table>";
	}
	$sql = "select username, userid, online, lastlogin from users where email = ''";
	$userList = $conn->execute( $sql );
	if( $userList ) {
		print "<table border=1 width=450><tr><td colspan=5>Dessa anv&auml;ndare saknar emailadress:<a href=userAdmin.php?mode=remindNoEmail class=a2>P&aring;minn!</a> <B>TRYCK EJ!</B></td></tr><tr><td>Medlemsnamn:</td><td>Avf&auml;rda:</td><td>P&aring;mind:</td><td>Senast inloggad:</td><td>Online:</td></tr>";
		$userLists = $userList;
		foreach( $userLists as $userList ) {
			$sql = "select pendingdate from pendingdelete where userid = ".$userList['userid'];
			$reminder = $conn->execute( $sql );
			if( round(( time( ) - strtotime( $userList['lastlogin'] ) ) / 3600 * 24 ) > 0 ) {
				$lastLogin = round(( time( ) - strtotime( $userList['lastlogin'] ) ) / ( 3600 * 24 ) )." dagar sedan";
			}
			else {
				$lastLogin = "idag";
			}
			$reminderDate = "&nbsp;";
			if( $reminder && isset( $reminder['pendingdate'] ) ) {
				$reminderDate = round(( time( ) - strtotime( $reminder['pendingdate'] ) ) / ( 3600 * 24 ) )." dagar sedan";
			}
			$online = "<font color=RED><i>offline</i></font>";
			if( $userList['online'] == true ) {
				$online = "<font color=GREEN><i>online</i></font>";
			}
			print "<tr><td><a href=userPresentation.php?userid=".$userList['userid']." class=a2>".$userList['username']."</a></td><td width=\"50\" align=\"middle\">&nbsp;</td><td>".$reminderDate."</td><td>".$lastLogin."</td><td>".$online."</td></tr>";

			//      $userList->moveNext;
		}
		print "</table>";
	}

	//LOGGER

	$sql = "insert into history (action, userid, nick, message, [date], security) values ('parentview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." jobbar med nya medlemsans&ouml;kningar', getdate(), 0)";
	$conn->execute( $sql );
	$userList = null;
}
?>
		</td>		
		<td valign="top">
		<div class="boxRight">
		<h3 class="boxHeader">
		S&ouml;k medlem:</h3>
		<h4 class="boxContent">
			<?php  require_once( 'memberSearch.applet.php' );?>
		</h4>
		</div>
		<div class="boxRight">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar">
				<?php  require_once( 'calendar.php' );?>
		</h4></div>
		<div class="boxRight">
		<h3 class="boxHeader">
		Senaste bilder:</h3>
		<h4 class="boxContent">
			<?php  require_once( 'image.applet.php' );?>
		</h4>
		</div>	
		</td>
	</tr>
<?php  require_once( 'bottomInclude.php' );?>