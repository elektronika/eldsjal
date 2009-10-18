<?php require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
	<div class="column column-left grid_3 prefix_1">
<?php 
require( 'toolbox.applet.php' );

if( isset($_SESSION['userid']) && !empty($_SESSION['userid']) ) {
	require( 'action.applet.php' );
}
require( 'wiseBox.applet.php' );
require( 'diarys.applet.php' );
require( 'userHistory.applet.php' );
require( 'image.applet.php' );?>
	</div>
	<div class="column column-middle grid_8">
<?php 
if( $_GET['userid'] == "" ) {
	header( "Location: "."main.php?message=Det finns ingen s&aring;dan medlem!" );
}
if( $_GET['userid'] != "" ) {
	$sql = "select * from users inner join locations on users.city = locations.locationid where users.userid = ".intval( $_GET['userid'] );
	$dbUser = $conn->execute( $sql );
	if( isset($_SESSION['userid']) && !empty($_SESSION['userid']) ) {
		//LOGGER

		if( $_SESSION['userid'] == intval( $_GET['userid'] ) ) {
			$sql = "replace into history (action, userid, nick, message, [date], security) values ('userview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." tittar p&aring; sin egen presentation', getdate(), 0)";
		}
		else {
			if( $conn->type == 'mssql' )
				$sql = "replace into history (action, userid, nick, message, [date], security) values ('userview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." besk&aring;dar \"".$dbUser['username']."\"s vackra presentation', getdate(), 0)";
			else
				$sql = "replace into history (action, userid, nick, message, date, security) values ('userview',".$_SESSION['userid'].", '".$_SESSION['username']."', '".$_SESSION['username']." besk&aring;dar \"".$dbUser['username']."\"s vackra presentation', now(), 0)";
			
		}
		$conn->execute( $sql );
	}

	//if dbUser("private") = true AND session("userid") = "" then response.Redirect("main.php?message=Den h&auml;r anv&auml;ndaren f&aring;r endast f&ouml;r Eldsj&auml;lar att k&auml;nna!")
	if( !$dbUser ) {
		header( "Location: "."main.php?message=Det finns ingen användare med det ID:t" );
	}

	$homepage = $dbUser['webpage'];
	if( $homepage == "http://" ) {
		$homepage = "";
	}


	$sql = "select username, userid, approvedby from users where userid = ".intval( $dbUser['approvedby'] );
	$dbParent = $conn->execute( $sql );


	$sql = "select count(userid) as count from loginhistory where userid = ".$_GET['userid'];
	$dbLoginCount = $conn->execute( $sql );
	print isset( $_GET['message'] ) ? $_GET['message'] : '';
	?>
		       
				<div class=presentationTop>
<?php
	///////////// &Aring;ldersber&auml;kning ////////////////////

	$age = age(mktime( 0, 0, 0, $dbUser['born_month'], $dbUser['born_date'], $dbUser['born_year'] ));

	//////////////////////////////////////////////////

	if( $dbUser['private'] == 1 && (!isset($_SESSION['userid']) || empty($_SESSION['userid'])) ) {
		print "<B>".$dbUser['username']."</B></div>";
	}
	else {
		if( $dbUser['first_name'] != $dbUser['username'] ) {
			print $dbUser['first_name']." <b>'".$dbUser['username']."'</b> ".$dbUser['last_name'].", ";
		}
		else {
			print "<b>".$dbUser['username']."</b> ".$dbUser['last_name'].", ";
		}
		if( $dbUser['gender'] == 0 ) {
			print "kille, ".$age." &aring;r";
		}
		else {
			print "tjej, ".$age." &aring;r";
		}
	    if( $dbUser['online'] == 1 || $dbUser['online'] == true ) {
				print " <font color=#009900>Online</font>";
			}
			else {
				print " <i><font color=#FF0000>Offline</font></i>";
			}
		print '</div><div class="presentationSub">';
		print $dbUser['inhabitance'].", ".$dbUser['locationname'];
		if(( $dbUser['born_month'] == strftime( "%m", time( ) ) ) && ( $dbUser['born_date'] == $day[time( )] ) ) {
			print "&nbsp;&nbsp;&nbsp;<B>FYLLER &Aring;R IDAG!!</B>";
		}
		print '</div>';
	}
	?>
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0">

				 <TR>
		
				 <TD WIDTH="97" class="presentationPhoto">
<?php 
if( $dbUser['hasimage'] == true ) {
		print "<a href=javascript:openUserImage('uploads/userImages/".$dbUser['userid'].".jpg');><img src=\"uploads/userImages/tn_".$dbUser['userid'].".jpg\" border=\"0\"></a>";
	}
	else {
		print "<img src=images/ingetfoto.gif>";
	}
	?>
				</td>
				 <TD width="100%" class="presentationInfoTop">
			<!---------------------------INFORUTAN-------------------------------------->
				             <table width="100%" cellpadding="0" cellspacing="0">
				             <tr>
				             <td>
				             <div class="newsText">
<?php
	//if users has 0 as private or has 1 and the visitor is logged in then display

	if( $dbUser['private'] == 0 || ( $dbUser['private'] == 1 && isset($_SESSION['userid']) && !empty($_SESSION['userid']) ) ) {
		?>
				
				<div class="newsText"> <B>Mail</B>: <?php     echo $dbUser['email'];
    if( $homepage != "" ) {
			print "<div class=newsText> <B>Hemsida</B>: ".rq($homepage)." </div>";
		}

		//Uppe ofta men fula bilder, g&aring;r att byta till v&aring;r /images/icons
		//if dbUser("msn") <> "" then response.Write("<img src=http://arkansasmall.tcworks.net:8080/msn/" & dbUser("msn") & " border=0 ALT=Jag &auml;r online> " & dbUser("msn") & "<br/>")
		//if dbUser("icq") <> "" then response.Write("<img src=http://arkansasmall.tcworks.net:8080/icq/" & dbUser("icq") & " border=0 ALT=Jag &auml;r online> " & dbUser("icq") & "<br/>")
		//if dbUser("yahoo") <> "" then response.Write("<img src=http://arkansasmall.tcworks.net:8080/yahoo/" & dbUser("yahoo") & " border=0 ALT=Jag &auml;r online> " & dbUser("yahoo") & "<br/>")
		// Snygga bilder och opr&ouml;vad
		//if dbUser("msn") <> "" then response.Write("<img src=http://ohbox.ods.org/onlinestatus/msn/" & dbUser("msn") & " border=0 ALT=Jag &auml;r online> " & dbUser("msn") & "<br/>")
		//if dbUser("icq") <> "" then response.Write("<img src=http://ohbox.ods.org/onlinestatus/icq/" & dbUser("icq") & " border=0 ALT=Jag &auml;r online> " & dbUser("icq") & "<br/>")
		//if dbUser("yahoo") <> "" then response.Write("<img src=http://ohbox.ods.org/onlinestatus/yahoo/" & dbUser("yahoo") & " border=0 ALT=Jag &auml;r online> " & dbUser("yahoo") & "<br/>")
		// Snygga bilder, s&auml;ger 99  uptid men &auml;r ofta nere
		//if dbUser("msn") <> "" then response.Write("<img src=http://status.inkiboo.com:8080/msn/" & dbUser("msn") & " border=0 ALT=Jag &auml;r online> " & dbUser("msn") & "<br/>")
		//if dbUser("icq") <> "" then response.Write("<img src=http://status.inkiboo.com:8080/icq/" & dbUser("icq") & " border=0 ALT=Jag &auml;r online> " & dbUser("icq") & "<br/>")
		//if dbUser("yahoo") <> "" then response.Write("<img src=http://status.inkiboo.com:8080/yahoo/" & dbUser("yahoo") & " border=0 ALT=Jag &auml;r online> " & dbUser("yahoo") & "<br/>")
		// V&aring;ra bilder, utan statuscheck

		if( $dbUser['msn'] != "" ) {
			print "<img src=\"images/msn.gif\">".$dbUser['msn']."<br/>";
		}
		if( isset($dbUser['icq']) && trim($dbUser['icq']) != '' ) {
			print "<img src=\"images/icq.gif\">".$dbUser['icq']."<br/>";
		}
		if( $dbUser['yahoo'] != "" ) {
			print "Telefon: ".$dbUser['yahoo']."<br/>";
		}?>

				   </td>
				   <td>
<?php /*
				 <div class="newsText"><B>Inloggningar:</b></div>
				 <div class="newsText"><?php     echo $dbLoginCount['count'];?></div> 
		*/ ?>		 
				 
				 <div class="newsText"><b>Senast inlogg</b></div>
				 <div class="newsText">
<?php
		//while not dbHistory.eof

		if( $dbUser['lastlogin'] != "" ) {
			//$lastLogin=$response->Write($Cdate[$dbUser['lastlogin']]);

			print timeSince(strtotime($dbUser['lastlogin']));
		}
		else {
			print "<i>ej loggat in &auml;nnu!</i>";
		}
		?>
				 </div>
				 <div class="newsText"><b>Medlem sedan</b></div>
<?php if( $_GET['userid'] == 69 ) { ?>
	 <div class="newsText">Tidernas begynnelse</div> 
<?php } else { ?>
	 <div class="newsText"><?php echo date( 'Y-m-d', strtotime( $dbUser['register_date'] ) );
} ?>
				<br/>
<?php 
  if( $dbParent ) {
			if( $_GET['userid'] == 69 ) {
				?>
					<div class="newsText"><b>Fadder:</b></div>
					<div class="newsText">Gudfar</div> 
<?php
			}
			else {
				?>
					<div class="newsText"><b>Fadder:</b></div>
					<div class="newsText"><a href="userPresentation.php?userid=<?php         echo $dbParent['userid'];?>" class="a2"><?php         echo $dbParent['username'];?></a></div> 
<?php
			}
		}
		else {
			?>
					<div class="newsText"><b>V&auml;ntar p&aring; godk&auml;nnande!</b><br/></div>
<?php
		}
		?>
				 </td></tr><div class="newsText">
<?php
	} else {
		print "<b>Jag har valt att utel&auml;mna mina uppgifter f&ouml;r icke Eldsj&auml;lar!</b>";
	}
	?>
				 </div> 
		
		
				 </tr>
				 </td>
				 </table>
				 
				 
				 
				 
				 </TD></div>
				 </TR>
				 
				 <tr>
				  <td colspan="2">
<?php 
if( isset($_SESSION['userid']) && !empty($_SESSION['userid']) ) {
		if( $_GET['userid'] == 252 ) {
			$sql = "select first_name from users where userid=".$_SESSION['userid'];
			$result = $conn->execute( $sql );
			print "<font size=2 color=purple><b>Hej ".$result['first_name']."!"."</b></font><br/><br/>";
		}
	}
	if( $dbUser['presentation'] != "" ) {
		$formatText = rq( $dbUser['presentation'] );
		print $formatText;
	}
	?>
				  
				  </td>
				 </tr>
				 
		         </TABLE>
<?php
}
else {
	print "Det finns ingen presentation h&auml;r utan ID";
}
?>
	</div>
	<div class="column column-right grid_3">
