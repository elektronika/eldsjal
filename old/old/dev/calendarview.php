<?php require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
<div class="column column-left grid_3 prefix_1">
<?php require_once( 'toolbox.applet.php' );
require_once( 'action.applet.php' );
require_once( 'userHistory.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'image.applet.php' );?>
	</div>
	<div class="column column-middle grid_8">
		<?php if( isset( $_GET['message'] ) ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}?>

<script LANGUAGE="JavaScript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}
function confirmSubmitCountry(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	document.Form2.informAll.value==false
	return false ;
}

function change(picture) {
document.bytbild.src = picture
}

function CheckImage() {

if (document.form2.file1.value == '') {
document.form2.file1.value == '-'
return true;
}
}

</script>
<?php 

if( isset( $_GET['dd'] ) && $_GET['dd'] != "" ) 
	$dd = cq( $_GET['dd'] );
else 
	$dd = date( 'd' );
if( isset( $_GET['mm'] ) && $_GET['mm'] != "" ) 
	$mm = cq( $_GET['mm'] );
else 
	$mm = strftime( "%m", time( ) );
if( isset( $_GET['yyyy'] ) && $_GET['yyyy'] != "" ) 
	$yy = cq( $_GET['yyyy'] );
elseif( isset( $_GET['yy'] ) && $_GET['yy'] != "" ) 
	$yy = cq( $_GET['yy'] );
else 
	$yy = date( "Y" );
if( strlen( $dd ) <= 1 ) 
	$dd = "0".$dd;
if( strlen( $mm ) <= 1 ) 
	$mm = "0".$mm;
$datum = $yy."-".$mm."-".$dd;
if( isset( $_GET['mode'] ) && $_GET['mode'] == "addEvent" ) {
	print( isset( $_GET['message'] ) ? $_GET['message'] : '' )."<br/>";
	?>
<div class="regWindow1"> 
	<form name="form2" method="post" action="calendaract.php?mode=addEvent" id="Form2">
	<font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
	<select name="yyyy" class="selectBox" id="Select1">
<?php   for( $x = strftime( "%Y", time( ) ); $x <= strftime( "%Y", time( ) ) + 3; $x = $x + 1 ) {
		print "<option value=".$x;
		if( intval( $yy ) == $x ) {
			print " selected";
		}
		print ">".$x."</option>"."\r\n";
	}?>
	</select>
	&Aring;R 
	<select name="mm" class="selectBox" id="Select2">
		<option value="1"<?php   if( $mm == "1" || $mm == "01" ) {
		print " selected";
	}?>>Januari</option>
		<option value="2"<?php   if( $mm == "2" || $mm == "02" ) {
		print " selected";
	}?>>Februari</option>
		<option value="3"<?php   if( $mm == "3" || $mm == "03" ) {
		print " selected";
	}?>>Mars</option>
		<option value="4"<?php   if( $mm == "4" || $mm == "04" ) {
		print " selected";
	}?>>April</option>
		<option value="5"<?php   if( $mm == "5" || $mm == "05" ) {
		print " selected";
	}?>>Maj</option>
		<option value="6"<?php   if( $mm == "6" || $mm == "06" ) {
		print " selected";
	}?>>Juni</option>
		<option value="7"<?php   if( $mm == "7" || $mm == "07" ) {
		print " selected";
	}?>>Juli</option>
		<option value="8"<?php   if( $mm == "8" || $mm == "08" ) {
		print " selected";
	}?>>Augusti</option>
		<option value="9"<?php   if( $mm == "9" || $mm == "09" ) {
		print " selected";
	}?>>September</option>
		<option value="10"<?php   if( $mm == "10" ) {
		print " selected";
	}?>>Oktober</option>
		<option value="11"<?php   if( $mm == "11" ) {
		print " selected";
	}?>>November</option>
		<option value="12"<?php   if( $mm == "12" ) {
		print " selected";
	}?>>December</option>
	</select>
	M&Aring;NAD 
	<select name="dd" class="selectBox" id="Select3">
<?php   for( $x = 1; $x <= 31; $x = $x + 1 ) {
		if( strlen( $x ) <= 1 ) {
			$x = "0".$x;
		}
		print "<option value=".$x;
		if( intval( $dd ) == intval( $x ) ) {
			print " selected";
		}
		print ">".$x."</option>";
	}
	$sql = "select locationname, locationid from locations  order by sortorder asc, locationname";
	$locations = $conn->execute( $sql );
	$sql = "select city from users where userid = ".$_SESSION['userid'];
	$userLocation = $conn->execute( $sql );
	?>  
	</select>
	DAG
	<select name="locationid" class="selectBox" id="Select7">
<?php 
$locationss = $locations;
	foreach( $locationss as $locations ) {
		print "<option value=\"".$locations['locationid']."\"";
		if( intval( $userLocation['city'] ) == intval( $locations['locationid'] ) ) {
			print " selected";
		}
		print ">".$locations['locationname']."</option>";

		//    $locations->moveNext;
	}

	//LOGGER

	$sql = "replace into history (action, userid, nick, message, [date], security) values ('eventadd',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." h&aring;ller p&aring; och skapa ny aktivitet', getdate(), 0)";
	$conn->execute( $sql );
	?>
	</select>L&Auml;N	
	<div class="boxtext2">
	Rubrik<br/>
	<input class="inputBorder" type="text" name="rubrik" size="40" id="Text1" value="<?php   echo $_GET['title'];?>"/>
	<br/>
	Beskriv aktivitet<br/>
	<textarea class="inputBorder" name="text" cols="65" rows="10" id="Textarea1"><?php   echo $_GET['describe'];?></textarea>
	<br/>
	<input type="checkbox" value="1" name="bild" id="Checkbox1"/> Bifoga bild till aktivitet
	<br/>
	<input type="checkbox" value="1" name="informAll" id="informall" onclick="return confirmSubmitCountry('OBS!!! N&auml;r du trycker h&auml;r kommer ALLA p&aring; eldsj&auml;l bli informerade. &Auml;r du VERKLIGEN s&auml;ker p&aring; att ALLA medlemmar skall bjudas in?');"/> Notifiera hela landet!
	<br/>
	<input type="checkbox" value="1" name="private" id="private" onclick="return confirmSubmitCountry('Detta g&ouml;r aktiviteten &aring;tkomlig endast f&ouml;r dina v&auml;nner');"/> Aktivteten endast f&ouml;r v&auml;nner!
	<br/>
	Spara <input type="image" onClick="return confirmSubmit('Vill du l&auml;gga till denna aktivitet och informera alla i din region?')" src="images/icons/arrows.gif" name="proceed" id="proceed" class="proceed"/>
	</div>
	<!--
	<input type="hidden" name="yy" value="<?php   echo $_GET['yy'];?>" id="Submit2"/>
	<input type="hidden" name="mm" value="<?php   echo $_GET['mm'];?>" id="Hidden1"/>
	<input type="hidden" name="dd" value="<?php   echo $_GET['dd'];?>" id="Hidden2"/>
	-->
	</font> 
	</form>
	<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>SAMTLIGA H&Auml;NDELSER</b></font><br/>
	<table width="400" border="0" cellspacing="0" cellpadding="1" id="Table1">
	<tr> 
		<td bgcolor="#666666"> 
		<table width="450" border="0" cellspacing="0" cellpadding="2" bgcolor="#CCCCCC" id="Table2">
			<tr> 
			<td bgcolor="#CCCCCC"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
<?php 
if( $_SESSION['usertype'] < 4 ) {
		$sql = "select * from calendarevents where userid = ".$_SESSION['userid']." order by eventid desc";
	}
	else {
		$sql = "select * from calendarevents order by eventid desc";
	}
	$lists = $conn->execute( $sql );
	// if( $list ) {
		foreach( $lists as $list ) {
			print "<b>".$list['title']."</b> (".$list['yyyy']."-".$list['mm']."-".$list['dd'].")"." <a href='calendaract.php?mode=delete&eventid=".$list['eventid']."&page=addEvent&yy=".$yy."&mm=".$mm."&dd=".$dd."'><img src=\"images/icons/trashcan.gif\" name=\"bytbild\" border=\"0\"></a><br/>";

			//      $list->MoveNext;
		}
	// }
	// else {
		// print "Inga aktiviteter inf&ouml;rda";
	// }
	// $list->Close;
	// $list = null;
	?>
				</font></td>
			</tr>
		</table>
		</td>
	</tr>
	</table>
	</div>
<?php
	//elseif request.QueryString("mode") = "listEvent" then
	//	if request.QueryString("eventid") = "" then response.Redirect("calendarview.php?message=Ange aktivitet som du vill veta mer om&yyyy=" & year(now) & "&mm=" & month(now) & "&dd=" & day(now))
	//
	//	SQL = "SELECT * FROM "
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "getImageName" ) {
	if( $_GET['eventid'] == "" ) {
		header( "Location: "."calendarview.php?yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=Inget eventid angett" );
	}
	?>
	<form name="form2" method="post" enctype="multipart/form-data" action="calendaract.php?mode=addImage&eventid=<?php   echo $_GET['eventid']."&yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd'];?>" id="Form3">
	Bild<br/>
	<input class="inputBorder"  value="" type="file" name="file1" size="40" id="Text3"/>
	
	Spara 
	<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
	<br/>
<?php 
$sql = "select title from calendarevents where eventid = ".intval( $_GET['eventid'] );
	$result = $conn->execute( $sql );

	//LOGGER

	$sql = "replace into history (action, userid, nick, message, [date], security) values ('eventimage',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." v&auml;ljer nu passande aktivitetsbild till \"".$result['title']."\"', getdate(), 0)";
	$conn->execute( $sql );
	$result = null;
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "upcoming" ) {
	$sql = "select calendarevents.userid, locations.locationname, calendarevents.yyyy, calendarevents.mm, calendarevents.dd, calendarevents.fulldate, calendarevents.title, calendarevents.eventid from calendarevents inner join locations on calendarevents.locationid = locations.locationid where private = 1 and calendarevents.fulldate >= getdate() order by calendarevents.fulldate";
	$list = $conn->execute( $sql );
	if( $list ) {
		//Check if the user is invited i.e. in the friendlist

		$sql = "select friend_id from friends where accepted = 1 and user_id = ".$list['userid']." and friend_id = ".$_SESSION['userid'];
		$check = $conn->execute( $sql );
		if( $check ) {
			$sql = "select user_id from friends where accepted = 1 and friend_id = ".$list['userid']." and user_id = ".$_SESSION['userid'];
			$check = $conn->execute( $sql );
		}
		if( $check ) {
			print "Dessa privata inbjudningar har du f&aring;tt: <br/>";
			$lists = $list;
			foreach( $lists as $list ) {
				print $formatDateTime[$list['fulldate']][$vbShortDate]." - <a class=\"a2\" href=\"calendarview.php?eventid=".$list['eventid']."&yy=".$list['yyyy']."&mm=".$list['mm']."&dd=".$list['dd']."\">".$list['title']."</a> - ".$list['locationname']."<br/>";
			}
			print "<br/>";
		}
	}
	$sql = "select locations.locationname, calendarevents.yyyy, calendarevents.mm, calendarevents.dd, calendarevents.fulldate, calendarevents.title, calendarevents.eventid from calendarevents inner join locations on calendarevents.locationid = locations.locationid where calendarevents.fulldate >= getdate() order by calendarevents.fulldate";
	$list = $conn->execute( $sql );

	//LOGGER

	$sql = "replace into history (action, userid, nick, message, [date], security) values ('eventoverview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." kollar vilka aktiviteter som &auml;r kommande', getdate(), 0)";
	$conn->execute( $sql );
	
	if( !$list ) {
		print "Inga aktiviteter registrerade fram&ouml;ver!";
	}
	else {
		print "Aktiviteter som h&auml;nder fram&ouml;ver<br/>";
		$lists = $list;
		foreach( $lists as $list ) {
			$title = $list['title'];
			if( $title == "" ) {
				$title = "<i>ingen rubrik</i>";
			}
			print date( 'Y-m-d', strtotime( $list['fulldate'] ) )." - <a class=\"a2\" href=\"calendarview.php?eventid=".$list['eventid']."&yy=".$list['yyyy']."&mm=".$list['mm']."&dd=".$list['dd']."\">".$title."</a> - ".$list['locationname']."<br/>";
		}
	}
	$list = null;
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "userList" ) {
	if( $_SESSION['userid'] == "" ) {
		header( "Location: "."calendarview.php?message=Ingen aktivitet angedd eller ej inloggad!" );
	}
	$sql = "select count(calendarevents.eventid) as antal from calendarevents inner join locations on calendarevents.locationid = locations.locationid where calendarevents.fulldate >= getdate()";
	$list = $conn->execute( $sql );
	print "<a href=\"calendarview.php?mode=upcoming\" class=\"a2\">Visa alla kommande aktiviteter (".$list['antal'].") &raquo;</a>";
	$sql = "select locations.locationname, calendarevents.yyyy, calendarevents.mm, calendarevents.dd, calendarevents.title, calendarevents.eventid, calendarnotify.calendarnotifyid, calendarevents.fulldate from calendarnotify inner join calendarevents on calendarnotify.eventid = calendarevents.eventid inner join locations on calendarevents.locationid = locations.locationid where calendarnotify.userid =  ".$_SESSION['userid']." and notified = 0 and private = 1 and calendarevents.fulldate >= getdate() order by calendarevents.fulldate desc";
	$notify = $conn->execute( $sql );
	if( $notify ) {
		?>
		
		<table border="0" id="Table3">
		<tr>
		<td colspan="2">
		Dessa privata inbjudningar har du f&aring;tt
		</td>
		</tr>
<?php 
  $notifys = $notify;
		foreach( $notifys as $notify ) {
			if( strlen( $notify['dd'] ) <= 1 ) {
				$dd = "0".$notify['dd'];
			}
			else {
				$dd = $notify['dd'];
			}
			if( strlen( $notify['mm'] ) <= 1 ) {
				$mm = "0".$notify['mm'];
			}
			else {
				$mm = $notify['mm'];
			}
			$activityDate = $formatDateTime[$mm."/".$dd."/".$notify['yyyy']][$vbShortDate];
			print "<tr><td width=75>".$activityDate."</td><td><a href=\"calendarview.php?eventid=".$notify['eventid']."&yy=".$notify['yyyy']."&mm=".$notify['mm']."&dd=".$notify['dd']."\" class=\"a2\">".$notify['title']." - ".$notify['locationname']."</a></td></tr>";

			//end if
			//      $notify->moveNext;
		}
		print "</table>";
	}
	$sql = "select locations.locationname, calendarevents.yyyy, calendarevents.mm, calendarevents.dd, calendarevents.title, calendarevents.eventid, calendarnotify.calendarnotifyid, calendarevents.fulldate from calendarnotify inner join calendarevents on calendarnotify.eventid = calendarevents.eventid inner join locations on calendarevents.locationid = locations.locationid where calendarnotify.userid =  ".$_SESSION['userid']." and notified = 0 and calendarevents.fulldate >= getdate() order by calendarevents.fulldate desc";

	//response.write("KOPIERA OCH KLISTRA DETTA TILL MIG:<br/><br/>" & SQL)

	$notify = $conn->execute( $sql );
	if( $notify ) {
		?>
		
		<table border="0">
		<tr>
		<td colspan="2">
		Dessa allm&auml;nna aktiviteter h&auml;nder i din region:
		</td>
		</tr>
<?php 
	if( !is_array( current( $notify ) ) ) 
			$notify = array(
				$notify,
			);
		$notifys = $notify;
		foreach( $notifys as $notify ) {
			if( strlen( $notify['dd'] ) <= 1 ) {
				$dd = "0".$notify['dd'];
			}
			else {
				$dd = $notify['dd'];
			}
			if( strlen( $notify['mm'] ) <= 1 ) {
				$mm = "0".$notify['mm'];
			}
			else {
				$mm = $notify['mm'];
			}
			$activityDate = date( 'Y-m-d', mktime( 0, 0, 0, $mm, $dd, $notify['yyyy'] ) );
			print "<tr><td width=75>".$activityDate."</td><td><a href=\"calendarview.php?eventid=".$notify['eventid']."&yy=".$notify['yyyy']."&mm=".$notify['mm']."&dd=".$notify['dd']."\" class=\"a2\">".$notify['title']." - ".$notify['locationname']."</a></td></tr>";

			//end if
			//      $notify->moveNext;
		}
		print "</table>";
	}
	$sql = "select calendarevents.fulldate, calendarevents.eventid, calendarevents.dd, calendarevents.mm, calendarevents.yyyy, calendarevents.title, locations.locationname from calendarevents inner join joinactivity on calendarevents.eventid = joinactivity.eventid inner join locations on calendarevents.locationid = locations.locationid where joinactivity.userid = ".$_SESSION['userid']." and calendarevents.fulldate >= getdate() order by calendarevents.fulldate asc";
	$eventList = $conn->execute( $sql );
	print "<br/><br/><table border=\"0\">";
	if( $eventList ) {
		?>
		<tr>
		<td colspan="2">&nbsp;
		</td>
		</tr>
		<tr>
		<td colspan="2">
		Dessa aktiviteter &auml;r du anm&auml;ld till:
		</td></tr>
<?php 
	if( !is_array( current( $eventList ) ) ) 
			$eventList = array(
				$eventList,
			);
		$eventLists = $eventList;
		foreach( $eventLists as $eventList ) {
			$dd = $eventList['dd'];
			$mm = $eventList['mm'];
			$yyyy = $eventList['yyyy'];
			if( strlen( $dd ) <= 1 ) {
				$dd = "0".$dd;
			}
			if( strlen( $mm ) <= 1 ) {
				$mm = "0".$mm;
			}
			$activityDate = $yyyy."-".$mm."-".$dd;
			print "<tr><td width=\"70\">".$activityDate."</td><td><a href=\"calendarview.php?eventid=".$eventList['eventid']."&yy=".$eventList['yyyy']."&mm=".$eventList['mm']."&dd=".$eventList['dd']."\" class=\"a2\">".$eventList['title'].", ".$eventList['locationname']."</a></td></tr>";

			//      $eventList->moveNext;
		}
	}
	else {
		print "<tr><td colspan=\"2\">Du &auml;r inte anm&auml;ld till n&aring;gra aktiviteter</td></tr>";
	}
	print "</table>";
	$sql = "select calendarevents.fulldate, calendarevents.eventid, calendarevents.dd, calendarevents.mm, calendarevents.yyyy, calendarevents.title, locations.locationname from calendarevents inner join joinactivity on calendarevents.eventid = joinactivity.eventid inner join locations on calendarevents.locationid = locations.locationid where joinactivity.userid = ".$_SESSION['userid']." and calendarevents.fulldate <= getdate() order by calendarevents.fulldate desc";
	$eventList = $conn->execute( $sql );
	print "<br/><br/><table border=\"0\">";
	if( $eventList ) {
		?>
		<tr>
		<td colspan="2">&nbsp;
		</td>
		</tr>
		<tr>
		<td colspan="2">
		Dessa aktiviteter har du varit p&aring; tidigare:
		</td></tr>
<?php 
	if( !is_array( current( $eventList ) ) ) 
			$eventList = array(
				$eventList,
			);
		$eventLists = $eventList;
		foreach( $eventLists as $eventList ) {
			$dd = $eventList['dd'];
			$mm = $eventList['mm'];
			$yyyy = $eventList['yyyy'];
			if( strlen( $dd ) <= 1 ) {
				$dd = "0".$dd;
			}
			if( strlen( $mm ) <= 1 ) {
				$mm = "0".$mm;
			}
			$activityDate = $yyyy."-".$mm."-".$dd;
			print "<tr><td width=\"70\">".$activityDate."</td><td><a href=\"calendarview.php?eventid=".$eventList['eventid']."&yy=".$eventList['yyyy']."&mm=".$eventList['mm']."&dd=".$eventList['dd']."\" class=\"a2\">".$eventList['title'].", ".$eventList['locationname']."</a></td></tr>";

			//      $eventList->moveNext;
		}
	}
	else {
		print "<tr><td colspan=\"2\">Du har inte varit p&aring; n&aring;gra eldsj&auml;l-aktiviteter</td></tr>";
	}
	print "</table>";
	$sql = "delete from calendarnotify where userid = ".intval( $_SESSION['userid'] );
	$conn->execute( $sql );
}
elseif( isset( $_GET['mode'] ) && $_GET['mode'] == "update" ) {
	if( $_GET['eventid'] == "" || $_SESSION['userid'] == "" ) {
		header( "Location: "."calendarview.php?message=Ingen aktivitet angedd eller ej inloggad!" );
	}
	$sql = "select * from calendarevents where eventid = ".intval( $_GET['eventid'] );
	$Cevent = $conn->execute( $sql );

	//print_r($Cevent);

	if( $Cevent['userid'] == $_SESSION['userid'] || $_SESSION['usertype'] >= $application['calendaradmin'] ) {
		//Update

		?>
		<div class="regWindow1"> 
	<form name="form2" method="post" action="calendaract.php?mode=updateEvent&eventid=<?php     echo $_GET['eventid'];?>" id="Form2">
	<font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
	<select name="yyyy" class="selectBox" id="Select4">
<?php     for( $x = strftime( "%Y", time( ) ); $x <= strftime( "%Y", time( ) ) + 3; $x = $x + 1 ) {
			print "<option value=".$x;
			if( $Cevent['yyyy'] == $x ) {
				print " selected";
			}
			print ">".$x."</option>";
		}?>
	</select>
	&Aring;R 
	<select name="mm" class="selectBox" id="Select5">
		<option value="1"<?php     if( $Cevent['mm'] == "1" || $Cevent['mm'] == "01" ) {
			print " selected";
		}?>>Januari</option>
		<option value="2"<?php     if( $Cevent['mm'] == "2" || $Cevent['mm'] == "02" ) {
			print " selected";
		}?>>Februari</option>
		<option value="3"<?php     if( $Cevent['mm'] == "3" || $Cevent['mm'] == "03" ) {
			print " selected";
		}?>>Mars</option>
		<option value="4"<?php     if( $Cevent['mm'] == "4" || $Cevent['mm'] == "04" ) {
			print " selected";
		}?>>April</option>
		<option value="5"<?php     if( $Cevent['mm'] == "5" || $Cevent['mm'] == "05" ) {
			print " selected";
		}?>>Maj</option>
		<option value="6"<?php     if( $Cevent['mm'] == "6" || $Cevent['mm'] == "06" ) {
			print " selected";
		}?>>Juni</option>
		<option value="7"<?php     if( $Cevent['mm'] == "7" || $Cevent['mm'] == "07" ) {
			print " selected";
		}?>>Juli</option>
		<option value="8"<?php     if( $Cevent['mm'] == "8" || $Cevent['mm'] == "08" ) {
			print " selected";
		}?>>Augusti</option>
		<option value="9"<?php     if( $Cevent['mm'] == "9" || $Cevent['mm'] == "09" ) {
			print " selected";
		}?>>September</option>
		<option value="10"<?php     if( $Cevent['mm'] == "10" ) {
			print " selected";
		}?>>Oktober</option>
		<option value="11"<?php     if( $Cevent['mm'] == "11" ) {
			print " selected";
		}?>>November</option>
		<option value="12"<?php     if( $Cevent['mm'] == "12" ) {
			print " selected";
		}?>>December</option>
	</select>
	M&Aring;NAD 
	<select name="dd" class="selectBox" id="Select6">
<?php     for( $x = 1; $x <= 31; $x = $x + 1 ) {
			if( strlen( $x ) <= 1 ) {
				$x = "0".$x;
			}
			print "<option value=".$x;
			if( $Cevent['dd'] == intval( $x ) ) {
				print " selected";
			}
			print ">".$x."</option>";
		}
		$sql = "select locationname, locationid from locations order by sortorder asc, locationname";
		$locations = $conn->execute( $sql );
		?>  
	</select>
	DAG
	<select name="locationid" class="selectBox">
<?php 
  $locationss = $locations;
		foreach( $locationss as $locations ) {
			print "<option value=\"".$locations['locationid']."\"";
			if( $Cevent['locationid'] == $locations['locationid'] ) {
				print " selected ";
			}
			print ">".$locations['locationname']."</option>";

			//      $locations->moveNext;
		}
		print "</select> STAD<br/><input type=\"checkbox\" value=\"1\" name=\"bild\"";
		if( $Cevent['eventimage'] != "" ) {
			print " checked > BILD (kryssar du ur denna tas bilden bort!)";
		}
		else {
			print "> BILD";
		}
		?>
	<br/>
	<div class="boxtext2">
	Rubrik<br/>
	<input class="inputBorder" type="text" name="rubrik" size="40" id="Text2" value="<?php     echo rqForm( $Cevent['title'] );?>"/>
	<br/>
	Beskriv aktivitet<br/>
	<textarea class="inputBorder" name="text" cols="65" rows="10" id="Textarea2"><?php     echo rqForm( $Cevent['text'] );?></textarea>
	</div>
	<br/>
	<!-- <input type="hidden" value="<?php     echo $_GET['eventid'];?>" name="eventid"> --/>
	Spara <input type="image" onClick="return confirmSubmit('Vill du uppdatera denna aktivitet och informera alla i din region?')" src="images/icons/arrows.gif" name="proceed" id="Image1" class="proceed"/>
		</font> 
	</form>
<?php
		//LOGGER

		$sql = "replace into history (action, userid, nick, message, [date], security) values ('eventedit',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." &auml;ndrar i aktiviteten \"".$cevent['title']."\"', getdate(), 0)";
		$conn->execute( $sql );
		$locations = null;
	}
	else {
		header( "Location: "."calendarview.php?message=Du har inte r&auml;ttigheter att &auml;ndra i denna aktivitet!" );
	}
}
else {
	if( $_SESSION['userid'] != "" && isset( $_GET['eventid'] ) ) {
		$sql = "delete from calendarnotify where eventid = ".intval( $_GET['eventid'] )." and userid = ".$_SESSION['userid'];
		$rsConn = $conn->execute( $sql );
	}

	//sloppy code for private activities, no need to make the code "smart", I'll leave that for php

	$more = "";
	if( $_SESSION['userid'] != "" ) {
		print "<br/><a href='calendarview.php?mode=addEvent&yy=".$yy."&mm=".$mm."&dd=".$dd."' class='a2'>L&auml;gg till ny aktivitet den ".$datum."</a><br/><br/>";
		if( isset( $_GET['eventid'] ) && $_GET['eventid'] != "" ) {
			$sql = "select users.username, users.userid, calendarevents.text, calendarevents.title, calendarevents.eventid, calendarevents.eventimage, calendarevents.private from calendarevents inner join users on calendarevents.userid = users.userid where calendarevents.private = 1 and eventid = ".intval( $_GET['eventid'] );
			$validation = $conn->execute( $sql );
			if( $validation ) {
				//the specified activity is private, find out if user may see it

				$sql = "select user_id from friends where (friend_id = ".$validation['userid']." and user_id = ".$_SESSION['userid'].") or (user_id = ".$validation['userid']." and friend_id = ".$_SESSION['userid'].")";
				$valid = $conn->execute( $sql );
				if( $valid && $_SESSION['userid'] != $validation['userid'] ) {
					print "Inget att se!";
				}
				else {
					//The user can see the activity

					$more = "&ouml;vriga ";
					?>
				<div class="calendarViewBorder">
				<table width="460" border="0" cellspacing="0" cellpadding="1" bgcolor="#f0edc3" id="Table5">
				<tr class="calendarViewHeader">  
				<td class="calendarViewTopLeft">
<?php           print $validation['title'];
					if( $validation['userid'] == $_SESSION['userid'] || $_SESSION['usertype'] >= $application['calendaradmin'] ) {
						print "<a href=calendarview.php?mode=update&eventid=".$validation['eventid']." class=\"a2\"> &raquo;&Auml;ndra&laquo;</a>";
					}?>
				</td>
				<td class="calendarViewTopRight">
<?php 
        print $datum."<br/>";
					print "Inf&ouml;rt av: <i><a href=\"userPresentation.php?userid=".$validation['userid']."\" class=\"a2\">".$validation['username']."</i></a>";
					?>
        
        </td> 
      </tr>
      <tr> 
        <td colSpan="2" class="calendarViewContentLeft">
<?php           if( $validation['eventimage'] != "" ) {
						print "<span class=\"calendarImage\"><img src=\"images/calendar/tn_".$validation['eventimage']."\" width=\"75\" height=\"75\"></span>";
						print "<span class=\"calendarImageText\">".rq( $validation['text'] );
						print "</span>";
					}
					else {
						print rq( $validation['text'] );
					}
					print "</td></tr><tr><td class=\"calendarViewBottomLeft\">";
					if( $_SESSION['userid'] != "" ) {
						$participants = "";
						$sql = "select users.username, joinactivity.userid from joinactivity inner join users on users.userid = joinactivity.userid where eventid = ".$validation['eventid']." order by joinactivityid asc";
						$db = $conn->execute( $sql );
						if( $db ) {
							$participants = " - &Auml;nnu ingen som vill komma ";
						}
						else {
							if( !is_array( current( $db ) ) ) 
								$db = array(
									$db,
								);
							$dbs = $db;
							foreach( $dbs as $db ) {
								$participants = $participants."<li><a href=userPresentation.php?userid=".$db['userid']." class=a2> ".$db['username']."</a></li>";

								//                $db->moveNext;
							}
						}
						$sql = "select userid from joinactivity where eventid = ".intval( $validation['eventid'] )." and userid = ".$_SESSION['userid'];
						$db = $conn->execute( $sql );

						//print_r(array($db));

						if( !$db ) {
							print "<a href=\"calendaract.php?mode=participate&new=y&eventid=".$validation['eventid']."&userid=".$_SESSION['userid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."\" class=\"a2\" onClick=\"return confirmSubmit('Vill du anm&auml;la dig till denna aktivitet?')\">Sign me up Scotty!</a>";
						}
						else {
							print "<a href=\"calendaract.php?mode=participate&new=n&eventid=".$validation['eventid']."&userid=".$_SESSION['userid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."\" class=\"a2\" onClick=\"return confirmSubmit('Vill du avregistrera dig p&aring; denna aktivitet?')\">Jag &aring;ngrade mig!</a>";
						}
						print "</td><td class=\"calendarViewBottomRight\"><a href=\"javascript:void(0);\" onMouseOver=\" return overlib('".$participants."',CAPTION,'Deltagarlista!',STICKY);\" onMouseOut=\"return nd();\" class=\"a2\">Vi kommer!</a>";
					}
					else {
						print "&nbsp;</td><td class=\"calendarViewBottomRight\">&nbsp;";
					}?>
			</td></tr></table>
			</div>
<?php
				}
			}
		}
		elseif( $_GET['dd'] != "" && $_GET['mm'] != "" && $_GET['yy'] != "" ) {
			$sql = "select users.username, users.userid, calendarevents.title, calendarevents.eventid, calendarevents.eventimage, calendarevents.text, calendarevents.private from calendarevents inner join users on calendarevents.userid = users.userid where calendarevents.private = 1 and dd = ".$dd." and mm = ".$mm." and yyyy = ".$yy." order by calendarevents.regdate";
			$validation = $conn->execute( $sql );
			if( $validation ) {
				//the specified activity is private, find out if user may see it

				$validations = $validation;
				foreach( $validations as $validation ) {
					$sql = "select user_id from friends where (friend_id = ".$validation['userid']." and user_id = ".$_SESSION['userid'].") or (user_id = ".$validation['userid']." and friend_id = ".$_SESSION['userid'].")";
					$valid = $conn->execute( $sql );
					if( $valid && $_SESSION['userid'] != $validation['userid'] ) {
						print "Inget att se!";
					}
					else {
						//The user MAY see the private activity

						$more = "&ouml;vriga ";
						?>
				<div class="calendarViewBorder">
				<table width="460" border="0" cellspacing="0" cellpadding="1" bgcolor="#f0edc3" id="Table4">
				<tr class="calendarViewHeader">  
				<td class="calendarViewTopLeft">
<?php             print $validation['title'];
						if( $validation['userid'] == $_SESSION['userid'] || $_SESSION['usertype'] >= $application['calendaradmin'] ) {
							print "<a href=calendarview.php?mode=update&eventid=".$validation['eventid']." class=\"a2\"> &raquo;&Auml;ndra&laquo;</a><a href='calendaract.php?mode=delete&eventid=".$validation['eventid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."' onClick=\"return confirmSubmit('Vill du verkligen ta bort denna aktivitet och alla beroenden?')\"><img name=\"bytbild\" src=\"images/icons/trashcan.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Ta bort denna aktivitet\"></a>&nbsp;";
						}
						?>
				</td>
				<td class="calendarViewTopRight">
<?php 
          print $datum."<br/>";
						print "Inf&ouml;rt av: <i><a href=\"userPresentation.php?userid=".$validation['userid']."\" class=\"a2\">".$validation['username']."</i></a>";
						?>
        
        </td> 
      </tr>
      <tr> 
        <td colSpan="2" class="calendarViewContentLeft">
<?php             if( strlen( $validation['eventimage'] ) > 1 ) {
							print "<span class=\"calendarImage\"><img src=\"images/calendar/tn_".$validation['eventimage']."\" width=\"75\" height=\"75\"></span>";
							print "<span class=\"calendarImageText\">".rq( $validation['text'] );
							print "</span>";
						}
						else {
							print rq( $validation['text'] );
						}
						print "</td></tr><tr><td class=\"calendarViewBottomLeft\">";
						if( $_SESSION['userid'] != "" ) {
							$participants = "";
							$sql = "select users.username, joinactivity.userid from joinactivity inner join users on users.userid = joinactivity.userid where eventid = ".$validation['eventid']." order by joinactivityid asc";
							$db = $conn->execute( $sql );
							if( !$db ) {
								$participants = " - &Auml;nnu ingen som vill komma ";
							}
							else {
								$dbs = $db;
								foreach( $dbs as $db ) {
									$participants = $participants."<li><a href=userPresentation.php?userid=".$db['userid']." class=a2> ".$db['username']."</a></li>";

									//                  $db->moveNext;
								}
							}
							$sql = "select userid from joinactivity where eventid = ".intval( $validation['eventid'] )." and userid = ".$_SESSION['userid'];
							$db = $conn->execute( $sql );
							print_r( array( $db ) );
							if( !$db ) {
								print "<a href=\"calendaract.php?mode=participate&new=y&eventid=".$validation['eventid']."&userid=".$_SESSION['userid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."\" class=\"a2\" onClick=\"return confirmSubmit('Vill du anm&auml;la dig till denna aktivitet?')\">Sign me up Scotty!</a>";
							}
							else {
								print "<a href=\"calendaract.php?mode=participate&new=n&eventid=".$validation['eventid']."&userid=".$_SESSION['userid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."\" class=\"a2\" onClick=\"return confirmSubmit('Vill du avregistrera dig p&aring; denna aktivitet?')\">Jag &aring;ngrade mig!</a>";
							}
							print "</td><td class=\"calendarViewBottomRight\"><a href=\"javascript:void(0);\" onMouseOver=\" return overlib('".$participants."',CAPTION,'Deltagarlista!',STICKY);\" onMouseOut=\"return nd();\" class=\"a2\">Vi kommer!</a>";
						}
						else {
							print "&nbsp;</td><td class=\"calendarViewBottomRight\">&nbsp;";
						}?>
</td></tr></table>
</div>
<?php
					}

					//          $validation->moveNext;
				}
			}
		}
		else {
			header( "Location: "."calendarview.php?dd=".$day[time( )]."&mm=".strftime( "%m", time( ) )."&yy=".strftime( "%Y", time( ) ) );
		}
	}
	if( isset( $_GET['eventid'] ) && $_GET['eventid'] != "" && $_SESSION['userid'] != "" ) {
		//SQL = "UPDATE calendarNotify SET notified = 1 WHERE eventid = " & Cint(request.QueryString("eventid")) & " AND userid = " & session("userid")

		$sql = "select * from calendarevents inner join users on calendarevents.userid = users.userid where calendarevents.private = 0 and eventid = ".intval( $_GET['eventid'] );
	}
	elseif( isset( $_GET['search'] ) && $_GET['search'] == "List" ) {
		$sql = "select * from calendarevents inner join users on calendarevents.userid = users.userid ";
		if( $_POST['activitytitle'] != "" || $_POST['locationid'] != "0" ) {
			$sql = $sql." WHERE calendarEvents.private = 0";
		}
		if( $_POST['activitytitle'] != "" ) {
			$sql = $sql." AND title LIKE '%".$_POST['activitytitle']."%' ";
		}
		if( $_POST['activitytitle'] != "" && $_POST['locationid'] != "0" ) {
			$sql = $sql." AND ";
		}
		if( $_POST['locationid'] != "0" ) {
			$sql = $sql." locationid = ".intval( $_POST['locationid'] );
		}
		$search = 1;
	}
	else {
		$sql = "select users.username, users.userid, calendarevents.title, calendarevents.eventid, calendarevents.eventimage, calendarevents.private, calendarevents.text from calendarevents inner join users on calendarevents.userid = users.userid where calendarevents.private = 0 and dd = ".$dd." and mm = ".$mm." and yyyy = ".$yy." order by calendarevents.regdate";
	}
	$rsConn = $conn->execute( $sql );
	if( $_SESSION['usertype'] != "" ) {
		if( $_SESSION['usertype'] < $application['calendaradmin'] ) {
			$sql = "select calendarevents.title, calendarevents.eventid from calendarevents where userid = ".$_SESSION['userid']." order by eventid desc";
		}
		else {
			$sql = "select calendarevents.title, calendarevents.eventid from calendarevents where private = 0 order by eventid desc";
		}
		$list = $conn->execute( $sql );
	}
	if( !$rsConn ) {
		if( isset( $search ) ) {
			print "<table width='450'><tr><td><br/>Inga registrerade aktiviteter matchar din s&ouml;kning!</td></tr></table>";
		}
		else {
			print "<table width='450'><tr><td><br/>Det finns inga ".$more."aktiviteter den ".$yy."-".$mm."-".$dd."</td></tr></table>";
		}
	}
	else {
		if( !is_array( current( $rsConn ) ) ) 
			$rsConn = array(
				$rsConn,
			);
		$rsConns = $rsConn;
		foreach( $rsConns as $rsConn ) {
			?>
<div class="calendarViewBorder">
    <table width="460" border="0" cellspacing="0" cellpadding="1" bgcolor="#f0edc3" id="Table4">
      <tr class="calendarViewHeader">  
        <td class="calendarViewTopLeft">
<?php       print $rsConn['title'];
			if( $rsConn['userid'] == $_SESSION['userid'] || $_SESSION['usertype'] >= 4 ) {
				print "<a href=calendarview.php?mode=update&eventid=".$rsConn['eventid']." class=\"a2\"> &raquo;&Auml;ndra&laquo;</a>";
			}?>
        </td>
        <td class="calendarViewTopRight">
<?php       if( $_SESSION['usertype'] != "" ) {
				?>
        <!-- <a href="javascript:window.alert('Denna funktion &auml;r under utveckling!');"><img src="images/icons/gallery.gif" width="16" height="16" border="0" alt="L&auml;gg till aktivitetsbilder"></a>
		<a href="javascript:window.alert('Denna funktion &auml;r under utveckling!');"><img src="images/icons/guestbook.gif" border="0" alt="L&auml;gg till aktivitetsdagbok"></a>
        -->
<?php 
      if( $list ) {
					if( !is_array( current( $list ) ) ) 
						$list = array(
							$list,
						);
					$lists = $list;
					foreach( $lists as $list ) {
						if( $list['eventid'] == $rsConn['eventid'] ) {
							print "<a href='calendaract.php?mode=delete&eventid=".$list['eventid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."' onClick=\"return confirmSubmit('Vill du verkligen ta bort denna aktivitet och alla beroenden?')\"><img name=\"bytbild\" src=\"images/icons/trashcan.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Ta bort denna aktivitet\"></a>&nbsp;";
						}

						//            $list->moveNext;
					}

					//$list->moveFirst;
				}
			}
			if( $_SESSION['userid'] != "" ) {
				$sql = "select userid from joinactivity where eventid = ".intval( $rsconn['eventid'] )." and userid = ".$_SESSION['userid'];
				$db = $conn->execute( $sql );

				//print_r
				//response.write(rsConn("yyyy") & "-" & rsConn("mm") & "-" & rsConn("dd"))

				if( !$db ) {
					print $datum."<br/>";
				}
				else {
					print "&nbsp;<a href=messages.php?mode=writecalendar&eventid=".intval( $rsConn['eventid'] )."><img src=images/icons/msg.gif border=0></a>&nbsp;&nbsp;".$datum."<br/>";
				}
			}
			print "Inf&ouml;rt av: <i><a href=\"userPresentation.php?userid=".$rsConn['userid']."\" class=\"a2\">".$rsConn['username']."</i></a>";
			?>
        
        </td> 
      </tr>
      <tr> 
        <td colSpan="2" class="calendarViewContentLeft">
<?php       if( strlen( $rsConn['eventimage'] ) > 1 ) {
				//<td class="calendarViewContentRight">&nbsp;</td>-->

				print "<span class=\"calendarImage\"><img src=\"images/calendar/tn_".$rsConn['eventimage']."\" width=\"75\" height=\"75\"></span>";
				print "<span class=\"calendarImageText\">".rq( $rsConn['text'] );
				if( $rsConn['eventid'] == 265 ) {
					print "<br/><br/><a href=\"http://www.eldsjal.org/cby.pdf\" target=\"_blank\" class=\"a2\">&raquo; Inbjudan C.B.Y h&auml;r &laquo;</a>";
				}
				print "</span>";
			}
			else {
				print rq( $rsConn['text'] );
			}
			print "</td></tr><tr><td class=\"calendarViewBottomLeft\">";
			if( $_SESSION['userid'] != "" ) {
				$participants = "";
				$sql = "select users.username, users.userid, joinactivity.userid from joinactivity inner join users on users.userid = joinactivity.userid where eventid = ".$rsConn['eventid']." order by joinactivityid asc";
				$db = $conn->execute( $sql );
				if( !$db ) {
					$participants = " - &Auml;nnu ingen som vill komma ";
				}
				else {
					if( !is_array( current( $db ) ) ) 
						$db = array(
							$db,
						);
					$dbs = $db;
					foreach( $dbs as $db ) {
						$participants = $participants."<li><a href=userPresentation.php?userid=".$db['userid']." class=a2> ".$db['username']."</a></li>";

						//            $db->moveNext;
					}
				}
				$sql = "select joinactivityid from joinactivity where eventid = ".$rsConn['eventid']." and userid = ".$_SESSION['userid'];
				$db = $conn->execute( $sql );
				if( !$db ) {
					print "<a href=\"calendaract.php?mode=participate&new=y&eventid=".$rsConn['eventid']."&userid=".$_SESSION['userid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."\" class=\"a2\" onClick=\"return confirmSubmit('Vill du anm&auml;la dig till denna aktivitet?')\">Sign me up Scotty!</a>";
				}
				else {
					print "<a href=\"calendaract.php?mode=participate&new=n&eventid=".$rsConn['eventid']."&userid=".$_SESSION['userid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."\" class=\"a2\" onClick=\"return confirmSubmit('Vill du avregistrera dig p&aring; denna aktivitet?')\">Jag &aring;ngrade mig!</a>";
				}
				print "</td><td class=\"calendarViewBottomRight\"><a href=\"javascript:void(0);\" onMouseOver=\" return overlib('".$participants."',CAPTION,'Deltagarlista!',STICKY);\" onMouseOut=\"return nd();\" class=\"a2\">Vi kommer!</a>";
			}
			else {
				print "&nbsp;</td><td class=\"calendarViewBottomRight\">&nbsp;";
			}?>
</td></tr></table>
</div>
<br/>
<?php
			//      $rsConn->MoveNext;
		}
	}

	//$rsConn->Close();
}
?>
	</div>
	<div class="column column-right grid_3">
<?php 
require_once( 'activitysearch.applet.php' );
require_once( 'calendar.php' );
require_once( 'wiseBox.applet.php' );
require_once( 'memberSearch.applet.php' );?>
</div>
</div>
</div>
<?php require_once( 'footer.php' );?>

