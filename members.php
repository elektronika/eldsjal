<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "username_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
require_once( 'topInclude.php' );
?>
	<tr>
		<td valign="top">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>

		
<?php 
if( $_SESSION['userid'] != "" ) {
	?>
		<div class="boxLeft">
		<h3 class="boxHeader">
		just nu:</h3>
		<h4 class="boxContent">
		<?php require_once( 'action.applet.php' );?>
		</h4>
		</div>		
<?php
}?>
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
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
<!--
function openInfo(url)
{
window.open(url, 'artInfo', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=auto,resizable=yes,directories=no,location=no,left=80,top=30,width=300,height=600');
}
-->
</script>
	
		<td height="190" valign="top">	<table border="0" cellpadding="0" cellspacing="0"> <tr valign="top" align="left"> <td>
	<?php if( isset( $_GET['message'] ) && $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}?>
	<?php 

if( isset( $_GET['mode'] ) && $_GET['mode'] == "listMembers" ) {
	?>
	
		<img src="images/urkult3.jpg" width="468" height="189">
		<br>
		<div class=""plainThead2"">Dessa anv&auml;ndare passar p&aring; din s&ouml;kning (<?php   echo cq( $_POST['username'] );?>):</div>
		<div class="userList">
			<table border="0">

	
	<?php 
	if( $conn->type == 'mssql' )
  		$sql = "select top 1 * from users inner join locations on users.city = locations.locationid where username = '".cq( $_POST['username'] )."'";
	else
  		$sql = "select * from users inner join locations on users.city = locations.locationid where username = '".cq( $_POST['username'] )."' limit 1";
	$dbUserList = $conn->execute( $sql );
	if( !$dbUserList ) {
	}
	else {
		print "<tr><td>Medlemmar som har det som anv&auml;ndarnamn:</TD></TR>";
		if( $dbUserList['gender'] == 0 ) {
			$gender = "K";
		}
		else {
			$gender = "T";
		}
		$gender = '';
		$birthDate = $formatDateTime[$dbUserList['born_month']."/".$dbUserList['born_date']."/".$dbUserList['born_year']][$vbShortDate];
		if( $isDate[$birthDate] ) {
			$age = $dateDiff['yyyy'][$birthDate][time( )];
		}
		else {
			$age = "'Ej validt datum'";
		}
		$age = age(mktime( 0, 0, 0, $dbUserList['born_month'], $dbUserList['born_date'], $dbUserList['born_year'] ) );

		//age = round(age / 365,1)

		if( $dbUserList['online'] == 1 || $dbUserList['online'] == true ) {
			print "<tr><td><img src=\"images/pluson.gif\" alt=\"online\"><a class=\"a2\" href=\"userPresentation.php?userid=".$dbUserList['userid']."\">".$dbUserList['first_name']." \"".$dbUserList['username']."\" ".$dbUserList['last_name']."</a>  -  <b>".$gender."</b>".$age."  -   ".$dbUserList['locationname']."<font color=#00AA00> - <i>online</i></font></td></tr>";
		}
		else {
			print "<tr><td><img src=\"images/pluss.gif\" alt=\"offline\"><a class=\"a2\" href=\"userPresentation.php?userid=".$dbUserList['userid']."\">".$dbUserList['first_name']." \"".$dbUserList['username']."\" ".$dbUserList['last_name']."</a>  -  <b>".$gender."</b>".$age."  -   ".$dbUserList['locationname']."<font color=#FF0000> - <i>offline</i></font></td></tr>";
		}
	}
	?>
	
	
		<?php 
	if( $conn->type == 'mssql')
		$sql = "select top 15 * from users inner join locations on users.city = locations.locationid where usertype > 0 and (username like '%".cq( $_POST['username'] )."%' or first_name like '%".cq( $_POST['username'] )."%' or last_name like '%".cq( $_POST['username'] )."%')";
	else
		$sql = "select * from users inner join locations on users.city = locations.locationid where usertype > 0 and (username like '%".cq( $_POST['username'] )."%' or first_name like '%".cq( $_POST['username'] )."%' or last_name like '%".cq( $_POST['username'] )."%') limit 15";

	//response.Write(SQL)

	$dbUserLists = $conn->execute( $sql );
	if( !$dbUserLists ) {
		print "<tr><td><div class=\"plainThead2\">Nix! stavarufel? prova en g&aring;ng till...</div></td></tr>";
	}
	else {
		print "<tr><td>&Ouml;vriga l&auml;mpliga tr&auml;ffar:</TR></TD>";
		$x = 0;
		if( !empty( $dbUserLists ) && !is_array( current( $dbUserLists ) ) ) 
			$dbUserLists = array(
				$dbUserLists,
			);
		foreach( $dbUserLists as $dbUserList ) {
			if( $dbUserList['gender'] == 0 ) {
				$gender = "K";
			}
			else {
				$gender = "T";
			}
			
			$gender = '';
			

			/*
			      $birthDate=$formatDateTime[$dbUserList['born_month']."/".$dbUserList['born_date']."/".$dbUserList['born_year']][$vbShortDate];
			      if ($isDate[$birthDate])
			      {
			
			        $age=$dateDiff['yyyy'][$birthDate][time()];
			      }
			        else
			      {
			
			        $age="'Ej validt datum'";
			      } 
			*/
			//age = round(age / 365,1)

			$age = age(mktime( 0, 0, 0, $dbUserList['born_month'], $dbUserList['born_date'], $dbUserList['born_year'] ));
			if( $dbUserList['online'] == 1 || $dbUserList['online'] == true ) {
				print "<tr><td><img src=\"images/pluson.gif\" alt=\"online\"><a class=\"a2\" href=\"userPresentation.php?userid=".$dbUserList['userid']."\">".$dbUserList['first_name']." \"".$dbUserList['username']."\" ".$dbUserList['last_name']."</a>  -  <b>".$gender."</b>".$age."  -   ".$dbUserList['locationname']."<font color=#00AA00> - <i>online</i></font></td></tr>";
			}
			else {
				print "<tr><td><img src=\"images/pluss.gif\" alt=\"offline\"><a class=\"a2\" href=\"userPresentation.php?userid=".$dbUserList['userid']."\">".$dbUserList['first_name']." \"".$dbUserList['username']."\" ".$dbUserList['last_name']."</a>  -  <b>".$gender."</b>".$age."  -   ".$dbUserList['locationname']."<font color=#FF0000> - <i>offline</i></font></td></tr>";
			}

			////      $dbUserList->moveNext;

			$x = $x + 1;
		}

		//$dbUserList->moveFirst;

		if( $x == 1 ) {
			header( "Location: "."userPresentation.php?userid=".$dbUserList['userid'] );
		}

		//$dbUserList=null;
	}
	print "</table>";
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "showOnline" ) {
	//###################### NY FUNKTION #######################

	?>



		<br>
		<div class=""plainThead2"">Eldsj&auml;lar Online:</div>
		<div class="userList">
		<table border="0">
		<?php 

  	$sql = "select * from users inner join locations on users.city = locations.locationid where online = 1 order by lastlogin";
	$dbUsers = $conn->execute( $sql );
	if(!is_array(current($dbUsers)))
		$dbUsers = array($dbUsers);
	foreach( $dbUsers as $dbUser ) {
		if( $dbUser['gender'] == 0 ) {
			$gender = "Kille";
		}
		else {
			$gender = "Tjej";
		}
		
		$gender = '';
		
		// $sql = "select logintime from loginhistory where userid = ".$dbUser['userid']." order by logintime desc limit 1";
		// $dbLoginTime = $conn->execute( $sql );

		//$logintime=$dateDiff['n'][$dbLoginTime['logintime']][time()];

		// $loginTime = strtotime( current( $dbLoginTime ) );
		// print_r($loginTime);
		// $diff = time( ) - $loginTime;
		// $loginTime = round( $diff / 60 );
		$loginTime = timeSince(strtotime($dbUser['lastlogin']), '');

		//response.Write(dbLoginTime("loginTime") & "<br>" & SQL)
		/*    $birthDate=$formatDateTime[$dbUser['born_month']."/".$dbUser['born_date']."/".$dbUser['born_year']][$vbShortDate];
		//response.Write(birthDate)
		    if ($isDate[$birthDate])
		    {
		
		      $age=$dateDiff['yyyy'][$birthDate][time()];
		    }
		      else
		    {
		
		      $age="'Ej validt datum'";
		    } 
		  */

		$age = age(mktime( 0, 0, 0, $dbUser['born_month'], $dbUser['born_date'], $dbUser['born_year'] ));

		// F O T O

		print "<TABLE CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\" class=\"showOnline\">";
		print "<TR VALIGN=\"top\" ALIGN=\"left\" class=\"showOnline\"><TD WIDTH=\"50\">";
		if( $dbUser['hasimage'] == true ) {
			print "<img src=uploads/userImages/tn_".$dbUser['userid'].".jpg border=0 width=\"50\"></td>";
		}
		else {
			print "<IMG SRC=images/ingetfoto.gif width=\"50\"></td>";
		}
		print "<td><a class=\"a2\" href=\"userPresentation.php?userid=".$dbUser['userid']."\">".$dbUser['username']."</a>".$gender.", ".$age." &aring;r - ".$dbUser['locationname']."<br><br>";
		print "<div class=\"newsText\"><b>Inloggad</b> ".$loginTime."</div>";
		print "<div class=\"newsText\"><b>Medlem sedan</b> ".date( 'Y-m-d', strtotime( $dbUser['register_date'] ) )."</div></td></tr>";

		////    $dbUser->moveNext;
	}
	print "</table></div>";
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "advSearch" ) {
	$sql = "select * from locations order by sortorder asc, locationname";
	$locationss = $conn->execute( $sql );
	$sql = "select artid, artname from artlist";
	$art = $conn->execute( $sql );
	?>
	
	<table border="0" class="activityList" ID="Table1">
	<tr>
	<td colspan="3">
	H&auml;r kan Du s&ouml;ka p&aring; medlemmar i andra regioner, andra som sysslar med samma som Dig eller varf&ouml;r inte b&aring;de och...
	</td>
	</tr>
	<tr>
	
	<form name="advSearch" ID="Form1" method="post" action="members.php?mode=advSearchAct">

			<?php 
  $sql = "select * from artlist where imageonly = 0 order by artname";
	$artLists = $conn->execute( $sql );
	$styleCount = 0;
	$iCount = 0;
	foreach( $artLists as $artList ) {
		print "<td><input class=inplutt type=radio ID=art".$iCount." NAME=art value=".$artList['artid'];
		print "><a class=a2 href=javascript:openInfo('shortInfo.php?mode=".$artList['artid']."') >".$artList['artname']."</a></td>";
		$iCount = $iCount + 1;
		$styleCount = $styleCount + 1;
		if( $styleCount == 3 ) {
			print "</tr><tr>";
			$styleCount = 0;
		}

		////    $artList->movenext;
	}
	?>
			
			</tr>
		<tr>
		<td colspan=3>
	Visa medlemmar i
	</td>
	</tr>
	<tr>
	<td colspan=2>
	<select name="location" class=selectBox class="text" style="width: 178; height: 23">
	<option value="0">Alla</option>
<?php 
  foreach( $locationss as $locations ) {
		print "<option value=".$locations['locationid'].">".$locations['locationname']."</option>";

		////    $locations->moveNext;
	}
	?>
	</select>
	</td>
	<td>
	<input type="reset" value="t&ouml;m">
	<img src="images\1x1.gif" width="50" height="1">S&ouml;k
	<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
	</td>
	</tr>
	</form>
	</table>			
		
<?php
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "advSearchAct" ) {
	if( $_POST['art'] == "" && $_POST['location'] == 0 ) {
		header( "Location: "."members.php?message=Du f&aring;r ju inte lista alla, det skulle ta timmar!" );
	}
	$sql = "select users.userid, users.username, locations.locationname ";
	if( $_POST['art'] != "" ) {
		$sql = $sql.", artlist.artname,userartlist.userid ";
	}
	$sql = $sql." FROM users INNER JOIN locations ON users.city = locations.locationid ";
	if( $_POST['art'] != "" ) {
		$sql = $sql."INNER JOIN userartlist ON userartlist.userid = users.userid  INNER JOIN artlist ON userartlist.artid = artlist.artid ";
	}
	if( $_POST['art'] != "" || $_POST['location'] != 0 ) {
		$sql = $sql." WHERE ";
	}
	if( $_POST['location'] != 0 ) {
		$sql = $sql." users.city = ".$_POST['location'];
	}
	if( $_POST['art'] != "" ) {
		if( $_POST['location'] != 0 ) {
			$sql = $sql." AND ";
		}
		$sql = $sql." userartlist.artid = ".$_POST['art'];
	}
	$sql = $sql." ORDER BY locations.locationname DESC";

	//response.Write(SQL)

	$results = $conn->execute( $sql );
	if( !$results ) {
		header( "Location: "."members.php?mode=advSearch&message=Inga medlemmar finns med dessa kriterer" );
	}
	else {
		$result = current( $results );
		print "<table border=0>";
		$query = "<tr><td colspan=2>Din s&ouml;kning p&aring;: Alla medlemmar";
		if( $_POST['location'] != 0 ) {
			$query = $query." i ".$result['locationname'];
		}
		if( $_POST['art'] != "" ) {
			$query = $query." som sysslar med ".$result['artname'];
		}
		print $query." gav dessa tr&auml;ffar:</td></tr>";
		foreach( $results as $result ) {
			print "<tr><td><a href=userPresentation.php?userid=".$result['userid']." class=a2>".$result['username']."</a></td><td>- ".$result['locationname']."</td></tr>";

			////      $result->moveNext;
		}
		print "</table>";
	}
}
else {
	?>
</td>
</tr>
</table>
		<img src="images/urkult3.jpg" width="468" height="189">
		<div class="plainText">
		
		</div>
		<br>
		<div class="userList">
		<table border="0">
		<?php
	//		SQL = "SELECT * FROM users ORDER BY register_date DESC"

	if( isset( $_POST['sort'] ) && $_POST['sort'] == "newMembers" ) {
		if( $conn->type == 'mssql' )
			$sql = "select top 60 * from users inner join locations on users.city = locations.locationid where usertype > 0 order by register_date desc";
		else
			$sql = "select from users inner join locations on users.city = locations.locationid where usertype > 0 order by register_date desc limit 60";

	}
	elseif( isset( $_POST['sort'] ) && $_POST['sort'] == "firstName" ) {
		if( $conn->type == 'mssql' )
			$sql = "select top 60 * from users inner join locations on users.city = locations.locationid where usertype > 0 order by first_name desc";
		else
			$sql = "select * from users inner join locations on users.city = locations.locationid where usertype > 0 order by first_name desc limit 60";
		
	}
	elseif( isset( $_POST['sort'] ) && $_POST['sort'] == "lastName" ) {
		if( $conn->type == 'mssql' )
			$sql = "select top 60 * from users inner join locations on users.city = locations.locationid where usertype > 0 order by last_name desc";
		else
			$sql = "select * from users inner join locations on users.city = locations.locationid where usertype > 0 order by last_name desc limit 60";
	}
	elseif( isset( $_POST['sort'] ) && $_POST['sort'] == "city" ) {
		if( $conn->type == 'mssql' )
			$sql = "select top 60 * from users inner join locations on users.city = locations.locationid where usertype > 0 order by city desc";
		else
			$sql = "select * from users inner join locations on users.city = locations.locationid where usertype > 0 order by city desc limit 60";
		
	}
	else {
		if( $conn->type == 'mssql' )
			$sql = "select top 60 * from users inner join locations on users.city = locations.locationid where usertype > 0 order by register_date desc";
		else
			$sql = "select * from users inner join locations on users.city = locations.locationid where usertype > 0 order by register_date desc limit 60";
	}
	$dbUserLists = $conn->execute( $sql );
	if(!is_array(current($dbUserLists)))
		$dbUserLists = array($dbUserLists);
	print "Listar de 60 senaste medlemmarna!";
	foreach( $dbUserLists as $dbUserList ) {
		if( $dbUserList['gender'] == 0 ) {
			$gender = "K";
		}
		else {
			$gender = "F";
		}
		$gender = '';

		//response.Write(dbUserList("userid"))
		//$birthDate=$formatDateTime[$dbUserList['born_year']."-".$dbUserList['born_month']."-".$dbUserList['born_date']][$vbShortDate];

		$age = age(mktime( 0, 0, 0, $dbUserList['born_month'], $dbUserList['born_date'], $dbUserList['born_year'] ));

		if( $dbUserList['online'] == 1 ) {
			print "<tr><td><img src=\"images/pluson.gif\" alt=\"online\"><a class=\"a3\" href=\"userPresentation.php?userid=".$dbUserList['userid']."\">".$dbUserList['username']."</a>  -  <b>".$gender."</b>".$age."   -   ".$dbUserList['locationname']."</td></tr>";
		}
		else {
			print "<tr><td><img src=\"images/pluss.gif\" alt=\"offline\"><a class=\"a2\" href=\"userPresentation.php?userid=".$dbUserList['userid']."\">".$dbUserList['username']."</a>  -  <b>".$gender."</b>".$age."   -   ".$dbUserList['locationname']."</td></tr>";
		}

		////    $dbUserList->moveNext;
	}
}
?>
		</table>
		</div><br>
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
