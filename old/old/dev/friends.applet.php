<div class="box">
<h3 class="boxHeader">Bli vän med!</h3>
<div class="boxContents">
<?php
//'/////// Bli v&auml;n med-funktion //////////////

$sql = "select * from friendtypes";
$friendList = $conn->execute( $sql );
$sql = "select friendtype as type from friends where user_id = ".intval( $_SESSION['userid'] )." and friend_id = ".intval( $_GET['userid'] )." or friend_id = ".intval( $_SESSION['userid'] )." and user_id = ".intval( $_GET['userid'] );
$knowEachOther = $conn->execute( $sql );
if( $knowEachOther ) {
	$related = $knowEachOther['type'];
}
else {
	$related = "-";
}
$knowEachOther = null;
?>
<form action="addfriend.php" method="post" name="friends" id="friends">
<?php 

if( $_SESSION['userid'] == "" ) {
	print "<select class=\"selectBox\" name=\"friendType\" id=\"friendType\" onchange=\"javaScript:window.alert('Den h&auml;r funktionen och 100000 andra bra f&aring;r du tillg&aring;ng\\ntill n&auml;r du registrerar dig och blir medlem, smutt va?');\">";
}
elseif( $_SESSION['userid'] == intval( $_GET['userid'] ) ) {
	print "<select class=\"selectBox\" name=\"friendType\" id=\"friendType\" onchange=\"javaScript:window.alert('Ok att du inte har n&aring;gra v&auml;nner eller n&aring;n som vill bli v&auml;n med dig, men nu g&aring;r du v&auml;l f&ouml;r l&aring;ngt &auml;nd&aring;!?');\">";
}
else {
	print "<select class=\"selectBox\" name=\"friendType\" id=\"friendType\" onchange=\"friends.submit();\">";
}
?>
	<option value="-">V&auml;lj hur h&auml;r!
<?php 
$friendLists = $friendList;
foreach( $friendLists as $friendList ) {
	print "<option value='".$friendList['friendtypeid']."'";
	if( $friendList['friendtypeid'] == $related ) {
		print " SELECTED ";
	}
	print ">".$friendList['friendtypename'];

	//  $friendList->moveNext;
}
?>	
	</select> <img src="images/icons/heart.gif" width="14" height="15">
	<input type="hidden" name="touserid" id="touserid" value="<?php echo $_GET['userid'];?>"/>
	</form>
<?php
/////////////////////////////////////////////

?>
</div></div>