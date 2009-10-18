<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
session_register( "userid_session" );
?>
<?php 
$noredirect = 1;
?>
<?php require_once( 'topInclude.php' );?>
<?php 
if( $_SESSION['userid'] == "" ) {
	header( "Location: "."main.php?message=Inte inloggad" );
}
$sql = "select * from user_years where userid = '".$_SESSION['userid']."' and year = '".strftime( "%y", time() )."'";
$useryear = $conn->execute( $sql );
if( $useryear ) {
	$conn->execute( $sql );
	header( "Location: "."main.php?message=Redan gjort serru!" );
}
?>
<tr>
	<td valign="top" align="left">
	<div class="boxLeft">
	<?php require_once( 'toolbox.applet.php' );?>
	</div>
	<div class="boxLeft">
		<h3 class="boxHeader">senast inloggade:</h3>
		<h4 class="boxContent"><?php require_once( 'userHistory.applet.php' );?></h4>
	</div>
	<div class="boxLeft">
		<h3 class="boxHeader">nya tankar:</h3>
		<h4 class="boxContent"><?php require_once( 'diarys.applet.php' );?></h4>
	</div>
	</td>
	<td height="190" valign="top">
		<div class="regWindow1">
			<table width="100%" cellpadding="0" cellspacing="0" ID="Table2">
				<TR VALIGN="top" ALIGN="left">

<?php 
if( $_GET['step'] == "bringitonbaby" ) {
	//uppdatera kontot  
	$sql="update users set redirect = '' where userid = '".$_SESSION['userid']."'";
	$conn->execute( $sql );

	//markera &aring;ret som godk&auml;nt  
	$sql="INSERT INTO user_years (userid, year, timestamp) VALUES ('".$_SESSION['userid']."', '".strftime("%Y", time())."', getdate())";

	$conn->execute( $sql );
	?>
<DIV CLASS="newstext"><B>Tack!</B><P>
Nu kan du &aring;terg&aring; till att anv&auml;nda sajten som du behagar.<BR>
	Vi som jobbar med Eldjs&auml;l tackar dig.
	</DIV>


<?php
}
elseif( $_GET['step'] == "pleasedeleteme" ) {
	?>
<DIV CLASS="newsText"
<FORM ACTION="approve.php?step=ohyesdeleteme" METHOD="post">
<B>&Auml;r du helt s&auml;ker?</B><P>
Du har klickat p&aring; att du vill att ditt konto skall raderas.<BR>
Du f&auml;r g&auml;rna fylla i en f&ouml;rklaring till varf&ouml;r du vill ta bort ditt konto.<P>
<A HREF="approve.php" class="a2">&Auml;ndrat dig?</A><P>

<textarea name="whydelete" cols="30" rows="10" wrap class="inputBorder" ID="whydelete"></textarea><BR>
<INPUT TYPE="submit" VALUE="Radera mig tack">
</FORM>

<?php
}
elseif( $_GET['step'] == "ohyesdeleteme" ) {
	$formatText = CQ( $_POST['whydelete'] );
	$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('radera mig!', '".$formattext."', 0, getdate(), ".$_SESSION['userid'].", 5122)";
	$conn->execute( $sql );
	?>
<DIV CLASS="newsText"><B>Ett meddelande har nu skickats till elektronika (som sk&ouml;ter om hemsidan) h&auml;r p&aring; eldsj&auml;l om att du vill g&aring; ur f&ouml;reningen och radera ditt konto. Om du vill &auml;ndra dig skicka omg&aring;ende ett epostmeddelande till elektronika@eldsjal.org!</B></DIV>
<?php
}
else {
	?>
<div class="newsText">
<B>Hej Eldsj&auml;l!</B><P>
F&ouml;r att vi ska kunna s&ouml;ka bidrag s&aring; m&aring;ste samtliga medlemmar aktivt godk&auml;nna sitt medlemskap varje &aring;r. I och med att man &auml;r medlem i f&ouml;reningen om man &auml;r medlem i communityt s&aring; inneb&auml;r det att ditt konto raderas om du v&auml;ljer att g&aring; ur f&ouml;reningen.<p>
Om du har n&aring;gra fr&aring;gor s&aring; &auml;r du v&auml;lkommen att h&ouml;ra av dig till styrelsen. Antingen i forumet eller p&aring; <a href="mailto:info@eldsjal.org">info@eldsjal.org</a>.
<P>
<DIV ALIGN="right"><A HREF="approve.php?step=bringitonbaby" class="a2">Ja, jag vill vara medlem i Eldsj&auml;l under <?php   print strftime( "%Y", time() );?>!</A><P>
	<A HREF="approve.php?step=pleasedeleteme" class="a2">Nej tack, jag vill g&aring; ur f&ouml;reningen.</A></DIV>
</DIV>
<?php
}
?>
</TD>
</TR>
</table>
</TD>
	<td width="145" height="109" valign="top" align="right">
		<div class="boxRight">
			<h3 class="boxHeader">Aktiviteter</h3>
			<h4 class="boxContentCalendar"><?php require_once( 'calendar.php' );?></h4>
		</div>
		<div class="boxRight">
			<h3 class="boxHeader">Senaste bilder:</h3>
			<h4 class="boxContent"><?php require_once( 'image.applet.php' );?></h4>
		</div>	
		</td>
	</TR>
<?php require_once( 'bottomInclude.php' );?>
