<?php 
// Den här filen är inte bra att köra innan den är genomgången. :)
ob_start( );
set_time_limit( 3600 );
ini_set('display_errors', TRUE);

require('functions.php');
require('config.php');

$conn = new MysqlConn();

// CLEAN CALENDAR NOTIFICATIONS

$sql = "select calendarnotify.calendarnotifyid from calendarevents inner join calendarnotify on calendarnotify.eventid = calendarevents.eventid where calendarevents.fulldate <= getdate() and calendarnotify.notified = 0";
$dbs = $conn->execute($sql);
$rowsAffected = 0;
if(is_array($dbs)) foreach($dbs as $db) {
	$sql = "delete from calendarnotify where calendarnotifyid = ".$db['calendarnotifyid'];
	$conn->execute($sql);
	$rowsAffected += $conn->affected_rows();
}
print $rowsAffected .' rader raderade från calendarnotify<br/>';
// exit();
/*
	// Add retired accounts to the pending-table, delete notified accounts

	// $lastDate = $dateAdd['d'][ - 45][time( )];
	$sql = "select userid, register_date, email, first_name, last_name, lastlogin from users where sleeper = 0 and datediff(curdate(), lastlogin) > 45 and userid not in (select userid from pendingdelete)";

	//response.write(SQL)

	$userLists = $conn->execute($sql);
	if( !( $userLists == 0 ) ) {
		// $Mail is of type "Persits.MailSender"

		$footer = "______________________________________________________________"."\r\n"."Eldsjäl är ett community för alla som har ett intresse för "."alternativkonst, vare sig det är eld, trummor, eller dans, enda kriteriet är att"."själen står i harmoni med människan när det praktiseras."."\r\n"."\r\n"."Du behöver "."inte vara medlem för att ta del av den information som delas ut på sidan."."Registrera dig om du känner att du vill vara en del av denna massiva rörelse."."Som medlem får du en egen sida, möjlighet att ladda upp dina bilder och "."filmer samt knyta kontakter landet runt. "."\r\n"."\r\n"."Mycket nöje! // Eldsjäl"."\r\n"."______________________________________________________________";
		$reminded = 0;
		foreach( $userLists as $userList ) {
			$reminded = $reminded + 1;
			$strHost = "127.0.0.1;";
			$Mail->Host = $strHost;
			$Mail->From = "glemme@eldsjal.org";

			// From address

			$Mail->fromName = "Eldsjal.org";

			//Mail.AddAddress "eldskrift-subscribe@eldsjal.org"

			// $Mail->AddAddress$userList['email']$userList['first_name'].$userList['last_name']

			// message subject

			$Mail->Subject = "Har du glömt bort oss på Eldsjäl?";

			// message body

			$Mail->Body = "Hej! Den ".$userList['register_date']." skapade du ett konto för att bli medlem hos oss i alternativkonst-communityn Eldsjäl och vi har sett att du inte loggat in på ganska länge, sist var ".$userList['lastlogin']."."."\r\n"."\r\n"."Det här är naturligtvis ett automatiskt skrivet brev, men det är faktiskt en vettig anledning till att det skickas till dig. Vi som är medlemmar tycker det är otroligt tråkigt med en massa 'sovande' konton som kanske egentligen är helt döda. Det är dags för oss att få bekanta oss med dig igen eller att vi stryker ett streck över alltihopa och får ta bort ditt konto. Om det bara är så att du är ute på semster/turné/datorfritt land (men får trots det detta mail) eller annan anledning till att du inte loggat in men inte vill bli borttagen så kan du gå in under inställningar och kryssa i semsterknappen som kommer att lägga dig i en gräddfil. Glöm inte att trycka ur den när du är tillbaka i gängorna igen."."\r\n"."\r\n"."Välkommen tillbaka!"."\r\n"."\r\n"."Om du inte har grejat till ditt konto hos hos oss så tar vi oss friheten att ta bort det!"."\r\n"."\r\n"."Vänliga hälsningar, Elektronika @ Eldsjäl"."\r\n"."\r\n"."http://www.eldsjal.org"."\r\n"."\r\n".$footer;
			$strErr = "";

			//bSuccess = False
			// catch errors

			$Mail->Send;

			// send message

			if( $err != 0 ) {
				// error occurred

				$message = $message.

				/* don't know how to convert err.Description ;
			}
			else {
				$sql = "insert into pendingdelete (userid, pendingdate) values (".$userlist['userid'].", getdate())";
				mysql_query(( $sql ), $conn );

				//response.write("Mailade " & userList("userid"))
			}
			$Mail->resetAll;
			$userList = mysql_fetch_array( $userList_query );
		}
	}

	// DELETING USERS

	$lastDate = $dateAdd['d'][ - 3200][time( )];
	$sql = "select userid from pendingdelete where pendingdate <= '".$lastdate."'";
	$userList = $userList_query = mysql_query(( $sql ), $conn );
	$userList = mysql_fetch_array( $userList_query );;
	if( !( $userList == 0 ) ) {
		$deleted = 0;
		while( !( $userList == 0 ) ) {
			$deleted = $deleted + 1;
			$userid = $userList['userid'];

			//R.I.P-account 1590
			// Update all inserted wisdom by the user
			//response.Write("&Auml;ndrar ansvarig p&aring; alla visheter som kommer fr&aring;n anv&auml;ndaren - ")

			$sql = "update wisebox set addedbyid = ".$application['ripuser']." where addedbyid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader <br><br>")
			// Update all inserted trivias by the user
			//response.Write("&Auml;ndrar ansvarig p&aring; all trivia som kommer fr&aring;n anv&auml;ndaren - ")

			$sql = "update trivia set insertedby = ".$application['ripuser']." where insertedby = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Update all approved trivias by the user
			//response.Write("&Auml;ndrar ansvarig p&aring; godk&auml;nd trivia av anv&auml;ndaren - ")

			$sql = "update trivia set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Changes the userid of all messages sent FROM the RIP-user
			//response.Write("&Auml;ndrar avs&auml;ndare p&aring; alla meddelanden skickade FR&Aring;N anv&auml;ndaren - ")

			$sql = "update messages set messagefrom = ".$application['ripuser']." where messagefrom = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Changes the userid of all news posted FROM the user
			//response.Write("&Auml;ndrar avs&auml;ndare p&aring; alla nyheter skickade FR&Aring;N anv&auml;ndaren - ")

			$sql = "update news set newsauthor = ".$application['ripuser']." where newsauthor = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Changes the userid to the RIP-user in login-statistics
			//response.Write("Styr om alla inloggningar f&ouml;r statistikens skull - ")

			$sql = "update loginhistory set userid = ".$application['ripuser']." where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Redirect all links submitted by the users to the RIP-account
			//response.Write("Styr om alla l&auml;nkar registrerade av anv&auml;ndaren till RIP-anv&auml;ndaren - ")

			$sql = "update links set posterid = ".$application['ripuser']." where posterid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Redirect all posts to users from the deleted user to the RIP-account
			//response.Write("Styr om alla bilduppladdningar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ")

			$sql = "update images set uploadedby = ".$application['ripuser']." where uploadedby = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Redirect all posts to users from the deleted user to the RIP-account
			//response.Write("Styr om alla bildgodk&auml;nningar av anv&auml;ndaren till RIP-anv&auml;ndaren - ")

			$sql = "update images set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Redirect all posts to users from the deleted user to the RIP-account
			//response.Write("Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ")

			$sql = "update guestbook set fromuserid = ".$application['ripuser']." where fromuserid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Update the posterID to the R.I.P-id on all messages posted by the user in the forum

			print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
			$sql = "update forummessages set posterid = ".$application['ripuser']." where posterid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Update the topics that the user might have created
			//response.Write("Styr om alla forumtr&aring;dar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ")

			$sql = "update forumtopics set topicposterid = ".$application['ripuser']." where topicposterid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// If the user ever registred an event, direct to the R.I.P-user
			//response.Write("Styr om alla aktiviteter registrerad av anv&auml;ndaren till RIP-anv&auml;ndaren - ")

			$sql = "update calendarevents set userid = ".$application['ripuser']." where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			//Remove user from Userlist
			//response.Write("Tar bort anv&auml;ndare ur listan - ")

			$sql = "delete from users where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// If the user was a member of the board, remove him from the list
			//response.Write("Tar bort anv&auml;ndare ur styrelsen - ")

			$sql = "delete from board where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Delete all pending notifications
			//response.Write("Tar bort alla kalendernotifieringar - ")

			$sql = "delete from calendarnotify where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Delete all traces of the people that read the diary first, before deleting the actual diarys,
			// or else we dont know which diarys to delete
			//response.Write("Tar bort alla l&auml;smarkeringar i tankar - ")

			$sql = "delete from diaryread where diaryid in (select diaryid from diary where userid = ".$userid.")";
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Delete all dairys
			//response.Write("Tar bort alla tankar - ")

			$sql = "delete from diary where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove all friendrelation to and from the user
			//response.Write("Tar bort alla v&auml;nrelation till och fr&aring;n anv&auml;ndaren - ")

			$sql = "delete from friends where user_id = ".$userid." or friend_id = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove all guestBookentrys to and from the user
			//response.Write("Tar bort alla g&auml;stboksinl&auml;gg till anv&auml;ndaren - ")

			$sql = "delete from guestbook where touserid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove all imagescoring from the user
			//response.Write("Rensar alla po&auml;ng anv&auml;ndare satt p&aring; bilder - ")

			$sql = "delete from imagescore where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove all traces of activities that the user has participated in
			//response.Write("Tar bort alla sp&aring;r av de aktiviteter anv&auml;ndaren varit med p&aring; - ")

			$sql = "delete from joinactivity where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove all messages sent TO the user
			//response.Write("Tar bort alla meddelanden anv&auml;ndaren har f&aring;tt - ")

			$sql = "delete from messages where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove all news notifications to the user
			//response.Write("Tar bort alla nyhetsnotifieringar anv&auml;ndaren har f&aring;tt - ")

			$sql = "delete from newsnotify where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove all adoption processes
			//response.Write("Tar bort alla adoptionsprocesser som p&aring;g&aring;r f&ouml;r anv&auml;ndaren - ")

			$sql = "delete from pendingadoption where adopteeuserid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove the user from pending delete-table
			//response.Write("Tar bort anv&auml;ndaren ur tabort-k&ouml;n - ")

			$sql = "delete from pendingdelete where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove the user from the logged in-table
			//response.Write("Om anv&auml;ndaren hakat upp sig i inloggadtabellen s&aring; rensar vi bort denne d&auml;r nu - ")

			$sql = "delete from seen where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			// Remove the user from the artlist table
			//response.Write("Tar bort alla aktiviter som anv&auml;ndaren sagt sig h&aring;lla p&aring; med - ")

			$sql = "delete from userartlist where userid = ".$userid;
			mysql_query( $sql, $conn );
			$rowsaffected$adCmdText;

			//response.Write(rowsaffected & " rader<br><br>")
			//response.Write("Anv&auml;ndaren nu helt borttagen!")

			$userList = mysql_fetch_array( $userList_query );
		}
	}
*/
	// GALLERY RE-INDEXER
	//response.Write("Tar bort alla m&auml;rkta med 'Under Uppladdning'...<br>")
