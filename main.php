<?php
  session_start( );
session_register( "userid" );
session_register( "userType" );
session_register( "userName" );
session_register( "boardMember" );
require( 'topInclude.php' );
?>
<?php $frontImage = $conn->execute("select imageid,filetype, imagename, width, height from images where private = 0 and approved = 1 order by rand() limit 1"); ?>
<tr>
<td valign="top" align="left">
	<div class="boxLeft"><?php require_once( 'toolbox.applet.php' );?></div>	

<?php 
if( $_SESSION['userid'] != "" ) {
	?>
	<div class="boxLeft">
		<h3 class="boxHeader">just nu:</h3>
		<h4 class="boxContent"><?php require_once( 'action.applet.php' );?></h4>
	</div>
<?php
}?>
	<div class="boxLeft">
		<h3 class="boxHeader">senast inloggade:</h3>
		<h4 class="boxContent"><?php require_once( 'userHistory.applet.php' );?></h4>
	</div>
	<div class="boxLeft">
		<h3 class="boxHeader">nya tankar:</h3>
		<h4 class="boxContent"><?php require_once( 'diarys.applet.php' );?></h4>
	</div>
	<div class="boxLeft">
		<h3 class="boxHeader">Senaste bilder:</h3>
		<h4 class="boxContent"><?php require_once( 'image.applet.php' );?></h4>
	</div>
</td>
<td height="190" valign="top">
<?php 
if( isset( $_GET['message'] ) ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
$iWidth = $frontImage['width'] + 50;
$iHeight = $frontImage['height'] + 300;
print "<div align=center><a href=\"javascript:openImage('viewPicture.php?imageid=".$frontImage['imageid']."','".$iWidth."','".$iHeight."','firstpage'); \"><img src=/uploads/galleryImages/".$frontImage['imageid'].".".$frontImage['filetype']." width=450 alt=\"".$frontImage['imagename']."\" border=0></A></div>";
?>
<h3>V&auml;lkommen till eldsj&auml;l - alternativkonstens organisation!</h3>
<div class="plainText">
<!--
Eldsj&auml;l &auml;r ett community f&ouml;r alla som har ett intresse f&ouml;r alternativkonst, vare sig det &auml;r eld, trummor, eller dans, enda kriteriet &auml;r att j&auml;len st&aring;r i harmoni med m&auml;nni-<BR>skan n&auml;r det praktiseras. <BR><BR>
Du beh&ouml;ver inte vara medlem f&ouml;r att ta del av den information som delas ut p&aring; sidan. Registrera dig om du k&auml;nner att du vill vara en del av denna massiva r&ouml;relse.<BR><BR>
Som medlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder och filmer samt knyta kontakter landet runt. <BR><BR>
Mycket n&ouml;je! // Eldsj&auml;l crew
-->
Eldsj&auml;l &auml;r en organisation f&ouml;r de med intresse av alternativkonst, vare sig det &auml;r eldkonst, trummor, eller dans, enda kriteriet &auml;r att sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det ut&ouml;vas. Under v&aring;rt tak samlas allt fr&aring;n glada amat&ouml;rer till professionella ut&ouml;vare och alla f&aring;r lika stort utrymme. &Auml;ven om konsten &auml;r vad som f&ouml;r oss samman, &auml;r det n&auml;rheten och umg&auml;nget som &auml;r v&aring;r livskraft.<br><br>

Du beh&ouml;ver inte vara medlem f&ouml;r att ta del av den information som finns p&aring; sidan, den &auml;r fri att njuta av. F&ouml;r att ansluta sig till v&aring;r v&auml;xande familj kan du g&ouml;ra en ans&ouml;kan h&auml;r p&aring; communityn eller bes&ouml;ka en av v&aring;ra sammankomster.<br><br>

Som communitymedlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder, ta del av diskussioner samt m&ouml;jlighet att knyta kontakter landet runt. Som f&ouml;reningsmedlem st&ouml;djer du aktivt v&aring;r tillv&auml;xt har fri tillg&aring;ng till alla Eldsj&auml;ls aktiviteter, hj&auml;lper till att forma hur organisationen skall fungera, f&aring;r medlemspriser hos de st&ouml;rsta butikerna f&ouml;r alternativkonst samt blir f&ouml;rs&auml;krad vid aktiviter r&ouml;rande Eldsj&auml;l.<br><br>

Mycket n&ouml;je! // Eldsj&auml;l crew<br>
</div>
<?php require( 'news.applet.php' );?>
<?php require( 'forumStatus.lite.applet.php' );?>
</td>
<td valign="top" align="right">
	<div class="boxRight" align="left">
		<h3 class="boxHeader">Eldsj&auml;lstatus</h3>
		<h4 class="boxContent"><?php require_once( 'statistics.applet.php' );?></h4>
	</div>
	<div class="boxRight" align="left">
		<h3 class="boxHeader">Om Eldsj&auml;l</h3>
		<h4 class="boxContent">F&ouml;reningen Eldsj&auml;l &auml;r helt utan kopplingar till politiska samt religi&ouml;sa f&ouml;rbund. F&ouml;reningen Eldsj&auml;l handlar om att samla m&auml;nniskor med liknande intressen och underl&auml;tta f&ouml;r &ouml;kat utbyte av erfarenheter, v&auml;rme och medm&auml;nsklighet. F&ouml;reningen Eldsj&auml;l verkar f&ouml;r &ouml;kad kulturell bredd i hela Norden med fokus p&aring; kulturyttringar som inte f&aring;r stor uppm&auml;rksamhet i den allm&auml;nna debatten. F&ouml;reningen Eldsj&auml;l arbetar aktivt f&ouml;r att motarbeta mobbing, fr&auml;mlingsfientlighet och f&ouml;rtryck.<br><br>Eldsjal.org &auml;r en tj&auml;nst som F&ouml;reningen Eldsj&auml;l med stolthet tillhandah&aring;ller allm&auml;nheten kostnadsfritt, oavsett medlemsskap i f&ouml;reningen f&ouml;r att sprida v&aring;ra budskap och aktivt arbeta med v&aring;ra m&aring;ls&auml;ttningar.</h4>
	</div>	
	<div class="boxRight">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar"><?php require_once( 'calendar.php' );?></h4>
	</div>
	<div class="boxRight" align="left">
		<h3 class="boxHeader">Visheter</h3>
		<h4 class="boxContent"><div class="plainText"><?php require_once( 'wiseBox.applet.php' );?></div></h4>
	</div>
	<div class="boxRight">
		<h3 class="boxHeader">S&ouml;k medlem:</h3>
		<h4 class="boxContent"><?php require_once( 'memberSearch.applet.php' );?></h4>
	</div>
</td>
</tr>
<?php require( 'bottomInclude.php' );?>
