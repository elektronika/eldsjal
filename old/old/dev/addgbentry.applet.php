<div class="box">
<h3 class="boxHeader">Skriv inlägg!</h3>
<div class="boxContents">
<?php 
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	print "<form action='' id=\"addGuestbook\" method=\"post\" onSubmit=\"javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\">";
}
elseif( $_SESSION['userid'] != intval( $_GET['userid'] ) ) {
	print "<form action=\"guestbookAct.php?mode=addEntry&userid=\"".$_GET['userid']." method=\"post\" ID=\"addGuestbook\" onSubmit=\"return CheckGB();\">";
	?>
<textarea class="addGb" name="guestbookentry" id="guestbookEntry" cols="16" rows="10"></textarea>
Skicka
<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
<input type="hidden" name="touserid" value="<?php   echo $_GET['userid'];?>" id="Hidden1" id="Hidden2"/>
<input type="hidden" name="toUserName" value="<?php   echo $_GET['username'];?>" id="Hidden3" id="Hidden1"/>
</form>
<?php
}
else {
	print "Du ska ju inte skriva till dig sj&auml;lv heller!?";
}
?>
</div></div>