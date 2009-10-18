<?php
// $Conn is of type "adodb.connection"

$a2p_connstr = $Application['eldsjaldb'];
$a2p_uid = strstr( $a2p_connstr, 'uid' );
$a2p_uid = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
$a2p_pwd = strstr( $a2p_connstr, 'pwd' );
$a2p_pwd = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
$a2p_database = strstr( $a2p_connstr, 'dsn' );
$a2p_database = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
$Conn = mysql_connect( "localhost", $a2p_uid, $a2p_pwd );
mysql_select_db( $a2p_database, $Conn );
set_time_limit( 3600 );
$lastDate = $dateAdd['d'][ - 45][time( )];
$sql = "select userid, register_date, email, first_name, last_name, lastlogin from users where lastlogin <= '".$lastdate."' and userid not in (select userid from pendingdelete)";
print $sql;
$userList = $userList_query = mysql_query(( $sql ), $conn );
$userList = mysql_fetch_array( $userList_query );;
if( !( $userList == 0 ) ) {
	// $Mail is of type "Persits.MailSender"

	$footer = "______________________________________________________________"."\r\n"."Eldsj&auml;l &auml;r ett community f&ouml;r alla som har ett intresse f&ouml;r "."alternativkonst, vare sig det &auml;r eld, trummor, eller dans, enda kriteriet &auml;r att"."sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det praktiseras."."\r\n"."\r\n"."Du beh&ouml;ver "."inte vara medlem f&ouml;r att ta del av den information som delas ut p&aring; sidan."."Registrera dig om du k&auml;nner att du vill vara en del av denna massiva r&ouml;relse."."Som medlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder och "."filmer samt knyta kontakter landet runt. "."\r\n"."\r\n"."Mycket n&ouml;je! // Eldsj&auml;l"."\r\n"."______________________________________________________________";
	while( !( $userList == 0 ) ) {
		$strHost = "192.168.1.10;127.0.0.1;mail.kanzieland.com";
		$Mail->Host = $strHost;
		$Mail->From = "glemme@eldsjal.org";

		// From address

		$Mail->fromName = "Viktor Glemme";

		//Mail.AddAddress "eldskrift-subscribe@eldsjal.org"

		$Mail->AddAddress$userList['email']$userList['first_name']$userList['last_name']

		// message subject

		$Mail->Subject = "Har du gl&ouml;mt bort oss p&aring; Eldsj&auml;l?";

		// message body

		$Mail->Body = "Hej! Den ".$userList['register_date']." skapade du ett konto f&ouml;r att bli medlem hos oss i alternativkonst-communityn Eldsj&auml;l och sedan dess har det varit m&aring;nga turer, men jag ser att du inte loggat in p&aring; ganska l&auml;nge, sist var ".$userList['lastlogin']."."."\r\n"."\r\n"."Det h&auml;r &auml;r naturligtvis ett automatiskt skrivet brev, men det &auml;r faktiskt en vettig anledning till att jag skickas till dig. Vi som &auml;r medlemmar tycker det &auml;r otroligt tr&aring;kigt med en massa 'sovande' konton som kanske egentligen &auml;r helt d&ouml;da. Det &auml;r dags f&ouml;r oss att f&aring; bekanta oss med dig igen eller att vi stryker ett streck &ouml;ver alltihopa och tar bort ditt konto."."\r\n"."\r\n"."V&auml;lkommen tillbaka!"."\r\n"."\r\n"."Om du inte har grejat till ditt konto hos oss inom ca: tv&aring; veckor s&aring; tar vi oss friheten att ta bort det!"."\r\n"."\r\n"."V&auml;nliga h&auml;lsningar, Viktor Glemme @ Eldsj&auml;l"."\r\n"."\r\n"."http://www.eldsjal.org"."\r\n"."\r\n".$footer;
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
			$sql = "insert into pendingdelete (userid, pendingdate) values (".$userlist['userid'].", getdate())";
			mysql_query(( $sql ), $conn );
			print "Mailade ".$userList['userid'];
		}
		$Mail->resetAll;
		$userList = mysql_fetch_array( $userList_query );
	}
}

// DELETING USERS