/*
	$sql = "delete from images where imagename = 'under uppladdning'";
	$conn->execute($sql);

	//	response.Write("Alla 'Under Uppladdning' borttagna!<br><br>")
	//response.Write("Tar bort alla bilder som saknar kategori...<br>")

	$sql = "delete from images where imageid not in (select imageid from imageartlist)";
	$conn->execute($sql);

	//response.Write("Alla bilder som inte finns representerade i imageArtList borttagna!<br><br>")
	//response.Write("Tar bort alla bilder som finns i kategorierna men inte i bildm&auml;ngden<br>")

	$sql = "delete from imageartlist where imageid not in (select imageid from images)";
	$conn->execute($sql);

	//response.Write("Alla bilder i imageArtList som inte finns i images borttagna!<br><br>")
	//response.Write("Tar bort alla bilder som har betyg satta men inte l&auml;ngre finns i m&auml;ngden...<br>")

	$sql = "delete from imagescore where fkimageid not in (select imageid from images)";
	$conn->execute($sql);

	//response.Write("Alla bilder med betyg som inte finns i images borttagna!<br><br>")
*/	
	// Statistik //

	// $datum = $formatDateTime[time( )][$vbshortDate];
	// $yesterday = $dateadd['d'][ - 1][$datum];

	$sql = "select count(*) as visitorcount from loginhistory where datediff(logintime, curdate())";
	$visitorcount = $conn->execute($sql);
	$sql = "select * from counter ";
	$statvisitors = $conn->execute($sql);
	$sql = "select count(*) as count from users where usertype = 0";
	$statsleepers = $conn->execute($sql);
	$sql = "select count(*) as count from users";
	$stattotalmembers = $conn->execute($sql);
	$sql = "select count(topicid) as topiccount from forumtopics";
	$statforumtopics = $conn->execute($sql);
	$sql = "select count(messageid) as messagecount from forummessages";
	$statforummessages = $conn->execute($sql);
	$sql = "select count(userid) as count from loginhistory";
	$statlogincount = $conn->execute($sql);
	$sql = "select count(diaryid) as count from diary";
	$statdiary = $conn->execute($sql);
	$sql = "select count(eventid) as count from calendarevents";
	$stateventcount = $conn->execute($sql);
	$sql = "select count(guestbookid) as count from guestbook";
	$statguestbook = $conn->execute($sql);
	$sql = "select count(imageid) as count from images";
	$statimages = $conn->execute($sql);
	$sql = "select count(gender) as count from users where gender = 0";
	$statgendercount = $conn->execute($sql);
	$sql = "select count(linksid) as count from links";
	$statlinkscount = $conn->execute($sql);
	$sql = "select count(*) as count from pendingdelete";
	$statpendingdeletecount = $conn->execute($sql);

	// GENERATE AVERAGE AGE VALUE
