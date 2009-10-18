<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php 
$noredirect = 1;
?>
<?php require_once( 'topInclude.php'); ?>

<?php 
if ($_GET['db']=="yes" && $_SESSION['userid']!="")
{

  $sql="DELETE FROM newsNotify WHERE userid = ".$_SESSION['userid'];
  $conn->execute($sql);
} 


if ($_SESSION['userid']!="")
{

  $sql="UPDATE users SET redirect = '' WHERE userid = ".$_SESSION['userid']." AND redirect = 'http :

//www.eldsjal.org/news.php?newsID=54'";

$conn->execute( $sql );
}

//Disabled since reading news is a function in this file
//if session("userType") <= application("newsAdmin") then response.Redirect("main.php?message=Du har inte r&auml;ttigheter att administrera nyheter")

?>
	<tr>
		<td valign="top" align="left">
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
		senast inloggade:</h3>
		<h4 class="boxContent">
			<?php require_once( 'userHistory.applet.php' );?>
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
		Senaste bilder:</h3>
		<h4 class="boxContent">

			<?php require_once( 'image.applet.php' );?>
		</h4>
		</div>
		
	</td>

		<td width="421" height="190" valign="top">

<?php 
if( $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
if( $_GET['mode'] == "getImageName" ) {
	if( $_GET['newsid'] == "" ) {
		header( "Location: "."News.php?message=Inget newsid angett" );
	}
	?>
	<form name="form2" method="post" enctype="multipart/form-data" action="addNewsAct.php?mode=addImage&newsID=<?php   echo $_GET['newsid'];?>" ID="Form1">
	Bild<br>
	<input class="inputBorder"  value="" type="file" name="file1" size="40" ID="File1">
	
	Spara <input type="image" src="images/icons/arrows.gif" name="proceed" id="Image3" class="proceed">
	</form>
	<br>
	<?php
}
elseif( $_GET['mode'] == "add" ) {
	if( $_SESSION['usertype'] < $application['newsadmin'] ) {
		header( "Location: "."main.php?message=Du har inte r&auml;ttigheter att administrera nyheter" );
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
</script>

<div class="regWindow1"> 
	<form name="form2" method="post" action="addNewsAct.php?mode=addNews" ID="Form1">
	<font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
	<?php 
  $yy = strftime( "%Y", time( ) );
	$mm = strftime( "%m", time( ) );
	$dd = $day[time( )];
	?>
	<select name="yyyy" class="selectBox" ID="Select1">
		<?php   for( $x = strftime( "%Y", time( ) ); $x <= strftime( "%Y", time( ) ) + 3; $x = $x + 1 ) {
		print "<option value=".$x;
		if( $yy == $x ) {
			print " selected";
		}
		print ">".$x."</option>";
	}?>
	</select>
	&Aring;R 
	<select name="mm" class="selectBox" ID="Select2">
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
	<select name="dd" class="selectBox" ID="Select3">
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
	?>  
	</select>
	DAG
	
	<div class="boxtext2">
	Rubrik<br>
	<input class="inputBorder" type="text" name="newsHeader" size="40" ID="Text1">
	<br>
	Ingress<br>
	<input class="inputBorder" type="text" name="newsIngress" size="40" ID="Text2">
	<br>
	Nyheten:<br>
	<textarea class="inputBorder" name="newsText" cols="65" rows="10" ID="Textarea1"></textarea>
	<br>
	URL<br>
	<input class="inputBorder" type="text" value="http://" name="newsUrl" size="40" ID="Text3">
	<br>
	URL beskrivning<br>
	<input class="inputBorder" type="text" name="newsURLDesc" size="40" ID="Text4">
	<br><input type="checkbox" value="1" name="bild"> Bifoga bild till aktivitet
	
	<br>
	Spara <input type="image" onClick="return confirmSubmit('Vill du l&auml;gga till denna nyhet?')" src="images/icons/arrows.gif" name="proceed" id="proceed" class="proceed">
	</div>
	</font> 
	</form>
	<?php
}
else {
	if( $_GET['newsid'] != "" ) {
		$sql = "select * from news where newsid = ".intval( $_GET['newsid'] );
		$news = $conn->execute( $sql );
		if( $news ) {
			print "<br><br><i>Hittade ingen s&aring;n nyhet!</i>";
		}
		else {
			print "<br><br><TABLE BORDER=0 width=420 CELLPADDING=0 CELLSPACING=0><tr>";
			if( $news['newsimagename'] != "" ) {
				print "<td valign=top align=right rowspan=4><IMG SRC=images/news/tn_".$news['newsimagename']." BORDER=0></td><td valign=top rowspan=4><IMG SRC=images/1x1.gif HEIGHT=1 WIDTH=10 BORDER=0></TD>";
			}
			print "<td class=plainTHead2 valign=top >".$news['newsheader']."</td><td width=120 valign=top align=right>";
			if( $_SESSION['usertype'] >= intval( $application['newsadmin'] ) ) {
				print "<a href=News.php?mode=updateNews&newsID=".$news['newsid']."><img src=/images/icons/edit.gif border=0></a><a href=addNewsAct.php?mode=delete&newsID=".$news['newsid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort denna nyhet?');\"><img src=/images/icons/trashcan.gif border=0></a>";
			}
			print $news['newsdate']."</td></tr>";
			print "<tr><td class=plainText colspan=2 valign=top><i>".rq( $news['newsingress'] )."</i></td></tr>";
			print "<tr><td class=plainText colspan=2 valign=top>".rq( $news['newstext'] )."</td></tr>";
			print "<tr><td colspan=2 valign=top><a class=a2 href=".$news['newsurl']." target=_blank alt=".$news['newsurl'].">";
			if( $news['newsurldesc'] != "" ) {
				print substr( $news['newsurldesc'], 0, 50 )."..."."</a>";
			}
			else {
				if( $URL != "" ) {
					$URL = substr( $news['newsurl'], 0, 50 )."...";
					print $url."</a>";
				}
			}
			print "</td></tr></table>";
		}
		$news = null;
	}
}
$sql = "select * from news order by newsdate desc";
$list = $conn->execute( $sql );
?>
	<br><br>
	<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>SAMTLIGA NYHETER</b></font><br>
	<table width="400" border="0" cellspacing="0" cellpadding="1" ID="Table1">
	<tr> 
		<td bgcolor="#666666"> 
		<table width="450" border="0" cellspacing="0" cellpadding="2" bgcolor="#CCCCCC" ID="Table2">
			<?php 
if( $list ) {
	while( !( $list ) ) {
		print "<tr><td bgcolor=#CCCCCC><font size=1 face=\"Verdana, Arial, Helvetica, sans-serif\">".$formatDateTime[$list['newsdate']][$vbShortDate]." - <a href=news.php?newsID=".$list['newsid']." class=a2>".$list['newsheader']."</a></td>";
		if( $_SESSION['usertype'] >= $application['newsadmin'] ) {
			print "<td><a href=news.php?mode=edit&newsID=".$list['newsid']."><img src=images/icons/edit.gif border=0></a><a href=addNewsAct.php?mode=delete&newsID=".$list['newsid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort denna nyhet?');\"><img src=images/icons/trashcan.gif border=0></a></td>";
		}
		print "</tr>";

		//    $list->moveNext;
	}
}
else {
	print "Inga nyheter inf&ouml;rda";
}
$list->Close;
$list = null;
?>
				</font></td>
			</tr>
			<?php 
if( $_SESSION['usertype'] >= $application['newsadmin'] ) {
	?>
			<tr>
			<td colspan="2">
			<form name="newsCount" method="get" action="addNewsAct.php">
			Nyhetsantal: <input class="inputBorder" type="text" name="newsItems" size="2" value="<?php   echo $application['systemnewsitems'];?>">
			<br>
			<input type="submit" value="spara" size="2">
			<input type="hidden" name="mode" value="newsCount">
			</form>
			</td>
			</tr>
			<?php
}
?>
		</table>
		</td>
	</tr>
	</table>
	</div>
		</td>
		
			<td valign="top" align="right">
		
		<div class="boxRight">
		<h3 class="boxHeader">Aktivitetss&ouml;k</h3>
		<h4 class="boxContentCalendar">
				<?php require_once( 'activitySearch.applet.php' );?>
		</h4></div>
				
		<div class="boxRight">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar">
				<?php require_once( 'calendar.php' );?>
		</h4></div>
				
		<div class="boxRight" align="left">
		<h3 class="boxHeader">
		Visheter</h3>
		<h4 class="boxContent">
		<div class="plainText">		
			<?php require_once( 'wiseBox.applet.php' );?>		
		</div>			
		</h4>
		</div>	

		
		<div class="boxRight">
		<h3 class="boxHeader">
		S&ouml;k medlem:</h3>
		<h4 class="boxContent">

			<?php require_once( 'memberSearch.applet.php' );?>
		</h4>
		</div>
			
	</td>
	</tr>

<?php require_once( 'bottomInclude.php' );?>

