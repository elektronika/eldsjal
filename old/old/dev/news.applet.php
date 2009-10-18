<?php
//session_start();


?>
<!-- Start NewsTable -->
<!-- Start NewsItem -->
<br/><br/>
<?php 
if( $conn->type == 'mssql' )
	$sql = "select top ".$application['systemnewsitems']." newsid, newsdate, newsheader, newsingress, newsurl, newsurldesc, newsimagename from news order by newsdate desc";
else
	$sql = "select newsid, newsdate, newsheader, newsingress, newsurl, newsurldesc, newsimagename from news order by newsdate desc limit ".$application['systemnewsitems'];
$newss = $conn->execute( $sql );
print "<TABLE BORDER=0 width=\"100%\" CELLPADDING=0 CELLSPACING=0><tr><td class='plainTHead2' BGCOLOR='#E4C898'><b>Nyheter</b></td><td class='plainTHead2' BGCOLOR='#E4C898'><a href=news.php class=a2>Nyhetsarkiv</a></b></td></tr><tr><td colspan=2>&nbsp;</td></tr></table>";

/*if ($news)
{

print "<i>Inga nyheter!</i>";
}
else
{
*/
//print_r($newss);

foreach( $newss as $news ) {
	print "<TABLE BORDER=0 width=\"100%\" CELLPADDING=0 CELLSPACING=0><tr>";
	if( strlen( $news['newsimagename'] ) > 1 ) {
		print "<td rowspan=4><img src=images/news/tn_".strtolower($news['newsimagename'])." BORDER=0></td><td rowspan=4 width=10><img src=images/1x1.gif HEIGHT=1 WIDTH=10 BORDER=0></TD>";
	}
	print "<td class=plainTHead2 width=200 >".$news['newsheader']."</td><td>";
	if( $_SESSION['usertype'] >= intval( $application['newsadmin'] ) ) {
		print "<a href=News.php?mode=updateNews&newsID=".$news['newsid']."><img src=/images/icons/edit.gif border=0></a><a href=News.php?mode=deleteNews&newsID=".$news['newsid']."><img src=/images/icons/trashcan.gif border=0></a>";
	}
	print $news['newsdate']."</td></tr>";
	print "<tr><td class=plainText colspan=2>".rq( $news['newsingress'] )."</td></tr>";
	print "<tr><td colspan=2><br/><a class=a2 href=".$news['newsurl']." target=_blank>";
	if( $news['newsid'] != 39 ) {
		if( $news['newsurldesc'] != "" ) {
			$URL = $news['newsurldesc'];
			if( isset( $_GET['newsid'] ) && $_GET['newsid'] == "" ) {
				$URL = substr( $news['newsurldesc'], 0, 50 )."...";
			}
			print $URL."</a>";
		}
		else {
			if( $URL != "" ) {
				if( $_GET['newsid'] == "" ) {
					$URL = substr( $news['newsurl'], 0, 50 )."...";
				}
				print $URL."</a>";
			}
		}
	}
	print "</td></tr>";
	print "<tr><td colspan=2><a href=news.php?newsID=".$news['newsid']." class=a2>L&auml;s mer &nbsp;<img src=images/icons/arrows.gif width=20 height=11 border=0></a>";
	print "</td></tr><tr><td colspan=4><img src=images/1x1.gif height=20 width=1 border=0><br/><hr></td></tr></table>";

	//    //$news->moveNext;
}

//}

?>
<!-- End NewsItem -->
