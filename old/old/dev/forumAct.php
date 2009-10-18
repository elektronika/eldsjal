<?php
session_start( );





require_once( 'header.php' );

ob_start( );

//response.Expires = 10
// $Conn is of type "adodb.connection"
/*$a2p_connstr=$Application['eldsjaldb'];
$a2p_uid=strstr($a2p_connstr,'uid');
$a2p_uid=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$a2p_pwd=strstr($a2p_connstr,'pwd');
$a2p_pwd=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$a2p_database=strstr($a2p_connstr,'dsn');
$a2p_database=substr($d,strpos($d,'=')+1,strpos($d,';')-strpos($d,'=')-1);
$Conn=mysql_connect("localhost",$a2p_uid,$a2p_pwd);
mysql_select_db($a2p_database,$Conn);
*/
// illegal entry

if( $_SESSION['userid'] == "" ) {
	header( "Location: "."forum.php?message=Du har inte r&auml;ttigheter att &auml;ndra denna post!" );
}

/*
//Check and validate user input
function cq($content)
{
extract($GLOBALS);

//content = Server.HTMLEncode(content)
$content=str_replace("\r\n","[br]",$content);
$content=str_replace("<br/>","[br]",$content);
htmlspecialchars(substr($content,0,1));
$content=str_replace(";","&#59;",$content);
$content=str_replace(",","&#44;",$content);
$content=str_replace("'","&#39;",$content);
$content=str_replace("\"","&#34;",$content);
$content=str_replace("<","[",$content);
$content=str_replace(">","]",$content);

//Disabled to remove HTML-support in input
//content= replace(content, "<", "&lt;") 
//content= replace(content, ">", "&gt;")
$function_ret=$content;
return $function_ret;
} 

//reverse user input
function rq($content)
{
extract($GLOBALS);

$content=str_replace("&#59;",";",$content);
$content=str_replace("&#44;",",",$content);
$content=str_replace("&#39;","'",$content);
$content=str_replace("&#34;","\"",$content);
$content=str_replace("&lt;","<",$content);
$content=str_replace("&gt;",">",$content);
$content=str_replace("\r\n","<br/>",$content);
$content=str_replace("[br]","<br/>",$content);
$function_ret=$content;
return $function_ret;
} 
*/

