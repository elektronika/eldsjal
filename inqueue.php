<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php 
$noredirect = 1;
?>
<?php require_once( 'topInclude.php' );?>
	<tr>
		<td valign="top" align="left">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>	

		
		<div class="boxLeft">
		<h3 class="boxHeader">
		senast inloggade:</h3>
		<h4 class="boxContent">
			<?php require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>	
		
		<div class="boxLeft">
		<h3 class="boxHeader">
		nya tankar:</h3>
		<h4 class="boxContent">
			<?php require_once( 'diarys.applet.php' );?>
		</h4>
		</div>
	</td>

		<td width="421" height="190" valign="top"><?php if( $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}?><img src="images/inQueue.jpg" width="440" height="189">
		<div class="plainThead2">
		Hejsan <?php echo $_GET['username'];?>
		</div>
		<br>
		<div class="plainText">
			V&auml;lkommen till Eldsj&auml;l, v&auml;rmen och n&auml;rheten!<br>
			Eldsj&auml;l &auml;r ett samlingsforum f&ouml;r folk med intresse f&ouml;r alternativkonst i Sverige. Tanken &auml;r inte bara att vi ska l&auml;ra k&auml;nna varandra och l&auml;ra varandra. Utan &auml;ven att var och en av oss skall kunna hitta en fristad av v&auml;nner, som ser efter varandra, st&ouml;ttar varandra och hj&auml;lper varandra! Eldsj&auml;l slog upp portarna 1:a maj 2003 efter mycket tanke och slit och m&ouml;ttes mycket v&auml;nligt. Med stor omsorg har vi spritt budskapet om Eldsj&auml;ls existens f&ouml;r att den sk&ouml;ra samling medlemmar som kom skulle kunna leva upp till den sinnebild av vad en eldsj&auml;l var. Detta &auml;r inte en community i dess vanliga bem&auml;rkelse utan snarare ett forum och en organisation f&ouml;r frit&auml;nkare och eldsj&auml;lar i ordets r&auml;tta bem&auml;rkelse. Men ocks&aring; grogrund f&ouml;r sj&auml;lvf&ouml;rtroende, styrka och kompentens.<br><br>
			I och med att vi vill uppn&aring; allt detta fr&aring;n var och en av v&aring;ra medlemmar &auml;r medlemsantalet inte n&ouml;dv&auml;ndigtvis en positiv sak, olikt andra webbplatser str&auml;var vi inte efter m&aring;nga medlemmar, utan medvetna medlemmar. Vi vill att var och en av v&aring;ra medlemmar har ett intresse att m&ouml;tas i vardagen, kommer &ouml;verrens och k&auml;nner en medm&auml;nsklighet. Eldsj&auml;l &auml;r inte en webbplats, det &auml;r en n&auml;rhet. Vi f&ouml;rs&ouml;ker ofta tr&auml;ffas och vi f&ouml;rs&ouml;ker bryta gr&auml;nserna f&ouml;r det traditionella umg&auml;nget. D&auml;rf&ouml;r &auml;r det viktigt att varje ny medlem &auml;r med p&aring; spelreglerna, har tr&auml;ffat n&aring;gra av oss andra, eller p&aring; n&aring;got annat s&auml;tt tillf&ouml;r de element som Eldsj&auml;l vilar p&aring;. <br><br>
			F&ouml;r att uppn&aring; detta &auml;r det tvunget att Du hamnar i en tids karant&auml;n, egentligen s&aring; att vi kan f&aring; tr&auml;ffa dig eller tillsammans med dig se vad Du vill tillf&ouml;ra, oftast r&auml;cker det med den blotta n&auml;rvaron och en bra presentation. Vi validerar just nu dina uppgifter och strax kommer du kunna logga in, l&aring;ta dig bekanta Dig med oss andra och tillsammans k&auml;nna att kemin st&auml;mmer. Om du k&auml;nner att du vill komplettera dina uppgifter och f&ouml;rb&auml;ttra oddsen trycker du bara "inst&auml;llningar" h&auml;r brevid.<br><br>Detta vinner vi alla p&aring;!<br><br>Tills dess, h&aring;ll ut, vi beklagar verkligen att det g&aring;r till s&aring; h&auml;r, men Internet &auml;r ett opersonligt medium och vi f&ouml;rs&ouml;ker inte &auml;ndra p&aring; det, bara f&aring; det att spela i v&aring;r riktning!<br><br>
			Kramar fr&aring;n oss alla medlemmar...vi ses snart!
		<br>
		</div>
		<!-- 
		SYSTEM MESSAGES
		
		<br><br><br>
		<div align="center">
		<table border="0" width="400">
		<tr>
		<td class="welcome" >
		Ok! Nu har Eldsj&auml;l varit nere igen, men inte sedan Onsdagkv&auml;ll som ni kanske tror utan jag fick upp den efter Onsdagens haveri som berodde p&aring; att en minneskapsel i servern helt enkelt dukade under p&aring; grund av v&auml;rmen, s&aring; nu st&aring;r mitt f&ouml;nster &ouml;ppet hela tiden och jakten p&aring; en riktigt ISP har intensifierats!<br><br>Det som h&auml;nde d&auml;refter var att Telia fick problem med sin ADSL-lina och i och med att den dog s&aring; f&ouml;rsvann sj&auml;lva kopplingen tillbaka till n&auml;tet f&ouml;r mig! S&aring; nu, 18:00 fick jag &auml;ntligen ig&aring;ng allt igen! <br><br>Jag beklagar naturligtvis incidenten men g&ouml;r s&aring; gott jag kan med att h&aring;lla nertiden s&aring; kort som m&ouml;jligt!<br><br>Hoppas avbrottet fick ut er i solen n&aring;gra timmar... K&auml;rlek!
		</td>
		</tr>
		</table>
		</div>
		<br><br><br>
		-->
		</td>
		
		
		<td valign="top" align="right">
		
	
		<div class="boxRight" align="left">
		<h3 class="boxHeaderRight">
		Aktiviteter</h3>
		<h4 class="boxContentRight">
		<div class="plainText">		
			<?php require_once( 'calendar.php' );?>				
		</div>			
		</h4>
		</div>	
				
		<div class="boxRight" align="left">
		<h3 class="boxHeaderRight">
		Visheter</h3>
		<h4 class="boxContentRight">
		<div class="plainText">		
			<?php require_once( 'wiseBox.applet.php' );?>		
		</div>			
		</h4>
		</div>	

		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		S&ouml;k medlem:</h3>
		<h4 class="boxContentRight">

			<?php require_once( 'memberSearch.applet.php' );?>
		</h4>
		</div>
		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Senaste bilder:</h3>
		<h4 class="boxContentRight">

			<?php require_once( 'image.applet.php' );?>
		</h4>
		</div>			
		</td>
	</tr>
	
	
<?php require_once( 'bottomInclude.php' );?>
