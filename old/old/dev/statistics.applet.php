<?php
//	SQL = "SELECT count(userid) AS sleepers FROM users WHERE redirect <> ''"
//	SET statuserList = conn.execute(SQL)
//	SQL = "SELECT * FROM counter "
//	SET statvisitors = conn.execute(SQL)
//	SQL = "SELECT COUNT(topicID) AS topicCount FROM forumTopics"
//	SET statforumTopics = conn.execute(SQL)
//	SQL = "SELECT COUNT(messageID) AS messageCount FROM forumMessages"
//	SET statforumMessages= conn.execute(SQL)
//
//	SQL = "SELECT COUNT(userid) AS Count FROM loginHistory"
//	SET statLoginCount = conn.execute(SQL)
//
//	SQL = "SELECT COUNT(diaryID) AS Count FROM diary"
//	SET statDiary= conn.execute(SQL)
//
//	SQL = "SELECT count(eventid) AS count FROM calendarEvents"
//	SET statEventCount = conn.execute(SQL)
//
//	SQL = "SELECT count(guestBookID) AS count FROM guestBook"
//	SET statGuestBook = conn.execute(SQL)
//
//	SQL = "select count(gender) AS count from users where gender = 0"
//	SET statGenderCount = conn.execute(SQL)
//
//	SQL = "SELECT count(imageid) AS count FROM images"
//	SET statImages = conn.execute(SQL)
if( $conn->type == 'mssql')
	$sql = "select top 1 * from [statistics] order by statisticsid desc";
else
	$sql = "select * from statistics order by statisticsid desc limit 1";
	
$statistics = $conn->execute( $sql );

$start_date = mktime( 0, 0, 0, 5, 1, 2003 );
$diff = time( ) - $start_date;
$age = round( $diff / ( 3600 * 24 ) );
$content = "Medlemmar: ".$statistics['membercount']."<br/>Sovande: ".$statistics['sleepers']."<br/>Killar: ".$statistics['boys']."<br/>Tjejer: ".( $statistics['membercount'] - $statistics['boys'] )."<br/>Medel&aring;lder: ".$statistics['averageage']."<br/>26 & &ouml;ver: ".$statistics['above']."<br/>Under 26: ".$statistics['below']."<br/>Funnits i ".$age." dagar "."<br/>Unika bes&ouml;k: ".$statistics['uniquehits']."<br/>Forumtr&aring;dar: ".$statistics['forumtopics']."<br/>Foruminl&auml;gg: ".$statistics['forummessages']."<br/>Total inlogg: ".$statistics['logincount']."<br/>Tankar: ".$statistics['diarys']."<br/>Aktiviteter: ".$statistics['events']."<br/>G&auml;stboksinl&auml;gg: ".$statistics['guestbooks']."<br/>Bilder: ".$statistics['images']."<br/>";

//	SET statuserList = nothing
//	SET statvisitors = nothing
//	SET statforumTopics = nothing
//	SET statforumMessages = nothing
//	SET statLoginCount = nothing
//	SET statDiary = nothing
//	SET statEventCount = nothing
//	SET statGuestBook = nothing
//	SET statImages = nothing
print theme_box('Eldsjälsstatus', $content);

?>