if( isset( $_GET['mode'] ) && $_GET['mode'] == "addEntry" ) {
	$message = CQ( $_POST['message'] );
	$topic = CQ( $_POST['topic'] );
	$sql = "insert into forumtopics (topicname, topicposterid, topicdate, latestentry, totalentrys, forumcategoryid, sticky) values ('".$topic."', ".$_SESSION['userid'].", getdate(), getdate(), 0, ".intval( $_POST['categoryid'] ).", ".intval( $_POST['sticky'] ).")";
	$storeTopic = $conn->execute( $sql );;
	$sql = "select max(topicid) as sid from forumtopics";
	$maxThread = $conn->execute( $sql );;
	$sql = "select forumcategorythreads from forumcategory where forumcategoryid = ".intval( $_POST['categoryid'] );
	$addStats = $conn->execute( $sql );;
	$stats = $addStats['forumcategorythreads'] + 1;
	$sql = "update forumcategory set forumcategorythreads = ".$stats.", forumcategorylatestpost = getdate() where forumcategoryid = ".intval( $_POST['categoryid'] );
	$addStats = $conn->execute( $sql );;

	//topicID ligger nu i storeTopic("sid") i form av enkel integer
	$sql = "insert into forummessages (message, topicid, posterid, messagedate) values ('".$message."', '".$maxThread['sid']."', ".$_SESSION['userid'].", getdate())";
	$storeMessage = $conn->execute( $sql );;

	//Update cookie so that all from this now() is read... complication if two posts with identical dates has been written
	//response.Cookies("eldsjalForumRead") = CDate(latestPostDate("latestEntry"))

	setcookie( "eldsjalForumRead", time( ), 0, "", "", 0 );
	$message = "Tr&aring;den \"".$topic."\" &auml;r nu registrerad";
	header( "Location: "."forum.php?threadid=".$maxThread['sid']."&category=".$_POST['categoryid']."&message=".$message );

	//Temporary vote-thingie
	//elseif request.QueryString("mode") = "addVote" then
	//	if session("userName") = "" then response.redirect("main.php?message=Du &auml;r inte inloggad och kan d&auml;rf&ouml;r inte utf&ouml;ra detta")
	//
	//	SQL = "SELECT * from forumMessages WHERE message = 'Jag st&ouml;djer Christian Kanzie Nilssons f&ouml;rslag!' AND topicID = 894 AND posterID = " & session("userid")
	//	set voteCheck = conn.execute(SQL)
	//
	//	if not voteCheck.eof then response.Redirect("forum.php?mode=readTopic&category=3&threadid=894&message=Du har redan lagt ditt f&ouml;rtroende f&ouml;r Christian, du kan manuellt ta bort din r&ouml;st om du k&auml;nner att det blivit fel!")
	//
	//	SQL = "INSERT INTO forumMessages (message, topicid, posterid, messageDate) VALUES ('Jag st&ouml;djer Christian Kanzie Nilssons f&ouml;rslag!', 894, " & session("userid") & ", '" & now() & "')"
	//	 SET storeMessage = conn.execute(SQL)
	//	SQL = "SELECT totalEntrys FROM forumTopics WHERE topicid = 894"
	//	 SET getTotal = conn.execute(SQL)
	//	SQL = "UPDATE forumTopics SET latestEntry = '" & now() & "', totalEntrys =  " & getTotal("totalEntrys") + 1 & " WHERE topicid = 894"
	//	 SET storeMessage = conn.execute(SQL)
	//	SQL ="UPDATE forumCategory SET forumCategoryLatestPost = '" & now() & "' WHERE forumcategoryid = 3"
	//	 SET addStats = conn.execute(SQL)
	//	 response.Redirect("forum.php?mode=readTopic&category=3&threadid=894&message=Tack s&aring; mycket f&ouml;r ditt f&ouml;rtroende och st&ouml;d!")
	//
}
elseif( $_GET['mode'] == "addReply" ) {
	if( $_GET['threadid'] == "" ) {
		header( "Location: "."forum.php?message=Ingen tr&aring;d angedd" );
	}
	$reply = CQ( $_POST['message'] );
	$sql = "insert into forummessages (message, topicid, posterid, messagedate) values ('".$reply."', '".intval( $_GET['threadid'] )."', ".$_SESSION['userid'].", getdate())";
	$storeMessage = $conn->execute( $sql );;
	$sql = "select totalentrys from forumtopics where topicid = ".intval( $_GET['threadid'] );
	$getTotal = $conn->execute( $sql );;
	$sql = "update forumtopics set latestentry = getdate(), totalentrys =  ".($getTotal['totalentrys']+1)." where topicid = ".intval( $_GET['threadid'] );
	$storeMessage = $conn->execute( $sql );;
	$sql = "update forumcategory set forumcategorylatestpost = getdate() where forumcategoryid = ".intval( $_POST['categoryid'] );
	$addStats = $conn->execute( $sql );;
	$message = "Reply stored";
	header( "Location: "."forum.php?mode=readTopic&category=".$_POST['categoryid']."&threadid=".$_GET['threadid']."&message=".$message );
}
elseif( $_GET['mode'] == "updateTopic" ) {
	if( $_SESSION['usertype'] < $application['forumadmin'] ) {
		$sql = "select topicposterid from forumtopics where topicid = ".intval( $_GET['topicid'] );
		$conn->execute( $sql );;
		if(( $result == 0 ) ) {
			header( "Location: "."forum.php?category=".$_GET['category']."&message=You are not moderator or owner of this topic, therefor you can not update it!" );
		}
	}
	$sql = "select forumcategoryid from forumtopics where topicid = ".intval( $_POST['topicid'] );
	$threadCount = $conn->execute( $sql );;
	$sql = "update forumtopics set topicname = '".cq( $_POST['topicname'] )."', forumcategoryid = ".intval( $_POST['categoryid'] ).", sticky = ".intval( $_POST['sticky'] )." where topicid = ".intval( $_POST['topicid'] );
	$conn->execute( $sql );
	if( intval( $threadCount['forumcategoryid'] ) != intval( $_POST['categoryid'] ) ) {
		//Remove one thread from old category

		$sql = "select forumcategorythreads from forumcategory where forumcategoryid = ".$threadCount['forumcategoryid'];
		$removeThread = $conn->execute( $sql );;
		$sql = "update forumcategory set forumcategorythreads = ".$removethread['forumcategorythreads']--." where forumcategoryid = ".$threadCount['forumcategoryid'];
		$conn->execute( $sql );

		//Add one thread to new category

		$sql = "select forumcategorythreads from forumcategory where forumcategoryid = ".intval( $_POST['categoryid'] );
		$removeThread = $conn->execute( $sql );;
		$sql = "update forumcategory set forumcategorythreads = ".$removeThread['forumcategorythreads']++." where forumcategoryid = ".intval( $_POST['categoryid'] );
		$conn->execute( $sql );
		header( "Location: "."forum.php?category=".$_POST['categoryid']."&message=Tr&aring;den uppdaterad!" );
	}
	header( "Location: "."forum.php?category=".$_GET['category']."&message=Tr&aring;den uppdaterad!" );
}
elseif( $_GET['mode'] == "updatePost" ) {
	if( $_SESSION['usertype'] < $application['forumadmin'] ) {
		$sql = "select posterid from forummessages where messageid = ".doubleval( $_POST['messageid'] );
		$result = $conn->execute( $sql );;
		if(( $result == 0 ) ) {
			header( "Location: "."forum.php?mode=readTopic&category=".$_GET['category']."&threadid=".$_GET['threadid']."&message=You are not moderator or owner of this post, therefor you can not edit it!" );
		}
	}
	$message = cq( $_POST['message'] );
	$sql = "update forummessages set message = '".$message."', messagedate = getdate() where messageid = ".doubleval( $_POST['messageid'] );
	$conn->execute( $sql );
	$sql = "update forumtopics set latestentry = getdate() where topicid = ".intval( $_GET['threadid'] );
	$conn->execute( $sql );
	$sql = "update forumcategory set forumcategorylatestpost = getdate() where forumcategoryid = ".intval( $_GET['category'] );
	$conn->execute( $sql );
	$message = "Reply stored";
	header( "Location: "."forum.php?mode=readTopic&category=".$_GET['category']."&threadid=".$_GET['threadid']."&message=".$message );
}
elseif( $_GET['mode'] == "deleteTopic" ) {
	if( $_SESSION['usertype'] < $application['forumadmin'] ) {
		$sql = "select topicposterid from forumtopics where topicid = ".intval( $_GET['topicid'] );
		$result = $conn->execute( $sql );;
		if( !$result ) {
			header( "Location: "."forum.php?category=".$_GET['category']."&message=Du &auml;r varken moderator eller &auml;gare till den post, d&auml;rf&ouml;r kan du inte ta bort den!" );
		}
	}

	//remove post

	$sql = "delete from forummessages where topicid = ".intval( $_GET['topicid'] );
	$conn->execute( $sql );
	$sql = "delete from forumtopics where topicid = ".intval( $_GET['topicid'] );
	$conn->execute( $sql );

	//REDUCE TOPICCOUNT AT CATEGORYLEVEL

	$sql = "select forumcategorythreads from forumcategory where forumcategoryid = ".intval( $_GET['category'] );
	$getTotal = $conn->execute( $sql );;
	$totalThreads = $getTotal['forumcategorythreads'] - 1;
	if( $totalThreads < 0 ) {
		$totalThreads = 0;
	}
	$sql = "update forumcategory set forumcategorythreads = ".intval( $totalThreads )." where forumcategoryid = ".intval( $_GET['category'] );
	$conn->execute( $sql );
	header( "Location: "."forum.php?category=".$_GET['category']."&message=Tr&aring;den borttagen!" );
}
elseif( $_GET['mode'] == "deletePost" ) {
	if( $_SESSION['usertype'] < $application['forumadmin'] ) {
		$sql = "select posterid from forummessages where messageid = ".intval( $_GET['messageid'] );
		$result = $conn->execute( $sql );;
		if(( $result == 0 ) ) {
			header( "Location: "."forum.php?mode=readTopic&category=".$_GET['category']."&threadid= ".$_GET['threadid']."&message=Du &auml;r varken moderator eller &auml;gare till den post, d&auml;rf&ouml;r kan du inte ta bort den!" );
		}
	}

	//remove post

	$sql = "delete from forummessages where messageid = ".intval( $_GET['messageid'] );
	$conn->execute( $sql );

	// reduce messagecounter

	$sql = "select totalentrys from forumtopics where topicid = ".intval( $_GET['threadid'] );
	$getTotal = $conn->execute( $sql );;
	$sql = "update forumtopics set totalentrys =  ".$getTotal['totalentrys']--." where topicid = ".intval( $_GET['threadid'] );
	$storeMessage = $conn->execute( $sql );;
	header( "Location: "."forum.php?mode=readTopic&category=".$_GET['category']."&threadid=".$_GET['threadid']."&message=Post borttagen!" );
}
else {
	header( "Location: "."forum.php?message=Nu halkade du snett, b&ouml;rja om!" );
}
?>
