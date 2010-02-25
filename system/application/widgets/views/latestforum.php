<?php 
print "<span class=plainTHead>Senaste foruminl&auml;gg:</span><br>";
	print "<table border=0 width=450 cellpadding=0 cellspacing=0>";
	$sql = "select forumcategory.forumcategoryid, forumtopics.topicname, forummessages.message, forummessages.messageid, forumtopics.topicid from forummessages inner join forumtopics on forumtopics.topicid = forummessages.topicid inner join forumcategory on forumcategory.forumcategoryid = forumtopics.forumcategoryid where forumcategory.forumsecuritylevel = 0 order by forummessages.messagedate desc limit 6";
	$messagess = $this->db->query( $sql )->result_array();
	foreach( $messagess as $messages ) {
		$messageFormat = str_replace( "<br>", " ", $messages['message'] );
		$messageFormat = str_replace( "[br]", " ", $messages['message'] );
		$message = mb_substr( $messageFormat, 0, 150 )."...";
		$message = rq($message);
		print "<tr><td colspan=\"2\">&raquo;&nbsp;<a href=\"/forum/redirecttopost/".$messages['messageid']."\" class=\"a2\">".$messages['topicname']."</td></tr><tr><td CLASS='plaintext'><B>&nbsp;</B></td><td CLASS='plaintext'>".$message."</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
	}
	print "<tr><td COLSPAN='2'>&nbsp;</td></tr></table>";
	$messages = null;
?>

