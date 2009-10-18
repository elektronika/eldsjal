<?php
session_start( );






require_once( 'header.php' );

if( $_SESSION['usertype'] < 10 ) {
	header( "Location: "."main.php?message=sidan finns inte" );
}?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'wisebox.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'userHistory.applet.php' );?>	
		
		</td>

		
		<td height="190">	<table border="0" cellpadding="0" cellspacing="0"> <tr> <td>
<?php if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}?>
	<img src="images/urkult3.jpg" width="468" height="189">
		<br/>
		
		<div class="userList">
		
		<a href="insertSystemMessage.php" class="a2">Nytt systemmedelande</a>
<?php 

if( $_GET['mode'] == "update" ) {
	if( $_GET['id'] == "" ) {
		header( "Location: "."systemMessages.php?message=Inget meddelande angett" );
	}
	$sql = "update systemmessages set topic='".cq( $_POST['topic'] )."', message = '".cq( $_POST['message'] )."' where systemmessageid = ".$_GET['id'];

	//response.Write(SQL)
	//response.end

	$updater = $conn->execute( $sql );
	$updater = null;
	header( "Location: "."systemMessages.php?message=uppdaterat och klart" );
}
else {
	$sql = "select * from systemmessages";

	//response.Write(SQL)

	$dbMessages = $conn->execute( $sql );
	if( $dbMessages ) {
		print "<div class=\"plainThead2\">Nix! stavarufel? prova en g&aring;ng till...</div></td></tr>";
	}
	else {
		$x = 0;
		$y = 0;
		$dbMessagess = $dbMessages;
		foreach( $dbMessagess as $dbMessages ) {
			print "<form action=systemMessages.php?mode=update&id=".$dbMessages['systemmessageid']." name=messages method=post>";
			print "<input name=topic type=text size=60 value=\"".RQForm( $dbMessages['topic'] )."\"><br/><textarea name=message rows=20 cols=50>".RQForm( $dbMessages['message'] )."</textarea><br/><input type=submit value=uppdatera></form/><br/><br/>";

			//      $dbMessages->moveNext;
		}
	}
	$dbMessages = null;
}
?>
		</table>
		</div><br/>
		</td>		
		
		<td>
		
		<div class="boxRight">
		
		<h4 class="boxContent">
<?php require_once( 'memberSearch.applet.php' );
require_once( 'calendar.php' );?></div>
			
		<div class="boxRight">
		
		<h4 class="boxContent">
			Eldsj&auml;ls stolta familj, hur m&aring;nga k&auml;nner du?
			Medlemmarna &auml;r sorterade efter n&auml;r de blev medlemmar, l&auml;ngst upp p&aring; listan &auml;r nykomlingarna, s&aring; de ska ni ta extra hand om!
		

		<div class="boxRight">
		
		<h4 class="boxContent">
<?php require_once( 'image.applet.php' );?>
			
		</td>
	</tr>
<?php require_once( 'footer.php' );?>