/*
	$sql = "select userid, born_year, born_month, born_date from users";
	$dbUser = $dbUser_query = mysql_query(( $sql ), $conn );
	$dbUser = mysql_fetch_array( $dbUser_query );;
	$i = 0;
	while( !( $dbUser == 0 ) ) {
		if( $dbUser['born_year'] != "" && $dbUser['born_year'] <= strftime( "%Y", time( ) ) ) {
			if( $isDate[$dbUser['born_month']."/".$dbUser['born_date']."/".$dbUser['born_year']] ) {
				///////////// &Aring;ldersber&auml;kning ////////////////////

				$birthDate = $formatDateTime[$dbUser['born_month']."/".$dbUser['born_date']."/".$dbUser['born_year']][$vbShortDate];
				$age = $age + $dateDiff['yyyy'][$birthDate][time( )( )];

				//////////////////////////////////////////////////

				$i = $i + 1;
				if( $dateDiff['yyyy'][$birthDate][time( )( )] > 26 ) {
					$above = $above + 1;
				}
				else {
					$below = $below + 1;
				}
			}
		}
		$dbUser = mysql_fetch_array( $dbUser_query );
	}
	$age = round(( $age / $i ), 1 );
	$dbUser = null;
*/
	//response.Write(SQL & "<BR>")

