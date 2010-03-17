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
		<td valign="top" align="left">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>
	</td>

		<td width="421" height="190" valign="top"><?php if( isset( $_GET['message'] ) ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}?>

<script LANGUAGE="JavaScript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}
</script>

<?php 
if( $_SESSION['userid'] == "" ) {
	header( "Location: "."main.php?message=Du &auml;r inte inloggad!" );
}
if( isset( $_GET['mode'] ) && $_GET['mode'] == "adopt" ) {
	if( $_GET['userid'] == "" ) {
		header( "Location: "."main.php?message=Ingen medlem angiven i ans&ouml;kan" );
	}
	$sql = "select approvedby from users where userid = ".intval( $_GET['userid'] );
	$parent = $conn->execute( $sql );
	$sql = "select username from users where userid = ".$parent['approvedby'];
	$owner = $conn->execute( $sql );
	$sql = "delete from pendingadoption where parentuserid = ".$parent['approvedby']." and adopteeuserid = ".intval( $_GET['userid'] )." and requestinguserid = ".$_SESSION['userid'];
	$conn->execute( $sql );
	$sql = "insert into pendingadoption (parentuserid, adopteeuserid, requestinguserid) values (".$parent['approvedby'].", ".intval( $_GET['userid'] ).", ".$_SESSION['userid'].")";
	$adopt = $conn->execute( $sql );
	$sql = "select username from users where userid = ".intval( $_GET['userid'] );
	$adopteeName = $conn->execute( $sql );
	print "Adoptionsans&ouml;kan gjord fr&aring;n dig till: ".$owner['username']." f&ouml;r att adoptera ".$adopteeName['username'];
	$parent = null;
	$adopt = null;
	$owner = null;
	$adopteeName = null;

	//else
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "approve" ) {
	//ta bort ans&ouml;kan
	//skicka in meddelande
	//uppdatera users

	$sql = "select pendingadoption.*, u1.username as parentname, u2.username as adopteename from pendingadoption inner join users u1 on u1.userid = pendingadoption.requestinguserid inner join users u2 on u2.userid = pendingadoption.adopteeuserid where pendingadoptionid = ".intval( $_GET['id'] )." and parentuserid = ".$_SESSION['userid'];
	$check = $conn->execute( $sql );
	if( $check ) {
		header( "Location: "."main.php?message=Ans&ouml;kningen st&auml;mmer inte!" );
	}
	$sql = "update users set approvedby = ".$check['requestinguserid']." where userid = ".$check['adopteeuserid'];
	$adopt = $conn->execute( $sql );
	$sql = "delete from pendingadoption where pendingadoptionid = ".intval( $_GET['id'] );
	$adopt = $conn->execute( $sql );
	$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".$check['requestinguserid'].", 'din fadderans&ouml;kan har beviljats!', 'detta &auml;r ett systemmeddelande f&ouml;r att notifiera dig om att din adoptionsans&ouml;kan av ".$check['adopteename']." har beviljats och ett meddelande f&ouml;r att ber&auml;tta detta f&ouml;r ".$check['adopteename']." har skickats. nu f&ouml;rv&auml;ntas du ta upp tr&aring;den p&aring; direkten och vara den b&auml;sta av faddrar... lycka till!', 0, getdate(), ".$_SESSION['userid'].")";
	$adopt = $conn->execute( $sql );
	$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".$check['adopteeuserid'].", 'du har f&aring;tt ny fadder!', 'hejsan! jag har fram tills nu varit din fadder h&auml;r p&aring; eldsj&auml;l men har nu beviljat en ans&ouml;kan fr&aring;n ".$check['parentname']." om att l&auml;mna &ouml;ver ansvaret! det har varit superskoj att l&auml;ra k&auml;nna dig och hoppas att vi kommer att forts&auml;tta ha bra kontakt! "."\r\n"."\r\n"."tack och hej... =)', 0, getdate(), ".$_SESSION['userid'].")";
	$adopt = $conn->execute( $sql );
	$check = null;
	$adopt = null;
	header( "Location: "."parentHood.php?message=Ans&ouml;kningen beviljades och du &auml;r nu fri fr&aring;n ansvar!" );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "disapprove" ) {
	$sql = "select pendingadoption.*, u1.username as parentname, u2.username as adopteename from pendingadoption inner join users u1 on u1.userid = pendingadoption.requestinguserid inner join users u2 on u2.userid = pendingadoption.adopteeuserid where pendingadoptionid = ".intval( $_GET['id'] )." and parentuserid = ".$_SESSION['userid'];
	$check = $conn->execute( $sql );
	if( $check ) {
		header( "Location: "."main.php?message=Ans&ouml;kningen st&auml;mmer inte!" );
	}
	$sql = "delete from pendingadoption where pendingadoptionid = ".intval( $_GET['id'] );
	$adopt = $conn->execute( $sql );
	$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".$check['requestinguserid'].", 'adoptionsans&ouml;kan av ".$check['adopteename']." avslagen!', 'du ans&ouml;kte tidigare om att ta &ouml;ver fadderskapet av ".$check['adopteename']." som h&aring;lls av ".$check['parentname'].", av n&aring;gon anledning som du sj&auml;lv f&aring;r ta reda p&aring; har ".$check['parentname']." valt att inte bevilja detta! n&aring;v&auml;l... vad &auml;r v&auml;l en bal p&aring; slottet...!', 0, getdate(), ".$_SESSION['userid'].")";
	$adopt = $conn->execute( $sql );
	$adopt = null;
	$check = null;
	header( "Location: "."parentHood.php?Ans&ouml;kningen avslogs och du &auml;r fortfarande fadder!" );
}
else {
	$sql = "select pendingadoption.pendingadoptionid, u1.username as childname, u2.username as parentname, pendingadoption.adopteeuserid, pendingadoption.requestinguserid from pendingadoption inner join users u1 on pendingadoption.adopteeuserid = u1.userid inner join users u2 on pendingadoption.requestinguserid = u2.userid where parentuserid = ".$_SESSION['userid'];
	$parentList = $conn->execute( $sql );
	if( $parentList !== 0 ) {
		if( !is_array( current( $parentList ) ) ) 
			$parentList = array(
				$parentList,
			);
		if( $parentList ) {
			$parentLists = $parentList;
			foreach( $parentLists as $parentList ) {
				print $parentList['parentname']." &ouml;nskar &ouml;dmjukt att &ouml;verta v&aring;rdnaden om <a href=/user/".$parentList['adopteeuserid']." target=_blank class=a2>".$parentList['childname']."</a><br>Vill du <a href=\"parentHood.php?mode=approve&id=".$parentList['pendingadoptionid']."\" class=\"a2\" onClick=\"return confirmSubmit('Du kommer nu att l&auml;mna &ouml;ver fadderskapet av ".$parentList['childname']." till ".$parentList['parentname']."');\">&raquo; Godk&auml;nna &laquo;</a> eller <a href=\"parentHood.php?mode=disapprove&id=".$parentList['pendingadoptionid']."\" class=\"a2\" onClick=\"return confirmSubmit('Du kommer nu att avsl&aring; ans&ouml;kan om fadderskap av ".$parentList['childname']." fr&aring;n ".$parentList['parentname']."');\">&raquo; Avsl&aring; &laquo;</a><br><br>";

				//      $parentList->moveNext;
			}
			print "<br><hr><br>";
		}
	}
	$sql = "select users.username, users.userid, users.online, locations.locationname from users inner join locations on users.city = locations.locationid where approvedby = ".$_SESSION['userid']." order by online desc,username asc";
	$parentList = $conn->execute( $sql );
	if( !is_array( current( $parentList ) ) ) 
		$parentList = array(
			$parentList,
		);
	print "Detta &auml;r dina fadderbarn i ordning efter online/offline och sedan bokstavsordning<br><br>";
	print "<table border=\"0\">";
	$parentLists = $parentList;
	foreach( $parentLists as $parentList ) {
		if( $parentList['online'] == 0 ) {
			$online = "<font color=RED> offline</font>";
		}
		else {
			$online = "<font color=green> online</font>";
		}
		print "<tr><td><a href=\"/user/".$parentList['userid']."\" class=\"a2\">".$parentList['username']."</a></td><td> - ".$parentList['locationname']."</td><td> - ".$online."</td></tr>";

		//    $parentList->moveNext;
	}
	print "</table>";
}
?>

		</td>
		
			<td valign="top" align="right">
				</td>
			
	</td>
	</tr>

<?php require_once( 'bottomInclude.php' );?>

