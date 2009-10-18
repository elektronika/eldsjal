<?php require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
<?php $frontImage = $conn->execute("select imageid,filetype, imagename, width, height from images where private = 0 and approved = 1 order by rand() limit 1"); ?>
<div class="column column-left grid_3 prefix_1">
<?php require_once( 'toolbox.applet.php' );

if( $_SESSION['userid'] != "" ) {
	
require_once( 'action.applet.php' );

}
require_once( 'userHistory.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'image.applet.php' );?>
</div>
<div class="column column-middle grid_8">
<?php 
if( isset( $_GET['message'] ) ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
$iWidth = $frontImage['width'] + 50;
$iHeight = $frontImage['height'] + 300;
print "<div><a href=\"javascript:openImage('viewPicture.php?imageid=".$frontImage['imageid']."','".$iWidth."','".$iHeight."','firstpage'); \"><img src=/uploads/galleryImages/".$frontImage['imageid'].".".$frontImage['filetype']." width=450 alt=\"".$frontImage['imagename']."\" border=0></A></div>";
?>
<h3>V&auml;lkommen till eldsj&auml;l - alternativkonstens organisation!</h3>
<div class="plainText">
<!--
Eldsj&auml;l &auml;r ett community f&ouml;r alla som har ett intresse f&ouml;r alternativkonst, vare sig det &auml;r eld, trummor, eller dans, enda kriteriet &auml;r att j&auml;len st&aring;r i harmoni med m&auml;nni-<br/>skan n&auml;r det praktiseras. <br/><br/>
Du beh&ouml;ver inte vara medlem f&ouml;r att ta del av den information som delas ut p&aring; sidan. Registrera dig om du k&auml;nner att du vill vara en del av denna massiva r&ouml;relse.<br/><br/>
Som medlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder och filmer samt knyta kontakter landet runt. <br/><br/>
Mycket n&ouml;je! // Eldsj&auml;l crew
-->
Eldsj&auml;l &auml;r en organisation f&ouml;r de med intresse av alternativkonst, vare sig det &auml;r eldkonst, trummor, eller dans, enda kriteriet &auml;r att sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det ut&ouml;vas. Under v&aring;rt tak samlas allt fr&aring;n glada amat&ouml;rer till professionella ut&ouml;vare och alla f&aring;r lika stort utrymme. &Auml;ven om konsten &auml;r vad som f&ouml;r oss samman, &auml;r det n&auml;rheten och umg&auml;nget som &auml;r v&aring;r livskraft.<br/><br/>

Du beh&ouml;ver inte vara medlem f&ouml;r att ta del av den information som finns p&aring; sidan, den &auml;r fri att njuta av. F&ouml;r att ansluta sig till v&aring;r v&auml;xande familj kan du g&ouml;ra en ans&ouml;kan h&auml;r p&aring; communityn eller bes&ouml;ka en av v&aring;ra sammankomster.<br/><br/>

Som communitymedlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder, ta del av diskussioner samt m&ouml;jlighet att knyta kontakter landet runt. Som f&ouml;reningsmedlem st&ouml;djer du aktivt v&aring;r tillv&auml;xt har fri tillg&aring;ng till alla Eldsj&auml;ls aktiviteter, hj&auml;lper till att forma hur organisationen skall fungera, f&aring;r medlemspriser hos de st&ouml;rsta butikerna f&ouml;r alternativkonst samt blir f&ouml;rs&auml;krad vid aktiviter r&ouml;rande Eldsj&auml;l.<br/><br/>

Mycket n&ouml;je! // Eldsj&auml;l crew<br/>
</div>
<?php require( 'news.applet.php' );
require( 'forumStatus.lite.applet.php' );?>
</div>
<div class="column column-right grid_3">
<?php require_once( 'statistics.applet.php' );
require_once( 'info.applet.php' );
require_once( 'calendar.php' );
require_once( 'wiseBox.applet.php' );
require_once( 'memberSearch.applet.php' );?>
</div>
</div>
</div>
<?php require( 'footer.php' );?>
