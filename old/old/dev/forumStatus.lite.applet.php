<?php 
print "<span class=plainTHead>Senaste foruminl&auml;gg:</span><br/>";
if( $application['systemforumcount'] > 0 ) {
	print "<table border=0 width=450 cellpadding=0 cellspacing=0>";
	if( $conn->type == 'mssql' )
		$sql = "select top ".$application['systemforumcount']." forumcategory.forumcategoryid, forumtopics.topicname, forummessages.message, forumtopics.topicid from forummessages inner join forumtopics on forumtopics.topicid = forummessages.topicid inner join forumcategory on forumcategory.forumcategoryid = forumtopics.forumcategoryid where forumcategory.forumsecuritylevel = 0 order by forummessages.messagedate desc";
	else
		$sql = "select forumcategory.forumcategoryid, forumtopics.topicname, forummessages.message, forumtopics.topicid from forummessages inner join forumtopics on forumtopics.topicid = forummessages.topicid inner join forumcategory on forumcategory.forumcategoryid = forumtopics.forumcategoryid where forumcategory.forumsecuritylevel = 0 order by forummessages.messagedate desc limit ".$application['systemforumcount'];
	$messagess = $conn->execute( $sql );
	foreach( $messagess as $messages ) {
		$messageFormat = str_replace( "<br/>", " ", $messages['message'] );
		$messageFormat = str_replace( "[br]", " ", $messages['message'] );
		$message = substr( $messageFormat, 0, 150 )."...";
		$message = rq($message);
		print "<tr><td colspan=\"2\">&raquo;&nbsp;<a href=\"forum.php?mode=readTopic&category=".$messages['forumcategoryid']."&threadid=".$messages['topicid']."\" class=\"a2\">".$messages['topicname']."</td></tr><tr><td class='plaintext'><B>&nbsp;</B></td><td class='plaintext'>".$message."</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
	}
	print "<tr><td COLSPAN='2'>&nbsp;</td></tr></table>";
	$messages = null;
}
?>

