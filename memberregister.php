<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>
<?php 
if( $_SESSION['usertype'] < 4 ) {
	header( "Location: "."http://www.eldsjal.org/main.php" );
}?>
	<tr>
		<td valign="top" align="left">
			<div class="boxLeft">
				<?php require_once( 'toolbox.applet.php' );?>
			</div>
			<div class="boxLeft">
				<h3 class="boxHeader">senast inloggade:</h3>
				<h4 class="boxContent"><?php require_once( 'userHistory.applet.php' );?></h4>
			</div>
			<div class="boxLeft">
				<h3 class="boxHeader">nya tankar:</h3>
				<h4 class="boxContent"><?php require_once( 'diarys.applet.php' );?></h4>
			</div>
		</td>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
<!--
function openUserImage(fileName)
{
window.open(fileName, "userImage", "fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,directories=no,location=no,left=100,top=10,width=300,height=300")
}

function openInfo(url)
{
window.open(url, 'artInfo', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=auto,resizable=yes,directories=no,location=no,left=80,top=30,width=300,height=600');
}

function ValidateAccount()
{
if (document.register.personnummer.value.length<12){
alert("Personnummer skrivs med 12 siffror, inga tecken\nEx: 197902187835");
document.register.personnummer.focus();
return;
}
document.register.submit();
}

function isNumeric(str,message)
{

if (str == str.replace(/[^\d]*/gi,"")) {
}
else {
alert(message);
document.register.personnummer.value = "";

}
return;
}
				
-->
</SCRIPT>
		
		<td height="190" valign="top">
			<div class="regWindow1">     
				<table width="100%" cellpadding="0" cellspacing="0" ID="Table2">
					<tr valign="top">
						<td>
							<div class="newsText">
<?php 
print $_GET['message'];

// l&auml;gger till nya medlemmar som inte redan varit f&ouml;reningsmedlemmar

if( $_GET['mode'] == "addmemberinfo" ) {
	$sql = "select userid, username from users where userid not in (select userid from members) order by username";
	$info = $conn->execute( $sql );
	?>
								<B>Medlemmar som inte &auml;r f&ouml;reningsmedlemmar:</B><BR>
								<a href="memberRegister.php?mode=listmembers" class="a2">Lista/redigera redan registrerade medlemmar</a><br>
								<form action="memberRegister.php?mode=addmember" method="post" name="register" ID="register" onSubmit="return validateLogin();">
								<center>
									<TABLE CELLPADDING="2" CELLSPACING="5" border="0" width="100%" ID="Table1">
										<TR VALIGN="top" ALIGN="left">
											<TD>
												<SELECT name="userid" class="selectBox" >
													<?php 
  $infos = $info;
	foreach( $infos as $info ) {
		print "<option value=".$info['userid'].">".$info['username']."</option>";

		//    $info->moveNext;
	}
	?>
												</select>
												<div class="boxtext2">
													<input class="inputBorder" type="text" name="adress" id="adress" value="adress"><br>
													<input class="inputBorder" type="text" name="postnummer" id="postnummer" value="postnummer">&nbsp;<input class="inputBorder" type="text" name="postort" id="postort" value="Postort"><br>
													<input class="inputBorder" type="text" name="land" id="land" value="Sverige"><br>
													Personnummer (skrivs: 197902187835)<br>
													<input class="inputBorder" type="text" maxlength="12" name="personnummer" id="personnummer"><br><BR>
													<a href="javascript:ValidateAccount();"><IMG SRC="images/register.gif" border="0"></a> 
												</div>
											</TD>
										</TR>
									</TABLE>
								</center>
								</form>
<?php
	// l&auml;gger in information om nya medlemmar som inte redan varit det tidigare
}
elseif( $_GET['mode'] == "addmember" ) {
	if( $_POST['userid'] == "" ) {
		header( "Location: "."memberRegister.php?mode=addmemberinfo&message=Ingen användare vald" );
	}
	if( $_POST['personnummer'] == "" ) {
		header( "Location: "."memberRegister.php?mode=addmemberinfo&message=Inget personnummer angivet" );
	}
	$sql = "select max(memberno) as memberno from members";
	$memberno = $conn->execute( $sql );
	$sql = "insert into members (userid, adress, postnummer, postort, land, personnummer, membersince, regdate, memberno) values (".intval( $_POST['userid'] ).", '".cq( $_POST['adress'] )."', '".cq( $_POST['postnummer'] )."', '".cq( $_POST['postort'] )."', '".cq( $_POST['land'] )."', ".$_POST['personnummer'].", getdate(), getdate(), ".intval( $memberno['memberno'] + 1 ).")";
	$conn->execute( $sql );
	$sql = "select username from users where userid = ".$_POST['userid'];
	$username = $conn->execute( $sql );
	$message = "Nu är ".$userNAme['username']." registrerad som föreningsmedlem";
	header( "Location: "."memberRegister.php?mode=addmemberinfo&message=".$message );

	// listar alla nuvarande medlemmar
}
elseif( $_GET['mode'] == "listmembers" ) {
	$sql = "select username, userid from users where userid in (select userid from members where is_member = 1) order by username";
	$activemembers = $conn->execute( $sql );
	$sql = "select count(userid) as antal from users where userid in (select userid from members where is_member = 1)";
	$sumactive = $conn->execute( $sql );
	$sql = "select username, userid from users where userid in (select userid from members where is_member = 0) order by username";
	$inactivemembers = $conn->execute( $sql );
	$sql = "select count(userid) as antal from users where userid in (select userid from members where is_member = 0)";
	$suminactive = $conn->execute( $sql );
	?>
								<B>Medlemmar som &auml;r registrerade:</B><BR>
								<a href="memberRegister.php?mode=addmemberinfo" class="a2">L&auml;gg till nya medlemmar</a><br>

								<center>
									<TABLE CELLPADDING="2" CELLSPACING="5" border="0" width="100%" ID="Table1">
										<TR VALIGN="top" ALIGN="left">
											<TD><B>Aktiva (<?php   print $sumactive['antal'];?>):</B><BR>
												<?php 
  $activememberss = $activemembers;
	foreach( $activememberss as $activemembers ) {
		print "<a href=\"memberRegister.php?mode=editmember&userid=".$activemembers['userid']."\" class=a2>".$activemembers['username']."</a><BR>";

		//    $activemembers->moveNext;
	}
	?>
											</TD>
											<TD><B>Inktiva (<?php   print $suminactive['antal'];?>):</B><BR>
												<?php 
  $inactivememberss = $inactivemembers;
	foreach( $inactivememberss as $inactivemembers ) {
		print "<a href=\"memberRegister.php?mode=editmember&userid=".$inactivemembers['userid']."\" class=a2>".$inactivemembers['username']."</a><BR>";

		//    $inactivemembers->moveNext;
	}
	?>
											</TD>
										</TR>
									</TABLE>
								</center>
<?php
	// redigerar nuvarande medlem
}
elseif( $_GET['mode'] == "editmember" ) {
	if( $_GET['userid'] == "" ) {
		header( "Location: "."memberRegister.php?mode=listmembers&message=Ingen användare vald" );
	}
	$sql = "select * from members where userid = ".$_GET['userid'];
	$my_db_member = $conn->execute( $sql );
	$sql = "select username from users where userid = ".$_GET['userid'];
	$db_username = $conn->execute( $sql );
	?>
								<B>Redigerar medlem "<?php   print $db_username['username'];?>":</B><BR>
								<a href="memberRegister.php?mode=listmembers" class="a2">Lista/redigera redan registrerade medlemmar</a><br>
								<a href="memberRegister.php?mode=addmemberinfo" class="a2">L&auml;gg till nya medlemmar</a><br>
								<form action="memberRegister.php?mode=savemember" method="post" name="register" ID="register">
								<center>
									<TABLE CELLPADDING="2" CELLSPACING="5" border="0" width="100%" ID="Table1">
										<TR VALIGN="top" ALIGN="left">
											<TD>

												<div class="boxtext2">
													<input type="hidden" name="memberid" value="<?php   print $my_db_member['memberid'];?>">
													F&ouml;reningsmedlem nummer: <?php   print $my_db_member['memberno'];?><BR>
													Medlem sedan: <?php   print $my_db_member['membersince'];?><BR>
													<input class="inputBorder" type="text" name="adress" id="adress" value="<?php   print $my_db_member['adress'];?>"><br>
													<input class="inputBorder" type="text" name="postnummer" id="postnummer" value="<?php   print $my_db_member['postnummer'];?>">&nbsp;<input class="inputBorder" type="text" name="postort" id="postort" value="<?php   print $my_db_member['postort'];?>"><br>
													<input class="inputBorder" type="text" name="land" id="land" value="<?php   print $my_db_member['land'];?>"><br>
													<input class="inputBorder" maxlength="12" type="text" name="personnummer" id="personnummer" value="<?php   print $my_db_member['personnummer'];?>">(12 siffror, ex 197902187835)<BR>
													<INPUT class="inputBorder" TYPE="text" name="notes" value="<?php   print $my_db_member['notes'];?>">(anteckningar)<BR>
													Medlem i &aring;r:
													<SELECT name="is_member" class="selectBox" >
														<option value=0 <?php   if( $my_db_member['is_member'] == "0" ) {
		print "SELECTED";
	}?>>Nej</OPTION>
														<option value=1 <?php   if( $my_db_member['is_member'] == "1" ) {
		print "SELECTED";
	}?>>Ja</OPTION>
													</select><BR>
													<INPUT TYPE="checkbox" name="uppdatera" value="1"> Spara medlemsstatus<BR>
													<INPUT TYPE="submit" value="Spara f&ouml;r&auml;ndringar"></a> 
												</div>
											</TD>
										</TR>
									</TABLE>
								</center>
								</form>
<?php
	// sparar uppdaterad medlem
}
elseif( $_GET['mode'] == "savemember" ) {
	if( $_POST['memberid'] == "" ) {
		header( "Location: "."memberRegister.php?mode=listmembers&message=Ingen användare vald" );
	}
	if( $_POST['uppdatera'] == "1" ) {
		$sql = "update members set adress = '".cq( $_POST['adress'] )."', postnummer = '".cq( $_POST['postnummer'] )."', postort = '".cq( $_POST['postort'] )."', land = '".cq( $_POST['land'] )."', personnummer = '".cq( $_POST['personnummer'] )."', notes = '".cq( $_POST['notes'] )."', regdate = getdate(), is_member = '1' where memberid = '".cq( $_POST['memberid'] )."'";
		$conn->execute( $sql );
		if( $_POST['memberid'] == "" ) {
			header( "Location: "."memberRegister.php?mode=listmembers&message=Informationen sparad" );
		}
	}
	elseif( $_POST['uppdatera'] == "" ) {
		$sql = "update members set adress = '".cq( $_POST['adress'] )."', postnummer = '".cq( $_POST['postnummer'] )."', postort = '".cq( $_POST['postort'] )."', land = '".cq( $_POST['land'] )."', personnummer = '".cq( $_POST['personnummer'] )."', notes = '".cq( $_POST['notes'] )."' where memberid = '".cq( $_POST['memberid'] )."'";
		$conn->execute( $sql );
		if( $_POST['memberid'] == "" ) {
			header( "Location: "."memberRegister.php?mode=listmembers&message=Informationen sparad" );
		}
	}
}
else {
	print "<BR><BR><a href=\"memberRegister.php?mode=addmemberinfo\" class=\"a2\">Registrera ny &raquo;</a>";
}
?>
							</div>
						</TD>
					 </TR>
				</TABLE>
			</div>
		</td>
		<td width="145" height="109" valign="top" align="right">
			<div class="boxRight">
				<h3 class="boxHeader">Aktiviteter</h3>
				<h4 class="boxContentCalendar"><?php require_once( 'calendar.php' );?></h4>
			</div>
			<div class="boxRight">
				<h3 class="boxHeader">Senaste bilder:</h3>
				<h4 class="boxContent"><?php require_once( 'image.applet.php' );?></h4>
			</div>
		</td>
	</tr>
<?php require_once( 'bottomInclude.php' );?>
