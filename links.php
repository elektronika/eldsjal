<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>

<script LANGUAGE="JavaScript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}
function CheckForm() {

if (document.newURL.URL.value == '') {
alert("Du m&aring;ste ange en l&auml;nk!");
document.newURL.URL.focus();
return false;
if (document.newURL.URL.value == 'http://') {
alert("Du m&aring;ste ange en l&auml;nk!");
document.newURL.URL.focus();
return false;
}
return true;
}

function CheckFormEdit() {

if (document.editURL.URL.value == '') {
alert("Du m&aring;ste ange en l&auml;nk!");
document.editURL.URL.focus();
return false;
}
return true;
}
if (document.editURL.URL.value == 'http://') {
alert("Du m&aring;ste ange en l&auml;nk!");
document.editURL.URL.focus();
return false;
}
return true;
}
	
-->
</script>

	<tr>
		<td valign="top">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>		

		
		<div class="boxLeft">
		<h3 class="boxHeader">
		just nu:</h3>
		<h4 class="boxContent">
		<?php require_once( 'action.applet.php' );?>
		</h4>
		</div>

		<div class="boxLeft">
		<h3 class="boxHeader">
		Visheter:</h3>
		<h4 class="boxContent">
			<?php require_once( 'wiseBox.applet.php' );?>
		</h4>
		</div>
		

		<div class="boxLeft">
		<h3 class="boxHeader">
		nya tankar:</h3>
		<h4 class="boxContent">
			<?php require_once( 'diarys.applet.php' );?>
		</h4>
		</div>	
		<div class="boxLeft">
		<h3 class="boxHeader">
		senast inloggade:</h3>
		<h4 class="boxContent">
			<?php require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>	
		
		</td>
		<td  valign="top">
		<?php if( isset( $_GET['message'] ) ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
if( isset( $_GET['mode'] ) && $_GET['mode'] == "addLink" ) {
	//Check if logged in, if not throw them back with a warning

	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."links.php?message=Du kan inte l&auml;gga till l&auml;nkar utan att vara inloggad, logga in och f&ouml;rs&ouml;k igen!" );
	}

	// [unsupported] session.timeout=30;

	?>
			<form name="newURL" method="post" action="linksAct.php?mode=addLink" onSubmit="return CheckForm();">
			L&auml;nk<br>
			<input type="text" name="URL" id="topic" value="http://" class="forum">
			Kategori: <select name="categoryid" class="selectBox">
			<?php 
  $sql = "select * from linkscategories";
	$cat = $conn->execute( $sql );
	$cats = $cat;
	foreach( $cats as $cat ) {
		print "<option value=".$cat['linkscategoryid'].">".$cat['linkscategoryname']."</option>";

		//    $cat->moveNext;
	}
	?>
			</select>
			<br>Beskrivning<br>
			<textarea name="URLDesc" id="message" class="forum"></textarea>
			<input type="submit" name="submit" class="submit" id="submit" value="&raquo; &raquo;">

			</form>
