<?php
exit();
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
?>
<?php require_once( 'topInclude.php' );?>
<?php 
set_time_limit( 3600 );

//SQL = "SELECT userid FROM pendingDelete WHERE pendingDate <= '2003-12-30'"

$sql = "select userid from users where email = ''";
$userList = $conn->execute( $sql );
$counter = 0;
$userlists = $userlist;
foreach( $userlists as $userlist ) {
	$counter = $counter + 1;
	$userid = $userList['userid'];

	//R.I.P-account 972
	// Update all inserted wisdom by the user

	print "&Auml;ndrar ansvarig p&aring; alla visheter som kommer fr&aring;n anv&auml;ndaren - ";
	$sql = "update wisebox set addedbyid = ".$application['ripuser']." where addedbyid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader <br><br>";

	// Update all inserted trivias by the user

	print "&Auml;ndrar ansvarig p&aring; all trivia som kommer fr&aring;n anv&auml;ndaren - ";
	$sql = "update trivia set insertedby = ".$application['ripuser']." where insertedby = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Update all approved trivias by the user

	print "&Auml;ndrar ansvarig p&aring; godk&auml;nd trivia av anv&auml;ndaren - ";
	$sql = "update trivia set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Changes the userid of all messages sent FROM the RIP-user

	print "&Auml;ndrar avs&auml;ndare p&aring; alla meddelanden skickade FR&Aring;N anv&auml;ndaren - ";
	$sql = "update messages set messagefrom = ".$application['ripuser']." where messagefrom = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Changes the userid of all news posted FROM the user

	print "&Auml;ndrar avs&auml;ndare p&aring; alla nyheter skickade FR&Aring;N anv&auml;ndaren - ";
	$sql = "update news set newsauthor = ".$application['ripuser']." where newsauthor = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Changes the userid to the RIP-user in login-statistics

	print "Styr om alla inloggningar f&ouml;r statistikens skull - ";
	$sql = "update loginhistory set userid = ".$application['ripuser']." where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Redirect all links submitted by the users to the RIP-account

	print "Styr om alla l&auml;nkar registrerade av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update links set posterid = ".$application['ripuser']." where posterid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Redirect all posts to users from the deleted user to the RIP-account

	print "Styr om alla bilduppladdningar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update images set uploadedby = ".$application['ripuser']." where uploadedby = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Redirect all posts to users from the deleted user to the RIP-account

	print "Styr om alla bildgodk&auml;nningar av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update images set approvedby = ".$application['ripuser']." where approvedby = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Redirect all posts to users from the deleted user to the RIP-account

	print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update guestbook set fromuserid = ".$application['ripuser']." where fromuserid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Update the posterID to the R.I.P-id on all messages posted by the user in the forum

	print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update forummessages set posterid = ".$application['ripuser']." where posterid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Update the topics that the user might have created

	print "Styr om alla forumtr&aring;dar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update forumtopics set topicposterid = ".$application['ripuser']." where topicposterid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// If the user ever registred an event, direct to the R.I.P-user

	print "Styr om alla aktiviteter registrerad av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
	$sql = "update calendarevents set userid = ".$application['ripuser']." where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// If the user was a member of the board, remove him from the list

	print "Tar bort anv&auml;ndare ur styrelsen - ";
	$sql = "delete from board where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Delete all pending notifications

	print "Tar bort alla kalendernotifieringar - ";
	$sql = "delete from calendarnotify where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Delete all traces of the people that read the diary first, before deleting the actual diarys,
	// or else we dont know which diarys to delete

	print "Tar bort alla l&auml;smarkeringar i tankar - ";
	$sql = "delete from diaryread where diaryid in (select diaryid from diary where userid = ".$userid.")";
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Delete all dairys

	print "Tar bort alla tankar - ";
	$sql = "delete from diary where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove all friendrelation to and from the user

	print "Tar bort alla v&auml;nrelation till och fr&aring;n anv&auml;ndaren - ";
	$sql = "delete from friends where user_id = ".$userid." or friend_id = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove all guestBookentrys to and from the user

	print "Tar bort alla g&auml;stboksinl&auml;gg till anv&auml;ndaren - ";
	$sql = "delete from guestbook where touserid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove all imagescoring from the user

	print "Rensar alla po&auml;ng anv&auml;ndare satt p&aring; bilder - ";
	$sql = "delete from imagescore where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove all traces of activities that the user has participated in

	print "Tar bort alla sp&aring;r av de aktiviteter anv&auml;ndaren varit med p&aring; - ";
	$sql = "delete from joinactivity where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove all messages sent TO the user

	print "Tar bort alla meddelanden anv&auml;ndaren har f&aring;tt - ";
	$sql = "delete from messages where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove all news notifications to the user

	print "Tar bort alla nyhetsnotifieringar anv&auml;ndaren har f&aring;tt - ";
	$sql = "delete from newsnotify where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove all adoption processes

	print "Tar bort alla adoptionsprocesser som p&aring;g&aring;r f&ouml;r anv&auml;ndaren - ";
	$sql = "delete from pendingadoption where adopteeuserid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove the user from the logged in-table

	print "Om anv&auml;ndaren hakat upp sig i inloggadtabellen s&aring; rensar vi bort denne d&auml;r nu - ";
	$sql = "delete from seen where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove the user from the artlist table

	print "Tar bort alla aktiviter som anv&auml;ndaren sagt sig h&aring;lla p&aring; med - ";
	$sql = "delete from userartlist where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	// Remove the user from pending delete-table

	print "Tar bort anv&auml;ndaren ur tabort-k&ouml;n - ";
	$sql = "delete from pendingdelete where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";

	//Remove user from Userlist

	print "Tar bort anv&auml;ndare ur listan - ";
	$sql = "delete from users where userid = ".$userid;
	$conn->execute$sql$rowsaffected$adCmdText;
	print $rowsaffected." rader<br><br>";
	print "Anv&auml;ndaren nu helt borttagen!<hr>";

	//  $userList->moveNext;
}
print "<br><br><br>".$counter." anv&auml;ndare borttagna!";
?>