$age = date('Y') - current($conn->execute('SELECT AVG(born_year) FROM users'));
$above = 0;
$below = 0;

	$averageage = str_replace( ",", ".", $age );
	$sql = "insert into statistics ([date], loggedinmembers, membercount, uniquehits, forumtopics, forummessages, logincount, diarys, events, guestbooks, images, averageage, above, below, boys, girls, sleepers, links) values (getdate(),".$visitorcount['visitorcount'].",".$stattotalmembers['count'].", ".$statvisitors['count'].", ".$statforumtopics['topiccount'].", ".$statforummessages['messagecount'].", ".$statlogincount['count'].", ".$statdiary['count'].", ".$stateventcount['count'].", ".$statguestbook['count'].", ".$statimages['count'].", ".$averageage.", ".$above.", ".$below.", ".$statgendercount['count'].", ".( $stattotalmembers['count'] - $statgendercount['count'] ).", ".$statsleepers['count'].", ".$statlinkscount['count'].")";
	print $sql;
	$conn->execute($sql);

	// Send statusmail
/*
	if( $application['sendstatistics'] == 1 ) {
		// $Mail is of type "Persits.MailSender"

		$strHost = "127.0.0.1;mail.kanzieland.com";
		$Mail->Host = $strHost;
		$Mail->From = "statistics@eldsjal.org";

		// From address

		$Mail->fromName = "Statistikmaskineriet";

		//Mail.AddAddress "eldskrift-subscribe@eldsjal.org"

		$Mail->AddAddress$application['adminemail']

		// message subject

		$Mail->Subject = "Statistikmaskineriet: Rapport ".date();

		// message body

		$Mail->Body = "Antal borttagna medlemmar: ".$deleted."\r\n"."Antal p&aring;minda medlemmar: ".$reminded."\r\n"."Antal bes&ouml;k: ".$visitorCount['visitorcount']."\r\n"."Antal medlemmar: ".$statTotalMembers['count']."\r\n"."Antal bes&ouml;kare idag: ".$statvisitors['count']."\r\n"."Antal forumtr&aring;dar: ".$statForumTopics['topiccount']."\r\n"."Antal foruminl&auml;gg: ".$statForumMessages['messagecount']."\r\n"."Antal inlogg: ".$statLoginCount['count']."\r\n"."Antal tankar: ".$statDiary['count']."\r\n"."Antal aktiviteter registrerade: ".$statEventCount['count']."\r\n"."Antal g&auml;stboksinl&auml;gg: ".$statGuestBook['count']."\r\n"."Antal bilder: ".$statImages['count']."\r\n"."Medel&aring;lder: ".$Averageage."\r\n"."&Oring;ver 26: ".$above."\r\n"."Under 26: ".$below."\r\n"."Antal killar: ".$statGenderCount['count']."\r\n"."Antal tjejer: ".( $application['membercount'] - $statGenderCount['count'] )."\r\n"."Antal sovande: ".$statSleepers['count']."\r\n"."Antal l&auml;nkar: ".$statLinksCount['count']."\r\n"."Antal p&aring; v&auml;g att raderas: ".$statPendingDeleteCount['count'];
		$strErr = "";

		//response.write ("mailar" & application("adminEmail"))
		$Mail->Send;
	}
*/
?>
