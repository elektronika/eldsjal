<?php
session_start( );







$noredirect = 1;

require_once( 'header.php' );?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );
require_once( 'diarys.applet.php' );?>
	</td>

		<td width="421" height="190"><?php if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}?><img src="images/inQueue.jpg" width="440" height="189">
		<div class="plainThead2">
		Hejsan
		</div>
		<br/>
		<div class="plainText">
<?php if( $_GET['mode'] == "" ) {
	?>
		P&aring; grund av att du har l&auml;mnat felaktiga eller ofullst&auml;ndiga uppgifter vid registrering har du nu fastnat h&auml;r, i karant&auml;n! Du kan endera v&auml;lja att komplettera/&auml;ndra dina uppgifter eller inte vara medlem hos oss! &Auml;rlighet och uppriktighet &auml;r b&ouml;rjan p&aring; en relation med oss, inte slutet! Hoppas du tar ditt f&ouml;rnuft till f&aring;nga!<br/>
		<br/>
<?php   if( $_SESSION['userid'] != "" ) {
		?>
			<a href="userEdit.php?mode=editAccount&userid=<?php     echo $_SESSION['userid'];?>" class="a2">&Auml;ndra uppgifter</a>
<?php
	}?>
		<br/>
<?php
}
elseif( $_GET['mode'] == "delete" ) {
	?>
		Av ovanst&aring;ende anledning har ditt konto nu avaktiverats, din historia b&auml;r vi med oss, men inte dig! Tack f&ouml;r din tid p&aring; eldsj&auml;l, hoppas du haft trevligt och kul och att det inte &auml;r med onda k&auml;nslor du g&aring;r!
		<br/>
<?php
}
elseif( $_GET['mode'] == "addReason" ) {
	if( $_GET['userid'] == "" || $_SESSION['usertype'] < $application['useradmin'] ) {
		header( "Location: "."main.php?message=Du har inte r&auml;ttigheter att arbeta med karant&auml;nen!" );
	}?>	
			
			<form name="quarentine" action="inquarentine.php?mode=commit" method="post">
			Anledning:
			<textarea name="reason"></textarea>
			<input type="hidden" name="userid" value="<?php   echo $_GET['userid'];?>"/>
			<input type="submit"/>
			</form>
<?php
}
elseif( $_GET['mode'] == "commit" ) {
	if( $_POST['userid'] == "" || $_SESSION['usertype'] < $application['useradmin'] ) {
		header( "Location: "."main.php?message=Du har inte r&auml;ttigheter att arbeta med karant&auml;nen!" );
	}
	$sql = "update users set redirect='http://www.eldsjal.org/inquarentine.php?message=".$_POST['reason']."' where userid = ".intval( $_POST['userid'] );
	$conn->execute( $sql );
	header( "Location: "."userPresentation.php?userid=".$_POST['userid']."&message=Anv&auml;ndaren satt i karant&auml;n pga.:".$_POST['reason'] );
}?>
		</div>
		<!-- 
		SYSTEM MESSAGES
		
		<br/><br/><br/>
		<div>
		<table border="0" width="400">
		<tr>
		<td class="welcome" >
		Ok! Nu har Eldsj&auml;l varit nere igen, men inte sedan Onsdagkv&auml;ll som ni kanske tror utan jag fick upp den efter Onsdagens haveri som berodde p&aring; att en minneskapsel i servern helt enkelt dukade under p&aring; grund av v&auml;rmen, s&aring; nu st&aring;r mitt f&ouml;nster &ouml;ppet hela tiden och jakten p&aring; en riktigt ISP har intensifierats!<br/><br/>Det som h&auml;nde d&auml;refter var att Telia fick problem med sin ADSL-lina och i och med att den dog s&aring; f&ouml;rsvann sj&auml;lva kopplingen tillbaka till n&auml;tet f&ouml;r mig! S&aring; nu, 18:00 fick jag &auml;ntligen ig&aring;ng allt igen! <br/><br/>Jag beklagar naturligtvis incidenten men g&ouml;r s&aring; gott jag kan med att h&aring;lla nertiden s&aring; kort som m&ouml;jligt!<br/><br/>Hoppas avbrottet fick ut er i solen n&aring;gra timmar... K&auml;rlek!
		</td>
		</tr>
		</table>
		</div>
		<br/><br/><br/>
		-->
		</td>
		
		
		<td>
		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Nyheter</h3>
		<h4 class="boxContentRight">
			<a href="nyhet7.php" class="a2">
			<img src="images/fantastic_voyage.jpg" width="117" height="70" border="0">
			
			<div class="plainText">
			Eldsj&auml;ls n&auml;ra framtid<br/>
			 Vad kommer att ske med sajten...<img src="images\1x1.gif" width="20" height="1" border="0"><img src="images/icons/arrows.gif" border="0"></a>
			</div>
			
			
		
				
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Nyheter</h3>
		<h4 class="boxContentRight">
			<a href="nyhet6.php" class="a2"><img src="images/safety.jpg" width="117" height="70" border="0">
			
			<div class="plainText">
			 Elds&auml;kerhet<br/>
			 Med stolthet som knappt k&auml;nner gr&auml;nser... <img src="images\1x1.gif" width="90" height="1" border="0"><img src="images/icons/arrows.gif" border="0"></a>
			</div>			
			

		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Aktiviteter</h3>
		<h4 class="boxContentRight">
		<div class="plainText">		
<?php require_once( 'calendar.php' );?>				
		</div>			
			
				
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Visheter</h3>
		<h4 class="boxContentRight">
		<div class="plainText">		
<?php require_once( 'wiseBox.applet.php' );?>		
		</div>			
			

		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		S&ouml;k medlem:</h3>
		<h4 class="boxContentRight">
<?php require_once( 'memberSearch.applet.php' );?>
		
		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Senaste bilder:</h3>
		<h4 class="boxContentRight">
<?php require_once( 'image.applet.php' );?>
					
		</td>
	</tr>
<?php require_once( 'footer.php' );?>