<?php
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "editLink" ) {
	//Trigger the add Topic form - call mode=regTopic
	//Check if logged in, if not throw them back with a warning

	if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
		header( "Location: "."links.php?message=Du &auml;r inte inloggad f&ouml;r fem &ouml;re, fixa biffen och f&ouml;rs&ouml;k igen!" );
	}
	$sql = "select * from links where linksid = ".intval( $_GET['linkid'] );
	$link = $conn->execute( $sql );
	if( $link ) {
		header( "Location: "."links.php?message=Det finns ingen s&aring;n l&auml;nk!" );
	}
	$sql = "select linkscategoryid, linkscategoryname from linkscategories";
	$cat = $conn->execute( $sql );
	?>

			<form name="editURL" method="post" action="linksAct.php?mode=editLink&linkID=<?php   echo $_GET['linkid'];?>" onSubmit="return CheckFormEdit();" ID="Form1">
			L&auml;nk<br>
			<input type="text" name="URL" id="Text1" value="<?php   echo $link['url'];?>" class="forum">
			Kategori: <select name="categoryid" class="selectBox" ID="Select1">
			<?php 

  $cats = $cat;
	foreach( $cats as $cat ) {
		print "<option value=".$cat['linkscategoryid'];
		if( $cat['linkscategoryid'] == $link['categoryid'] ) {
			print " selected ";
		}
		print ">".$cat['linkscategoryname']."</option>";

		//    $cat->moveNext;
	}
	?>
			</select>
			<br>Beskrivning<br>
			<textarea name="URLDesc" id="Textarea1" class="forum"><?php   echo $link['urldesc'];?></textarea>
			<input type="submit" name="submit" class="submit" id="Submit1" value="&raquo; &raquo;">

			</form>
		<?php
}
else {
	if( $_SESSION['userid'] != "" ) {
		print "<br><br><a href='links.php?mode=addLink' class=a2>L&auml;gg till l&auml;nk &raquo;</a>&nbsp;&nbsp;<a href='linksAdmin.php' class=a2>L&auml;gg till kategori &raquo;</a><BR><br>";
	}
	$sql = "select distinct linkscategoryname, linkscategoryid from linkscategories inner join links on linkscategories.linkscategoryid = links.categoryid where links.url <> ''";
	$cat = $conn->execute( $sql );

	//response.Write(SQL & "<br>")

	print "<table border=0 width=450 cellpadding=0 cellspacing=0>";
	$cats = $cat;
	foreach( $cats as $cat ) {
		$sql = "select users.userid, users.username, links.url, links.linksid, links.urldesc, links.clicks, links.posterid from links inner join users on links.posterid = users.userid where categoryid = ".$cat['linkscategoryid']." order by links.regdate desc";
		$links = $conn->execute( $sql );

		//response.Write(SQL & "<br>")

		if( !is_array( current( $links ) ) ) 
			$links = array(
				$links,
			);
		print "<tr><td CLASS='plainTHead2' BGCOLOR='#E4C898'><b>".$cat['linkscategoryname']."</b></td><td CLASS='plainTHead2' BGCOLOR='#E4C898' width=50>klick</td><td CLASS='plainTHead2' BGCOLOR='#E4C898' width=50>postare</td><td BGCOLOR='#E4C898'>&nbsp;</td></tr>";
		$linkss = $links;
		foreach( $linkss as $links ) {
			print "<tr><td CLASS='plaintext' width=350><a href=redirect.php?linkID=".$links['linksid']." class=a2 target=_blank>".substr( $links['url'], 0, 45 )."</a></td><td>".$links['clicks']."</td><td><a href=userPresentation.php?userid=".$links['userid']." class=a2>".$links['username'];
			if(( $_SESSION['userid'] == $links['posterid'] ) || $_SESSION['usertype'] >= $application['linksadmin'] ) {
				print "<td align=right><a href=links.php?mode=editLink&linkID=".$links['linksid']."><img src=images/icons/edit.gif border=0></a><a href=linksAct.php?mode=deleteLink&linkID=".$links['linksid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort denna l&auml;nk?');\"><img src=images/icons/trashcan.gif border=0></a></td>";
			}
			else {
				print "<td>&nbsp;</td>";
			}
			print "</td></tr>";
			if( !( $links['urldesc'] == "http://" || $links['urldesc'] == "" ) ) {
				print "<tr><td CLASS='plaintext' colspan=4>".$links['urldesc']."</td></tr>";
			}
			else {
				print "<tr><td CLASS='plaintext' colspan=4><i>Ingen beskrivning</i></td></tr>";
			}
			print "<tr><td colspan=4>&nbsp;</td></tr>";

			//      $links->moveNext;
		}
		print "<tr><td COLSPAN='4'>&nbsp;</td></tr>";

		//    $cat->moveNext;
	}
	print "</table>";
	$cat = null;
	$links = null;
}
?>
		
		</td>
		<td valign="top">
		
		<div class="boxRight">
		<h3 class="boxHeader">
		S&ouml;k medlem:</h3>
		<h4 class="boxContent">

			<?php require_once( 'memberSearch.applet.php' );?>
		</h4>
		</div>

		<div class="boxRight">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar">
				<?php require_once( 'calendar.php' );?>
		</h4></div>
			
		<div class="boxRight">
		<h3 class="boxHeader">
		Medlemmar</h3>
		<h4 class="boxContent">
			Eldsj&auml;ls stolta familj, hur m&aring;nga k&auml;nner du?
			Medlemmarna &auml;r sorterade efter n&auml;r de blev medlemmar, l&auml;ngst upp p&aring; listan &auml;r nykomlingarna, s&aring; de ska ni ta extra hand om!
		</h4>
		</div>

		<div class="boxRight">
		<h3 class="boxHeader">
		Senaste bilder:</h3>
		<h4 class="boxContent">

			<?php require_once( 'image.applet.php' );?>
		</h4>
		</div>	
		</td>		
	</tr>
	
<?php require_once( 'bottomInclude.php' );?>
