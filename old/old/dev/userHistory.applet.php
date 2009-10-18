<?php
//SQL = "SELECT top  * from loginHistory ORDER by loginTime DESC"
//SQL = "SELECT userid, userName, register_Date, lastLogin, hasImage FROM users WHERE userType > 0 ORDER BY lastLogin DESC LIMIT " & application("UserHistory")
if( $conn->type == 'mssql')
	$sql = "select top ".$application['userhistory']." userid, username, register_date, lastlogin, hasimage from users where usertype > 0 order by lastlogin desc";
else
	$sql = "select userid, username, register_date, lastlogin, hasimage from users where usertype > 0 order by lastlogin desc limit ".$application['userhistory'];

$content = '';

//response.Write(SQL)

$loginHistories = $conn->execute( $sql );
foreach( $loginHistories as $loginHistory ) {
	//$memberSince=$formatDateTime[$loginHistory['register_date']][$vbShortDate];
	//$loginTime=$FormatDateTime[$loginHistory['lastlogin']][$vbShortTime];

	$loginTime = date( 'H:i', strtotime( $loginHistory['lastlogin'] ) );
	$memberSince = date(' Y-m-d', strtotime($loginHistory['register_date']));
	if( $loginHistory['hasimage'] == false ) {
		$image = "images/ingetfoto.gif";
	}
	else {
		$image = "uploads/userImages/tn_".$loginHistory['userid'].".jpg";
	}
	$content .= "<a class=\"a2\" onMouseOver=\"return overlib('<div class=miniPicture><img src=".$image." height=45></div><div class=miniPictureText>".rqJS( $loginHistory['username'] )."<br/>Medlem sedan: ".$memberSince."</div>',WIDTH=100);\" onMouseOut=\"return nd();\" href=\"userPresentation.php?userid=".$loginHistory['userid']."\">".$loginHistory['username']."</a> - ".$loginTime."<br/>";

	//  //$loginHistory->moveNext;
	//$counter=$counter+1;
}
print theme_box('senast inloggade:', $content);
?>
