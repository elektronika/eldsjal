<?php 
$sql = "SELECT fm.message, ft.topicname, fm.messagedate, fm.posterid, ft.topicid, u.username FROM forumtopics AS ft JOIN forummessages AS fm ON ft.topicid = fm.topicid JOIN users AS u ON fm.posterid = u.userid WHERE ft.forumcategoryid = 19 GROUP BY ft.topicid ORDER BY fm.messagedate DESC LIMIT 2";
$news = $this->db->query( $sql )->result();
?>
<h3>Nyheter</h3>
<?php foreach( $news as $topic ): ?>
<div class="news">
	<h4><a href="/forum/topic/<?php echo $topic->topicid; ?>"><?php echo $topic->topicname; ?></a> <span class="meta"><?php echo timesince(strtotime($topic->messagedate)); ?></span></h4>
	<p><?php echo truncate(rq($topic->message), 200); ?></p>
</div>
<?php endforeach; ?>
<p><a href='/forum/category/19'>Mer nyheter &raquo;</a></p>