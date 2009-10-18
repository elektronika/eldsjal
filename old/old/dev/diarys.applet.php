<?php
// Last written diarys
if( $conn->type == 'mssql')
	$sql = "select top 6 diary.diaryid, diary.diarydate, diary.diarytopic, diary.userid, users.username, users.userid, users.hasimage, users.register_date from diary inner join users on diary.userid = users.userid order by diarydate desc";
else
	$sql = "select diary.diaryid, diary.diarydate, diary.diarytopic, diary.userid, users.username, users.userid, users.hasimage, users.register_date from diary inner join users on diary.userid = users.userid order by diarydate desc limit 6";

$diaryApplets = $conn->execute( $sql );
$content = '';

if(!is_array(current($diaryApplets)))
	$diaryApplets = array($diaryApplets);
foreach( $diaryApplets as $diaryApplet ) {
	$topic = substr( rqJS( $diaryApplet['diarytopic'] ), 0, 14 )."...";
	if( $_SESSION['userid'] != "" || $_SESSION['userid'] != 0 ) {
		if( $diaryApplet['hasimage'] == false ) {
			$image = "images/ingetfoto.gif";
		}
		else {
			$image = "uploads/userImages/tn_".$diaryApplet['userid'].".jpg";
		}

		$content .= "<a class=\"a2\" onMouseOver=\"return overlib('<div class=miniPicture><img src=".$image." height=45></div><div class=miniPictureText>".rqJS( $diaryApplet['diarytopic'] )."<br/>Skrivet av: ".rqJS( $diaryApplet['username'] )."<br/>".timeSince(strtotime($diaryApplet['diarydate']), ' sedan', FALSE)."</div>');\" onMouseOut=\"return nd();\" href=\"diary.php?mode=readDiary&userid=".$diaryApplet['userid']."&diaryid=".$diaryApplet['diaryid']."\">".$topic."</a><br/>";
	}
	else {
		$content .= "<a class=\"a2\" href=\"javaScript:window.alert('Den h&auml;r funktionen f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\">".$topic."</a><br/>";
	}
}
if( $_SESSION['userid'] == "" ) {
	$content .= "<br/><div><a class=\"a2\" href=\"javaScript:window.alert('Den h&auml;r funktionen f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\">Visa alla >></a></div>";
}
else {
	$content .= "<br/><div><a class=\"a2\" href=\"diary.php?mode=list\">Visa senaste >></a></div>";
}

print theme_box('nya tankar:', $content);
?>
