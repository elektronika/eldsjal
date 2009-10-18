<?php require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
<div class="column column-left grid_3 prefix_1">
<?php require_once( 'toolbox.applet.php' );

if( $_SESSION['userid'] != "" ) {
	require_once( 'action.applet.php' );
}
require_once( 'calendar.php' );
require_once( 'wiseBox.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'userHistory.applet.php' );
require_once( 'image.applet.php' );?>
	</div>
	<div class="column column-middle grid_8">
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
	
require_once( 'org_inc/stadgar.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "celler" ) {
	
require_once( 'org_inc/celler.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "event" ) {
	
require_once( 'org_inc/group_event.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "elektronika" ) {
	
require_once( 'org_inc/group_elektronika.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "fuel" ) {
	
require_once( 'org_inc/group_fuel.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "internationella" ) {
	
require_once( 'org_inc/group_international.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "core" ) {
	
require_once( 'org_inc/group_core.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "bidrag" ) {
	
require_once( 'org_inc/policy_funding.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "uteslutande" ) {
	
require_once( 'org_inc/policy_exclude.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "ordning" ) {
	
require_once( 'org_inc/policy_behave.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "helvetet" ) {
	
require_once( 'org_inc/policy_season.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "fadder" ) {
	
require_once( 'org_inc/policy_fadder.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "forsakring" ) {
	
require_once( 'org_inc/policy_insurance.inc' );

}
elseif( isset( $_GET['page'] ) && $_GET['page'] == "sakerhet" ) {
	
require_once( 'org_inc/policy_security.inc' );

}
else {
	
/* <H3>S&ouml;ker du inte n&aring;gon speciell person anv&auml;nd <A HREF="contact.php" class="a2">kontaktformul&auml;ret</a></H3><br/> */ 

$sql = "select board.userid, board.title, users.first_name, users.username, users.last_name, users.email from board, users where rights = 10 and users.userid = board.userid order by sort";
	$boardlist = $conn->execute( $sql );
	print "<TABLE height=190><TR>";
	if( $boardlist ) {
		$boardlists = $boardlist;
		foreach( $boardlists as $boardlist ) {
			print "<TD width=97><a href=javascript:openUserImage('uploads/userImages/".$boardlist['userid'].".jpg');><img src=\"uploads/userImages/tn_".$boardlist['userid'].".jpg\" border=\"0\"></a></TD>";
			print "<TD><B>Namn: </B><a href=\"userPresentation.php?userid=".$boardlist['userid']."\" class=a2>".$boardlist['first_name']." \"".$boardlist['username']."\" ".$boardlist['last_name']."</a><br/>";
			print "<B>Post: </B>".$boardlist['title']."<br/><B>Epost: </B><a href=\"mailto:".$boardlist['email']."\" class=a2>".$boardlist['email']."</TD></TR>";

			//      $boardlist->movenext;
		}
	}
	?>

</table>
<?php
}?>
	</div>
	<div class="column column-right grid_3">

<div class="boxRight">

<h4 class="boxContent">
	<A HREF="board.php" class=a3>Styrelsen</A><br/>
	&nbsp;&nbsp;<A HREF="contact.php" class=a3>Kontakta styrelsen</A><br/>
<!--	<A HREF="#" class=a3>Protokoll</A><br/> -->
<!--	<A HREF="#" class=a3>Om Eldsj&auml;l</A><br/> -->
	<A HREF="board.php?page=stadgar" class=a3>Stadgar</A><br/>
	<A HREF="board.php?page=celler" class=a3>Celler</A><br/>
	<I>Arbetsgrupper</I><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=event" class=a3>Event</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=elektronika" class=a3>Elektronika</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=fuel" class=a3>FuEl</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=internationella" class=a3>Internationella</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=core" class=a3>Core</A><br/>
	<I>Policydokument</I><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=bidrag" class=a3>S&ouml;ka bidrag</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=uteslutande" class=a3>Uteslutande</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=ordning" class=a3>Ordning &amp; reda</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=helvetet" class=a3>En s&auml;song i helvetet</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=fadder" class=a3>Fadder?</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=forsakring" class=a3>F&ouml;rs&auml;kring</A><br/>
	&nbsp;&nbsp;<A HREF="board.php?page=sakerhet" class=a3>Elds&auml;kerhet</A><br/>
	
	</div>
	</div>
	</div>
<?php require_once( 'footer.php' );?>