$sql = "select userid from pendingdelete where pendingdate <= '".$lastdate."'";
$userList = $userList_query = mysql_query(( $sql ), $conn );
$userList = mysql_fetch_array( $userList_query );;
if( !( $userList == 0 ) ) {
	while( !( $userList == 0 ) ) {
		$userid = $userList['userid'];

		//R.I.P-account 972
		// Update all inserted wisdom by the user

		print "&Auml;ndrar ansvarig p&aring; alla visheter som kommer fr&aring;n anv&auml;ndaren - ";
		$sql = "update wisebox set addedbyid = ".$application['ripuser']." where addedbyid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader <br><br>";

		// Update all inserted trivias by the user

		print "&Auml;ndrar ansvarig p&aring; all trivia som kommer fr&aring;n anv&auml;ndaren - ";
		$sql = "update trivia set insertedby = ".$application['ripuser']." where insertedby = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Update all approved trivias by the user

		print "&Auml;ndrar ansvarig p&aring; godk&auml;nd trivia av anv&auml;ndaren - ";
		$sql = "update trivia set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Changes the userid of all messages sent FROM the RIP-user

		print "&Auml;ndrar avs&auml;ndare p&aring; alla meddelanden skickade FR&Aring;N anv&auml;ndaren - ";
		$sql = "update messages set messagefrom = ".$application['ripuser']." where messagefrom = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Changes the userid of all news posted FROM the user

		print "&Auml;ndrar avs&auml;ndare p&aring; alla nyheter skickade FR&Aring;N anv&auml;ndaren - ";
		$sql = "update news set newsauthor = ".$application['ripuser']." where newsauthor = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Changes the userid to the RIP-user in login-statistics

		print "Styr om alla inloggningar f&ouml;r statistikens skull - ";
		$sql = "update loginhistory set userid = ".$application['ripuser']." where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Redirect all links submitted by the users to the RIP-account

		print "Styr om alla l&auml;nkar registrerade av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update links set posterid = ".$application['ripuser']." where posterid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Redirect all posts to users from the deleted user to the RIP-account

		print "Styr om alla bilduppladdningar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update images set uploadedby = ".$application['ripuser']." where uploadedby = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Redirect all posts to users from the deleted user to the RIP-account

		print "Styr om alla bildgodk&auml;nningar av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update images set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Redirect all posts to users from the deleted user to the RIP-account

		print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update guestbook set fromuserid = ".$application['ripuser']." where fromuserid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Update the posterID to the R.I.P-id on all messages posted by the user in the forum

		print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update forummessages set posterid = ".$application['ripuser']." where posterid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Update the topics that the user might have created

		print "Styr om alla forumtr&aring;dar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update forumtopics set topicposterid = ".$application['ripuser']." where topicposterid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// If the user ever registred an event, direct to the R.I.P-user

		print "Styr om alla aktiviteter registrerad av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update calendarevents set userid = ".$application['ripuser']." where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		//Remove user from Userlist

		print "Tar bort anv&auml;ndare ur listan - ";
		$sql = "delete from users where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// If the user was a member of the board, remove him from the list

		print "Tar bort anv&auml;ndare ur styrelsen - ";
		$sql = "delete from board where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Delete all pending notifications

		print "Tar bort alla kalendernotifieringar - ";
		$sql = "delete from calendarnotify where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Delete all traces of the people that read the diary first, before deleting the actual diarys,
		// or else we dont know which diarys to delete

		print "Tar bort alla l&auml;smarkeringar i tankar - ";
		$sql = "delete from diaryread where diaryid in (select diaryid from diary where userid = ".$userid.")";
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Delete all dairys

		print "Tar bort alla tankar - ";
		$sql = "delete from diary where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove all friendrelation to and from the user

		print "Tar bort alla v&auml;nrelation till och fr&aring;n anv&auml;ndaren - ";
		$sql = "delete from friends where user_id = ".$userid." or friend_id = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove all guestBookentrys to and from the user

		print "Tar bort alla g&auml;stboksinl&auml;gg till anv&auml;ndaren - ";
		$sql = "delete from guestbook where touserid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove all imagescoring from the user

		print "Rensar alla po&auml;ng anv&auml;ndare satt p&aring; bilder - ";
		$sql = "delete from imagescore where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove all traces of activities that the user has participated in

		print "Tar bort alla sp&aring;r av de aktiviteter anv&auml;ndaren varit med p&aring; - ";
		$sql = "delete from joinactivity where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove all messages sent TO the user

		print "Tar bort alla meddelanden anv&auml;ndaren har f&aring;tt - ";
		$sql = "delete from messages where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove all news notifications to the user

		print "Tar bort alla nyhetsnotifieringar anv&auml;ndaren har f&aring;tt - ";
		$sql = "delete from newsnotify where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove all adoption processes

		print "Tar bort alla adoptionsprocesser som p&aring;g&aring;r f&ouml;r anv&auml;ndaren - ";
		$sql = "delete from pendingadoption where adopteeuserid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove the user from pending delete-table

		print "Tar bort anv&auml;ndaren ur tabort-k&ouml;n - ";
		$sql = "delete from pendingdelete where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove the user from the logged in-table

		print "Om anv&auml;ndaren hakat upp sig i inloggadtabellen s&aring; rensar vi bort denne d&auml;r nu - ";
		$sql = "delete from seen where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";

		// Remove the user from the artlist table

		print "Tar bort alla aktiviter som anv&auml;ndaren sagt sig h&aring;lla p&aring; med - ";
		$sql = "delete from userartlist where userid = ".$userid;
		mysql_query( $sql, $conn );
		$rowsaffected$adCmdText;
		print $rowsaffected." rader<br><br>";
		print "Anv&auml;ndaren nu helt borttagen!";
		$userList = mysql_fetch_array( $userList_query );
	}
}
?>
