<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>
<script LANGUAGE="JavaScript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}
	function CheckForm() {
	if (document.Topic.topicName.value == '') {
	alert("Please specify topic!");
	document.Topic.topicName.focus();
	return false;
	}
	return true;
	}
function openUserImage(fileName)
{
window.open(fileName, "userImage", "fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,directories=no,location=no,left=100,top=10,width=300,height=300")
}
-->
</script>
	<tr>
		<td valign="top" align="left">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>
<?php 
if( $_SESSION['userid'] != "" ) {
	?>
		<div class="boxLeft">
		<h3 class="boxHeader">
		just nu:</h3>
		<h4 class="boxContent">
		<?php require_once( 'action.applet.php' );?>
		</h4>
		</div>
<?php
}?>
<div class="boxLeft">
<h3 class="boxHeader">Aktiviteter</h3>
<h4 class="boxContentCalendar">
	<?php require_once( 'calendar.php' );?>
</h4></div>
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
		senast inloggade:
		</h3>
		<h4 class="boxContent">
		<?php require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>
		<div class="boxLeft">
		<h3 class="boxHeader">
		Senaste bilder:</h3>
		<h4 class="boxContent">
			<?php require_once( 'image.applet.php' );?>
		</h4>
		</div>
	</td>
	<td height="190" valign="top">


<?php if( isset( $_GET['page'] ) && $_GET['page'] == "protokoll" ) {
	?>
Protokoll
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "om" ) {
	?>
about
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "stadgar" ) {
	?>
<?php require_once( 'org_inc/stadgar.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "celler" ) {
	?>
<?php require_once( 'org_inc/celler.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "event" ) {
	?>
<?php require_once( 'org_inc/group_event.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "elektronika" ) {
	?>
<?php require_once( 'org_inc/group_elektronika.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "fuel" ) {
	?>
<?php require_once( 'org_inc/group_fuel.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "internationella" ) {
	?>
<?php require_once( 'org_inc/group_international.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "core" ) {
	?>
<?php require_once( 'org_inc/group_core.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "bidrag" ) {
	?>
<?php require_once( 'org_inc/policy_funding.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "uteslutande" ) {
	?>
<?php require_once( 'org_inc/policy_exclude.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "ordning" ) {
	?>
<?php require_once( 'org_inc/policy_behave.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "helvetet" ) {
	?>
<?php require_once( 'org_inc/policy_season.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "fadder" ) {
	?>
<?php require_once( 'org_inc/policy_fadder.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "forsakring" ) {
	?>
<?php require_once( 'org_inc/policy_insurance.inc' );?>
<?php
}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "sakerhet" ) {
	?>
<?php require_once( 'org_inc/policy_security.inc' );?>
<?php
}
else {
	?>
		<H3>S&ouml;ker du inte n&aring;gon speciell person anv&auml;nd <A HREF="contact.php" class="a2">kontaktformul&auml;ret</a></H3><BR>
<?php 
  $sql = "select board.userid, board.title, users.first_name, users.username, users.last_name, users.email from board, users where rights = 10 and users.userid = board.userid order by sort";
	$boardlist = $conn->execute( $sql );
	print "<TABLE height=190><TR>";
	if( $boardlist ) {
		$boardlists = $boardlist;
		foreach( $boardlists as $boardlist ) {
			print "<TD width=97 align=center><a href=javascript:openUserImage('images/userImages/".$boardlist['userid'].".jpg');><img src=\"images/userImages/tn_".$boardlist['userid'].".jpg\" border=\"0\"></a></TD>";
			print "<TD valign=top><B>Namn: </B><a href=\"userPresentation.php?userid=".$boardlist['userid']."\" class=a2>".$boardlist['first_name']." \"".$boardlist['username']."\" ".$boardlist['last_name']."</a><BR>";
			print "<B>Funktion: </B>".$boardlist['title']."<BR><B>Epost: </B><a href=\"mailto:".$boardlist['email']."\" class=a2>".$boardlist['email']."</TD></TR>";

			//      $boardlist->movenext;
		}
	}
	?>

</table>
<?php
}?>

</td>
<td valign="top">


<div class="boxRight">
<h3 class="boxHeader">
Information!</h3>
<h4 class="boxContent">
	<A HREF="board.php" class=a3>Styrelsen</A><BR>
	&nbsp;&nbsp;<A HREF="contact.php" class=a3>Kontakta styrelsen</A><BR>
<!--	<A HREF="#" class=a3>Protokoll</A><BR> -->
<!--	<A HREF="#" class=a3>Om Eldsj&auml;l</A><BR> -->
	<A HREF="board.php?page=stadgar" class=a3>Stadgar</A><BR>
	<A HREF="board.php?page=celler" class=a3>Celler</A><BR>
	<I>Arbetsgrupper</I><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=event" class=a3>Event</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=elektronika" class=a3>Elektronika</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=fuel" class=a3>FuEl</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=internationella" class=a3>Internationella</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=core" class=a3>Core</A><BR>
	<I>Policydokument</I><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=bidrag" class=a3>S&ouml;ka bidrag</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=uteslutande" class=a3>Uteslutande</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=ordning" class=a3>Ordning &amp; reda</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=helvetet" class=a3>En s&auml;song i helvetet</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=fadder" class=a3>Fadder?</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=forsakring" class=a3>F&ouml;rs&auml;kring</A><BR>
	&nbsp;&nbsp;<A HREF="board.php?page=sakerhet" class=a3>Elds&auml;kerhet</A><BR>
</h4>
</div>	

</td>

</tr>
<?php require_once( 'bottomInclude.php' );?>
