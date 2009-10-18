<div class="box">
<h3 class="boxHeader">Grejslådan</h3>
<div class="boxContents">
		<a class="a2" href="userPresentation.php?userid=<?php echo $_GET['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Presentation</a><br/>
		<a class="a2" href="guestbook.php?userid=<?php echo $_GET['userid'];?>"><img src="images/icons/ruta.gif" border="0"> G&auml;stbok</a><br/>
<?php if($_GET['userid'] == 5151): ?>
			<a class="a2" href="messages.php?userid=<?php echo $_GET['userid']."&mode=write";?>"><img src="images/icons/ruta.gif" border="0"> Kärleksbrev</a><br/>
<?php else: ?>
			<a class="a2" href="messages.php?userid=<?php echo $_GET['userid']."&mode=write";?>"><img src="images/icons/ruta.gif" border="0"> Meddelande</a><br/>
<?php endif; 

//SQL = "SELECT imageid FROM images WHERE private = 1 AND uploadedBy =" & Cint(request.QueryString("userid"))

$sql = "select imageid from images where uploadedby =".intval( $_GET['userid'] );
$hasImage = $conn->execute( $sql );
if( $hasImage ) {
	?>
		<a class="a2" href="gallery.php?userid=<?php   echo $_GET['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Mina bilder</a><br/>
<?php
}
?>
		<a class="a2" href="friends.php?userid=<?php echo $_GET['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Slattar</a><br/> 
<?php 
$sql = "select diaryid from diary where userid = ".intval( $_GET['userid'] );
$hasDiary = $conn->execute( $sql );
if( $hasDiary ) {
	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		?>
			<a class="a2" href="javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');"><img src="images/icons/ruta.gif" border="0"> Tankar</a><br/> 
<?php
	}
	else {
		?>
		<a class="a2" href="diary.php?userid=<?php     echo $_GET['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Tankar</a><br/> 
<?php
	}
}


//response.write("<a href=inquarentine.php?mode=addReason&userid=" & request.QueryString("userid") & " class=a2>In i karant&auml;n</a>")
if( $_SESSION['userid'] != "" && $_SESSION['usertype'] >= $application['useradmin']) {
print "<br/>--------------<br/>";
	if( $_SESSION['userid'] != intval( $_GET['userid'] ) ) {
		$sql = "select approvedby from users where userid = ".intval( $_GET['userid'] );
		$parent = $conn->execute( $sql );
		if( $parent['approvedby'] != $_SESSION['userid'] ) {
			print "<a href=parentHood.php?mode=adopt&userid=".$_GET['userid']."&requestuserid=".$_SESSION['userid']." class=\"a2\" onClick=\"return confirmSubmit('Att ta &ouml;ver fadderskapet &auml;r ett &aring;tagande som inneb&auml;r stort ansvarstagande. Innan du forts&auml;tter med detta, kontrollera att du gjort f&ouml;ljande:\\n* L&auml;st forumtr&aring;den om adoption och hur det fungerar\\n* Pratat med den befintliga faddern och &auml;r &ouml;verrens\\n* Haft kontakt med medlemmen i fr&aring;ga\\n* Har tid och f&ouml;rm&aring;ga att agera fadder')\">Adoptera</a><br/>";
		}
		$parent = null;
	}
}
if( $_SESSION['usertype'] >= $application['useradmin'] + 10 ) {
	print "<a href=\"actionList.php?mode=userView&userid=".$_GET['userid']."\" class=\"a2\" onClick=\"return confirmSubmit('&Auml;r du s&auml;ker p&aring; att du vill sp&aring;ra denna anv&auml;ndare?');\">Sp&aring;ra anv&auml;ndare</a><br/>";
}
if( $_SESSION['usertype'] >= $application['useradmin'] + 10 ) {
	print "<a href=\"test.php?mode=password&userid=".$_GET['userid']."\" class=\"a2\" onClick=\"return confirmSubmit('Jeje, vill du verkligen ha det h&auml;r l&ouml;senordet??');\">L&ouml;senord</a>";
}
if( $_SESSION['usertype'] >= $application['useradmin'] + 10 || $_SESSION['userid'] == 116 ) {
	print "<br/>--------------<br/><a href=\"userAdmin.php?mode=delete&userid=".$_GET['userid']."\" class=\"a2\" onClick=\"return confirmSubmit('&Auml;r du s&auml;ker p&aring; att du vill ta bort denna anv&auml;ndare, f&ouml;r evigt?');\">D&ouml;da anv&auml;ndare</a><br/>--------------<br/>";
}
if( $_SESSION['usertype'] >= 4 ) {
	print "<br/><a href=\"userAdmin.php?mode=fadder&userid=".$_GET['userid']."\" class=\"a2\" onClick=\"return confirmSubmit('&Auml;r du s&auml;ker p&aring; att denna anv&auml;ndare skall bli fadder, f&ouml;rst&aring;r vad det inneb&auml;r.');\">G&ouml;r till fadder!</a>";
}
?>
</div></div>