<?php
session_start( );

$noredirect = 1;

require_once( 'header.php' );

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
	<td>
	 require_once( 'toolbox.applet.php' );?>
	</div>
<?php require_once( 'userHistory.applet.php' );
require_once( 'diarys.applet.php' );?>
	</td>
	<td height="190">
		<div class="regWindow1">
			<table width="100%" cellpadding="0" cellspacing="0" id="Table2">
				<TR>
<?php 
if( $_GET['step'] == "bringitonbaby" ) {
	//uppdatera kontot  
	$sql="update users set redirect = '' where userid = '".$_SESSION['userid']."'";
	$conn->execute( $sql );

	//markera &aring;ret som godk&auml;nt  
	$sql="INSERT INTO user_years (userid, year, timestamp) VALUES ('".$_SESSION['userid']."', '".strftime("%Y", time())."', getdate())";

	$conn->execute( $sql );
	?>
<div class="newstext"><B>Tack!</B><P>
Nu kan du &aring;terg&aring; till att anv&auml;nda sajten som du behagar.<br/>
	Vi som jobbar med Eldjs&auml;l tackar dig.
	</div>
<?php
}
elseif( $_GET['step'] == "pleasedeleteme" ) {
	?>
<div class="newsText"
<FORM ACTION="approve.php?step=ohyesdeleteme" METHOD="post">
<B>&Auml;r du helt s&auml;ker?</B><P>
Du har klickat p&aring; att du vill att ditt konto skall raderas.<br/>
Du f&auml;r g&auml;rna fylla i en f&ouml;rklaring till varf&ouml;r du vill ta bort ditt konto.<P>
<A HREF="approve.php" class="a2">&Auml;ndrat dig?</A><P>

<textarea name="whydelete" cols="30" rows="10" wrap class="inputBorder" id="whydelete"></textarea><br/>
<input type="submit" VALUE="Radera mig tack"/>
</FORM>
<?php
}
elseif( $_GET['step'] == "ohyesdeleteme" ) {
	$formatText = CQ( $_POST['whydelete'] );
	$sql = "insert into messages (messagetopic, message, readmessage, messagedate, messagefrom, userid) values ('radera mig!', '".$formattext."', 0, getdate(), ".$_SESSION['userid'].", 5122)";
	$conn->execute( $sql );
	?>
<div class="newsText"><B>Ett meddelande har nu skickats till elektronika (som sk&ouml;ter om hemsidan) h&auml;r p&aring; eldsj&auml;l om att du vill g&aring; ur f&ouml;reningen och radera ditt konto. Om du vill &auml;ndra dig skicka omg&aring;ende ett epostmeddelande till elektronika@eldsjal.org!</B></div>
<?php
}
else {
	?>
<div class="newsText">
<B>Hej Eldsj&auml;l!</B><P>
F&ouml;r att vi ska kunna s&ouml;ka bidrag s&aring; m&aring;ste samtliga medlemmar aktivt godk&auml;nna sitt medlemskap varje &aring;r. I och med att man &auml;r medlem i f&ouml;reningen om man &auml;r medlem i communityt s&aring; inneb&auml;r det att ditt konto raderas om du v&auml;ljer att g&aring; ur f&ouml;reningen.<p>
Om du har n&aring;gra fr&aring;gor s&aring; &auml;r du v&auml;lkommen att h&ouml;ra av dig till styrelsen. Antingen i forumet eller p&aring; <a href="mailto:info@eldsjal.org">info@eldsjal.org</a>.
<P>
<div><A HREF="approve.php?step=bringitonbaby" class="a2">Ja, jag vill vara medlem i Eldsj&auml;l under <?php   print strftime( "%Y", time() );?>!</A><P>
	<A HREF="approve.php?step=pleasedeleteme" class="a2">Nej tack, jag vill g&aring; ur f&ouml;reningen.</A></div>
</div>
<?php
}
?>
</TD>
</TR>
</table>
</TD>
	<td width="145" height="109">
<?php require_once( 'calendar.php' );
require_once( 'image.applet.php' );?>	
		</td>
	</TR>
<?php require_once( 'footer.php' );?>
