<?php 
print "<span class=plainTHead>Senaste foruminl&auml;gg:</span><br/>";
if( $application['systemforumcount'] > 0 ) {
	$sql = "select forumcategoryname, forumcategoryid from forumcategory where forumsecuritylevel = 0 order by forumcategorysortorder";
	$categorys = $conn->execute( $sql );
	print "<table border=0 width=450 cellpadding=0 cellspacing=0>";
	$categoryss = $categorys;
	foreach( $categoryss as $categorys ) {
		$sql = "select topicname, topicid, forumcategoryid from forumtopics where forumcategoryid = ".$categorys['forumcategoryid']." order by latestentry desc limit ".$application['systemforumcount'];
		$topics = $conn->execute( $sql );
		print "<tr><td class='plainTHead2' BGCOLOR='#E4C898' COLSPAN='2'><b><a href=forum.php?category=".$categorys['forumcategoryid'].">".$categorys['forumcategoryname']."</a></b></td></tr>";
		if( $topics ) {
			print "<tr><td class='plaintext' COLSPAN='2'><i>No topics present</i></td></tr>";
		}
		else {
			$topicss = $topics;
			foreach( $topicss as $topics ) {
				print "<tr><td class='plaintext'><B>-</B></td><td class='plaintext'><B><a class=a2 href=forum.php?mode=readTopic&category=".$topics['forumcategoryid']."&threadid=".$topics['topicid'].">".$topics['topicname']."</a></B></td></tr>";
				$sql = "select message from forummessages where topicid = ".$topics['topicid']." order by messagedate desc limit 1";
				$message = $conn->execute( $sql );
				if( $message ) {
					$messageFormat = str_replace( "<br/>", "", $message['message'] );
					$messageFormat = str_replace( "[br]", "", $message['message'] );

					//message = left(cq(message("message")), 130) & "..."

					$message = substr( $messageFormat, 0, 150 )."...";
					print "<tr><td class='plaintext'><B>&nbsp;</B></td><td class='plaintext'>".$message."</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
				}
				else {
					print "<tr><td class='plaintext'><i>No information</i></td></tr>";
				}

				//        $topics->moveNext;
			}
		}
		print "<tr><td COLSPAN='2'>&nbsp;</td></tr>";

		//    $categorys->moveNext;
	}
	print "</table>";
	$categorys = null;
	$topics = null;
}
?>

