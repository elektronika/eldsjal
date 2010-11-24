<h3 class="widget-title">Senaste foruminlägg:</h3>
<?php 
	$sql = "select forumcategory.forumcategoryid, forumtopics.topicname, forummessages.message, forummessages.messageid, forumtopics.topicid from forummessages inner join forumtopics on forumtopics.topicid = forummessages.topicid inner join forumcategory on forumcategory.forumcategoryid = forumtopics.forumcategoryid where forumcategory.forumsecuritylevel = 0 order by forummessages.messagedate desc limit 6";
	$messagess = $this->db->query( $sql )->result_array();
	foreach( $messagess as $messages ) {
		$message = str_replace( array("<br>", "[br]", "\n"), " ", $messages['message'] );
		$message = truncate( $message, 150);
		$message = rq($message);
		print "<div>&raquo;&nbsp;<a href=\"/forum/redirecttopost/".$messages['messageid']."\">".$messages['topicname']."</a><br/>".$message."</div><br/>";
	}
?>
