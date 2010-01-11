<?php
//session_start();

session_register( "userType_session" );
?>
<!-- Start NewsTable -->
<!-- Start NewsItem -->
<br><br>
<?php 
// $sql = "select newsid, newsdate, newsheader, newsingress, newsurl, newsurldesc, newsimagename from news order by newsdate desc limit ".$application['systemnewsitems'];
$sql = "SELECT fm.message, ft.topicname, fm.messagedate, fm.posterid, ft.topicid, u.username FROM forumtopics AS ft JOIN forummessages AS fm ON ft.topicid = fm.topicid JOIN users AS u ON fm.posterid = u.userid WHERE ft.forumcategoryid = 19 GROUP BY ft.topicid ORDER BY fm.messagedate DESC LIMIT 2";
$newss = $conn->execute( $sql );
print "<TABLE BORDER=0 width=\"100%\" CELLPADDING=0 CELLSPACING=0><tr><td CLASS='plainTHead2' BGCOLOR='#E4C898'><b>Nyheter</b></td><td align=right CLASS='plainTHead2' BGCOLOR='#E4C898'><a href='forum.php?category=19' class=a2>Nyhetsarkiv</a></b></td></tr><tr><td colspan=2>&nbsp;</td></tr></table>";

/*if ($news)
{

  print "<i>Inga nyheter!</i>";
}
  else
{
*/
//print_r($newss);
if( ! is_array(current($newss)))
	$newss = array($newss);
	
foreach( $newss as $news ) {
	if(strlen($news['message']) > 200)
		$news['message'] = trim(substr($news['message'], 0, 180)).'...';
	print "<TABLE BORDER=0 width=\"100%\" CELLPADDING=0 CELLSPACING=0><tr>";
	// if( strlen( $news['newsimagename'] ) > 1 ) {
	// 		print "<td valign=top align=left rowspan=4><IMG SRC=uploads/news/tn_".strtolower($news['newsimagename'])." BORDER=0></td><td valign=top rowspan=4 width=10><IMG SRC=images/1x1.gif HEIGHT=1 WIDTH=10 BORDER=0></TD>";
	// 	}
	print "<td class=plainTHead2 width=200 valign=top >".$news['topicname']."</td><td valign=top align=right>";
	// if( $_SESSION['usertype'] >= intval( $application['newsadmin'] ) ) {
	// 		print "<a href=News.php?mode=updateNews&newsID=".$news['newsid']."><img src=/images/icons/edit.gif border=0></a><a href=News.php?mode=deleteNews&newsID=".$news['newsid']."><img src=/images/icons/trashcan.gif border=0></a>";
	// 	}
	print timeSince(strtotime($news['messagedate']))."</td></tr>";
	print "<tr><td class=plainText colspan=2 valign=top>".rq( $news['message'] )."</td></tr>";
	// print "<tr><td colspan=2 valign=top><br><a class=a2 href=".$news['newsurl']." target=_blank>";
	// if( $news['newsid'] != 39 ) {
	// 	if( $news['newsurldesc'] != "" ) {
	// 		$URL = $news['newsurldesc'];
	// 		if( isset( $_GET['newsid'] ) && $_GET['newsid'] == "" ) {
	// 			$URL = substr( $news['newsurldesc'], 0, 50 )."...";
	// 		}
	// 		print $URL."</a>";
	// 	}
	// 	else {
	// 		if( $URL != "" ) {
	// 			if( $_GET['newsid'] == "" ) {
	// 				$URL = substr( $news['newsurl'], 0, 50 )."...";
	// 			}
	// 			print $URL."</a>";
	// 		}
	// 	}
	// }
	print "</td></tr>";
	print "<tr><td colspan=2 valign=top align=right><a href=forum.php?mode=readTopic&category=19&threadid=".$news['topicid']." class=a2>L&auml;s mer &nbsp;<img src=images/icons/arrows.gif width=20 height=11 border=0></a>";
	print "</td></tr><tr><td colspan=4><img src=images/1x1.gif height=20 width=1 border=0><br><hr></td></tr></table>";

	//    //$news->moveNext;
}

//}

?>
<!-- End NewsItem -->
