<?php
//session_start();

session_register( "userid_session" );
?>
<script type="text/javascript" language="javascript">
<!--
function CheckGB() {
if (document.addGuestbook.guestbookEntry.value == '') {
alert("Du m&aring;ste skriva n&aring;tt ju!");
document.addGuestbook.guestbookEntry.focus();
return false;
}
return true;
}
-->
</script>
<?php 
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	print "<form name=\"addGuestbook\" action='' id=\"addGuestbook\" method=\"post\" onSubmit=\"javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\">";
}
elseif( $_SESSION['userid'] != intval( $_GET['userid'] ) ) {
	print "<form  name=\"addGuestbook\" action=\"guestbookAct.php?mode=addEntry&userid=\"".$_GET['userid']." method=\"post\" ID=\"addGuestbook\" onSubmit=\"return CheckGB();\">";
	?>
<textarea class="addGb" name="guestbookentry" ID="guestbookEntry" cols="16" rows="10"></textarea>
Skicka
<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
<input type="hidden" name="touserid" value="<?php   echo $_GET['userid'];?>" ID="Hidden1" ID="Hidden2">
<input type="hidden" name="toUserName" value="<?php   echo $_GET['username'];?>" ID="Hidden3" ID="Hidden1">
</form>
<?php
}
else {
	print "Du ska ju inte skriva till dig sj&auml;lv heller!?";
}
?>
