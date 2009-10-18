<?php
session_start( );






require_once( 'header.php' );?>
<tr>
<td>
require_once( 'toolbox.applet.php' );
require_once( 'wisebox.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'userHistory.applet.php' );?>
</div>
</td>
<?php 
if( $_SESSION['userid'] == "" || $_SESSION['usertype'] < 10 ) {
	header( "Location: "."main.php?message=Du &auml;r inte inloggad eller saknar r&auml;ttigheter" );
}?>
<td height="190">
<?php if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_GET['mode'] == "userView" && $_GET['userid'] != "" ) {
	print "<META HTTP-EQUIV=Refresh CONTENT=\"3; URL=http://www.eldsjal.org/actionlist.php?mode=userView&userid=".$_GET['userid']."\">";
	?>
<div class=presentationTop>
<?php require_once( 'userPageLocation.applet.php' );?>
</div>
<?php 
$sql = "select top 25 id, message, [date] from history where userid = ".intval( $_GET['userid'] )." order by [id] desc ";
}
else {
	$sql = "select top 25 id, message, [date] from history order by [id] desc";
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
<td width="145" height="109">
<div class="boxRight">

<h4 class="boxContentCalendar">
<?php require_once( 'calendar.php' );
require_once( 'image.applet.php' );?>
</div>
</td>
</tr>
<?php require_once( 'footer.php' );?>
