<br><br>
<?php 
$sql = "SELECT fm.message, ft.topicname, fm.messagedate, fm.posterid, ft.topicid, u.username FROM forumtopics AS ft JOIN forummessages AS fm ON ft.topicid = fm.topicid JOIN users AS u ON fm.posterid = u.userid WHERE ft.forumcategoryid = 19 GROUP BY ft.topicid ORDER BY fm.messagedate DESC LIMIT 2";
$newss = $conn->execute( $sql );
print "<TABLE BORDER=0 width=\"100%\" CELLPADDING=0 CELLSPACING=0><tr><td CLASS='plainTHead2' BGCOLOR='#E4C898'><b>Nyheter</b></td><td align=right CLASS='plainTHead2' BGCOLOR='#E4C898'><a href='/forum/category/19' class=a2>Nyhetsarkiv</a></b></td></tr><tr><td colspan=2>&nbsp;</td></tr></table>";

if( ! is_array(current($newss)))
	$newss = array($newss);
	
foreach( $newss as $news ) {
	if(strlen($news['message']) > 200)
		$news['message'] = trim(substr($news['message'], 0, 180)).'...';
	print "<TABLE BORDER=0 width=\"100%\" CELLPADDING=0 CELLSPACING=0><tr>";
	print "<td class=plainTHead2 width=200 valign=top >".$news['topicname']."</td><td valign=top align=right>";
	print timeSince(strtotime($news['messagedate']))."</td></tr>";
	print "<tr><td class=plainText colspan=2 valign=top>".rq( $news['message'] )."</td></tr>";
	print "</td></tr>";
	print "<tr><td colspan=2 valign=top align=right><a href=/forum/topic/".$news['topicid']." class=a2>L&auml;s mer &nbsp;<img src=images/icons/arrows.gif width=20 height=11 border=0></a>";
	print "</td></tr><tr><td colspan=4><img src=images/1x1.gif height=20 width=1 border=0><br><hr></td></tr></table>";
}
?>
