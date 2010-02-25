<h3>Nya tankar</h3>
<?php
$sql = "select diary.diaryid, diary.diarydate, diary.diarytopic, diary.userid, users.username, users.userid, users.hasimage, users.register_date from diary inner join users on diary.userid = users.userid order by diarydate desc limit 6";

$thoughts = $this->db->query($sql)->result();
foreach($thoughts as &$thought) {
	$thought->topic = substr( rqJS( $thought->diarytopic), 0, 14 )."...";
	$thought->diarytopic = rqJS($thought->diarytopic);
	$thought->username = rqJS($thought->username);
	$thought->timesince = timeSince(strtotime($thought->diarydate), ' sedan', FALSE);
	$thought->image = $thought->hasimage ? "/uploads/userImages/tn_".$thought->userid.".jpg" : "/images/ingetfoto.gif";
}
	
?>
<ul id="latestthoughts" class="flat">
<?php foreach( $thoughts as $thought ): ?>
	<?php if($this->session->isloggedin()): ?>
		<li><a onMouseOver="return overlib('<div class=miniPicture><img src=<?php echo $thought->image; ?> height=45></div><div class=miniPictureText><?php echo $thought->diarytopic; ?><br>Skrivet av: <?php echo $thought->username; ?><br/><?php echo $thought->timesince; ?></div>');" onMouseOut="return nd();" href="/thoughts/view/<?php echo $thought->diaryid; ?>"><?php echo $thought->topic; ?></a></li>
	<?php else: ?>
		<li><a href="javaScript:window.alert('Den här funktionen får du tillgång till när du registrerar dig och blir medlem, smutt va?');"><?php echo $thought->topic; ?></a></li>
	<?php endif?>
<?php endforeach; ?>
</ul>

<p>
<?php if( $this->session->isloggedin()): ?>
	<a href="/thoughts">Visa senaste >></a>
<?php else: ?>
	<a href="javaScript:window.alert('Den här funktionen får du tillgång till när du registrerar dig och blir medlem, smutt va?');\">Visa alla >></a>
<?php endif; ?>
</p>