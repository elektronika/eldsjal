<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>
<tr>
<td valign="top">
<div class="boxLeft">
<?php require_once( 'toolbox.applet.php' );?>
</div>
<div class="boxLeft">
<h3 class="boxHeader">
Visheter:</h3>
<h4 class="boxContent">
<?php require_once( 'wiseBox.applet.php' );?>
</h4>
</div>
<div class="boxLeft">
<h3 class="boxHeader">
nya tankar:</h3>
<h4 class="boxContent">
<?php require_once( 'diarys.applet.php' );?>
</h4>
</div>
<div class="boxLeft">
<h3 class="boxHeader">
senast inloggade:</h3>
<h4 class="boxContent">
<?php require_once( 'userHistory.applet.php' );?>
</h4>
</div>
</td>
<?php 
if( $_SESSION['userid'] == "" || $_SESSION['usertype'] < 10 ) {
	header( "Location: "."main.php?message=Du &auml;r inte inloggad eller saknar r&auml;ttigheter" );
}?>
<td height="190" valign="top">
<?php if( $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
if( $_GET['mode'] == "userView" && $_GET['userid'] != "" ) {
	print "<META HTTP-EQUIV=Refresh CONTENT=\"3\">";
	?>
<div class=presentationTop>
<?php require_once( 'userPageLocation.applet.php' );?>
</div>
<?php 
  $sql = "select id, message, [date] from history where userid = ".intval( $_GET['userid'] )." order by id desc limit 25";
}
else {
	$sql = "select id, message, [date] from history order by id desc limit 25";
}
$list = $conn->execute( $sql );
print "<table border=1 width=450>";
if( $list ) {
	$lists = $list;
	foreach( $lists as $list ) {
		$tid = $dateDiff['n'][$list['date']][time( )]." minuter sedan";
		print "<tr><td>".$list['id']."</td><td>".$tid."</td><td>".$list['message']."</td><td>".$list['date']."</td></tr>";

		//    $list->moveNext;
	}
}
else {
	print "Inget h&auml;nder h&auml;r!";
}
?>
</table>
</td>
<td width="145" height="109" valign="top" align="right">
<div class="boxRight">
<h3 class="boxHeader">Aktiviteter</h3>
<h4 class="boxContentCalendar">
<?php require_once( 'calendar.php' );?>
</h4></div>
<div class="boxRight">
<h3 class="boxHeader">
Senaste bilder:</h3>
<h4 class="boxContent">
<?php require_once( 'image.applet.php' );?>
</h4>
</div>
</td>
</tr>
<?php require_once( 'bottomInclude.php' );?>
