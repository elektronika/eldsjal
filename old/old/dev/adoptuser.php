<?php
session_start( );






require_once( 'header.php' );

if( $_GET['userid'] == "" || $_SESSION['usertype'] < $application['useradmin'] ) {
	header( "Location: "."main.php?message=Du har inte r&auml;ttigheter att adoptera, tala med glemme!" );
}?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );
require_once( 'diarys.applet.php' );?>
	</td>

		<td width="421" height="190"><?php if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}?>
		<div class="plainText">
<?php 
if( $_GET['mode'] == "deny" ) {
	if( $_GET['adoptionid'] == "" ) {
		header( "Location: "."main.php?message=Du angav inte n&aring;gon adoption att avsl&aring;" );
	}
	$sql = "select users.username, parentuserid, adopteeuserid, requestinguserid from pendingadoption inner join users on users.userid = adopteeuserid where pendingadoptionid = ".intval( $_GET['adoptionid'] );
	$owner = $conn->execute( $sql );
	if( $owner ) {
		header( "Location: "."Denna ans&ouml;kan finns inte i databasen!" );
	}
	$sql = "insert into messages (userid, messagetopic, message, readmessage, messagedate, messagefrom) values (".$owner['userid'].", 'din adoptionsans&ouml;kan fick avslag!', 'av n&aring;gon anledning ', 0, getdate(), ".$_SESSION['userid'].")";
	$conn->execute( $sql );
	$sql = "DELETE FROM pendingAdoption WHERE 
		response.Redirect("$userPresentation->asp ? userid = " & session("$userid")."&message = Ans&ouml;kanavslagen!");

}
else
if ($_GET['mode']=="request")
{

if ($_GET['userid']=="" || $_SESSION['usertype']<$application['useradmin'])
{
  header("Location : "."main.php ? message = Duharinter&auml;ttigheterattadoptera, talamedglemme!");
} 


}
else
if ($_GET['mode']=="commit")
{

if ($_POST['userid']=="" || $_SESSION['usertype']<$application['useradmin'])
{
  header("Location : "."main.php ? message = Duharinter&auml;ttigheterattarbetamedkarant&auml;nen!");
} 
$sql="UPDATEusersSETredirect = 'http://www.eldsjal.org/inquarentine.php?message=".$_POST['reason']."'WHEREuserid = ".intval($_POST['userid']);
$conn->execute($sql);
header("Location : "."userPresentation.php ? userid = ".$_POST['userid']."&message = Anv&auml;ndarensattikarant&auml;npga. : ".$_POST['reason']);
} ?>
		</div>
		</td>
		
		
		<td>
		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Aktiviteter</h3>
		<h4 class="boxContentRight">
		<div class="plainText">		
<?php require_once('calendar.php'); ?>				
		</div>			
			
				
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Visheter</h3>
		<h4 class="boxContentRight">
		<div class="plainText">		
<?php require_once('wiseBox.applet.php'); ?>		
		</div>			
			

		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		S&ouml;k medlem:</h3>
		<h4 class="boxContentRight">
<?php require_once('memberSearch.applet.php'); ?>
		
		
		<div class="boxRight">
		<h3 class="boxHeaderRight">
		Senaste bilder:</h3>
		<h4 class="boxContentRight">
<?php require_once('image.applet.php'); ?>
					
		</td>
	</tr>
<?php require_once('footer.php'); ?>
