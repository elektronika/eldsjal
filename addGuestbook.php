<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
?>
<?php if( $_GET['mode'] != "addEntry" ) {
	?>
<?php require_once( 'topInclude.php' );?>
		<td width="7"><img src="1x1.gif" width="7" height="1"></td>
		<td rowspan="3" width="404" height="190" valign="top"><?php   if( $_GET['message'] != "" ) {
		print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
	}?>
		<span class="plainThead2">
		<?php 

  if( $_GET['userid'] == "" ) {
		print "<br><br><img src=\"images/urkult.jpg\" width=\"400\" height=\"209\"><br><br>";
		print "N&aring;got har blivit fett med knas nu, f&ouml;r jag fattar inte vems g&auml;stbok du vill skriva i. G&aring; tillbaka till personen du s&ouml;kers presentationssida och prova igen!<br><br>LYCKA TILL!"."<br><br><a class=\"a2\" href=\"members.php\">G&aring; till medlemssidan och s&ouml;k >></a>";
	}
	else {
		$sql = "select username from users where userid = ".$_GET['userid'];
		$dbUserName = $conn->execute( $sql );
		print "Vilken tur att du skriver lite i ".$dbUserName['username']."'s g&auml;stbok, f&ouml;r det &auml;r s&aring; kul att f&aring; meddelanden!";
		?>
		<br><br>
		</span>
		<span class="plainText">
		Skriv h&auml;r vettja:
		</span>
		<form  name="addGuestbook" action="addGuestBook.php?mode=addEntry" method="post" ID="Form1">
		<textarea class="inputBorder" cols="63" rows="10" name="guestbookEntry" ID="Textarea1"></textarea>
		<input class="inputBorder" type="submit" name="submit" id="submit" value="Tjohoo! >>">
		<input type="hidden" name="touserid" value="<?php     echo $_GET['userid'];?>" ID="Hidden1" ID="Hidden2">
		<input type="hidden" name="toUserName" value="<?php     echo $dbUserName['username'];?>" ID="Hidden3" ID="Hidden1">

		</form>
		
<?php
	}
	?>
		</td>
		<td width="7"><img src="images/1x1.gif" width="7" height="1"></td>
		<td width="145" height="109" valign="top" bgcolor="#E0D1BC">
		<img src="images/news.jpg" width="145" height="109">
		<div class="newsHeader">
		Den f&ouml;rsta resan
		</div>
		<div class="newsText">
		F&ouml;lj med p&aring; v&aring;r f&ouml;rsta resa...<br><br>
		l&auml;s mer >>
		</div>
		<img src="images/1x1.gif" width="10" height="10">
		</td>
	</tr>
	<tr>
		<td colspan="5"><img src="1x1white.gif" width="73" height="7"></td>
	</tr>
	<tr>
		<td width="184" height="200" bgcolor="#E0D1BC" valign="bottom">
		<div class="plainText">
		senast inloggade:<br>
			<?php 
  $sql = "select top ".$application['userhistory']." * from loginhistory order by userid desc";
	$loginHistory = $conn->execute( $sql );
	$counter = 1;
	$loginHistorys = $loginHistory;
	foreach( $loginHistorys as $loginHistory ) {
		$loginTime = $loginHistory['logintime'];
		print $counter.". ".$loginHistory['username']."- ".$loginHistory['logintime']."<br>";

		//    $loginHistory->moveNext;

		$counter = $counter + 1;
	}
	?>
			<br>
		</div>
		</td>
		<td width="7" colspan="2"><img src="images/1x1.gif" width="7" height="1"></td>
		<td width="7"><img src="images/1x1.gif" width="7" height="1"></td>
		<td width="145" height="109" valign="top" bgcolor="#E0D1BC">
		<div class="newsHeader">
		Den andra resan
		</div>
		<div class="newsText">
		F&ouml;lj med p&aring; v&aring;r andra resa...<br><br>
		l&auml;s mer >>
		</div>
		<br>

		</td>
	</tr>
<?php
}
else {
	print "Denna del &auml;r omkodad och ersatt av ny funktionalitet... Kl&aring;parkanzie har bara gl&ouml;mt att uppdatera pekare n&aring;gonstans... =)";
	exit( );

	// $Conn is of type "adodb.connection"

	$a2p_connstr = $Application['eldsjaldb'];
	$a2p_uid = strstr( $a2p_connstr, 'uid' );
	$a2p_uid = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
	$a2p_pwd = strstr( $a2p_connstr, 'pwd' );
	$a2p_pwd = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
	$a2p_database = strstr( $a2p_connstr, 'dsn' );
	$a2p_database = substr( $d, strpos( $d, '=' ) + 1, strpos( $d, ';' ) - strpos( $d, '=' ) - 1 );
	$Conn = mysql_connect( "localhost", $a2p_uid, $a2p_pwd );
	mysql_select_db( $a2p_database, $Conn );
	$formatText = CQ( $_POST['guestbookentry'] );
	$sql = "insert into guestbook (fromuserid, touserid, message, date, unread) values ('".$_SESSION['userid']."', '".intval( $_POST['touserid'] )."', '".$formattext."', getdate(), 1)";
	$result = $result_query = mysql_query(( $sql ), $conn );
	$result = mysql_fetch_array( $result_query );;
	header( "Location: "."guestbook.php?userid=".$_POST['touserid'] );
	$sql = "select username from users where userid = ".intval( $_POST['touserid'] );
	$gbName = $gbName_query = mysql_query(( $sql ), $conn );
	$gbName = mysql_fetch_array( $gbName_query );;
	$sql = "insert into history (action, userid, nick, message, [date], security) values ('guestbookadd',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." skriver ett g&auml;stboksinl&auml;gg till ".$gbname['username']."', getdate(), 0)";
	$result = $result_query = mysql_query(( $sql ), $conn );
	$result = mysql_fetch_array( $result_query );;
	$result = null;
}
?>
<?php require_once( 'bottomInclude.php' );?>