<?php require( 'grejsBox.applet.php' );?>
<?php 
if( intval( $_GET['userid'] ) == $_SESSION['userid'] ) {
	?>
		<div class="box">
		<h3 class="boxHeader">Ändra uppgifter</h3>
		<div class="boxContents">	
		
		<a class="a2" href="userEdit.php?mode=editAccount&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Personuppgifter</a><br/>
		<a class="a2" href="userEdit.php?mode=presentation&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Presentation</a><br/>
		<a class="a2" href="userEdit.php?mode=artList&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Sysslar med</a><br/>
		<a class="a2" href="userEdit.php?mode=image&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Bild</a><br/><br/>
		</div>
		</div>
<?php
}
else {
	?>	
<?php require( 'friends.applet.php' );

}

/////////////////////////////////////////////


require( 'addgbentry.applet.php' );?>
		<div class="box">
		<h3 class="boxHeader">Sysslar med</h3>
		<div class="boxContents">
<?php 
$sql = "select * from artlist inner join userartlist on artlist.artid = userartlist.artid where userartlist.userid = ".$_GET['userid'];

$artLists = $conn->execute( $sql );
if( $artLists ) {
if(!is_array(current($artLists)))
	$artLists = array($artLists);
	
foreach( $artLists as $artList ) {
	print "<a class=\"a2\" href=\"javascript:openInfo('shortInfo.php?mode=".$artList['artid']."')\"><img src=images/icons/pluss.gif border=\"0\"> ".$artList['artname']."</a><br/>";

	//  //$artList->movenext;
}
} else {
	print "<a class=\"a2\" href=\"javascript:void(0)\"><img src=images/icons/pluss.gif border=\"0\"> Ingenting!</a><br/>";	
}
if( $_GET['userid'] == 5122 ) {?>
<a class="a2" href="javascript:void()"><img src=images/icons/pluss.gif border="0"> Eng&aring;ngsgrill</a><br/>
<?php
}
if( $_GET['userid'] == 4943 ) {?>
<a class="a2" href="javascript:void()"><img src=images/icons/pluss.gif border="0"> Hotbrev</a><br/>
<?php } ?>
</div></div>
<?php
require( 'calendar.php' );

if( $_GET['userid'] == 69 || $_GET['userid'] == 116 || $_GET['userid'] == 286 ) { ?>
		 <div class="box">
		<h3 class="boxHeader">Ansök om sex</h3>
		<div class="boxContents">
		
		P&aring; grund av anstormningen till denna funktion har k&ouml;lappsfunktionen g&aring;tt s&ouml;nder.<br/><br/>Reparation p&aring;g&aring;r!
		</div> 
		</div>
<?php
}


if( $_GET['userid'] == 182 || $_GET['userid'] == 231 || $_GET['userid'] == 252 || $_GET['userid'] == 1686 ) {
	
 echo $_GET['userid'];?>" class="a2">fr&aring;ga chans!</a>
		</div> 
<?php
}
require( 'memberSearch.applet.php' );?>
		
	</div>
	</div>
	</div>
<?php require( 'footer.php' );?>
