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
<?php require_once( 'topInclude.php' );?>
	<tr>
		<td valign="top" align="left">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
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
				
	</td>
<?php 
if( $_SESSION['userid'] == "" ) {
	header( "Location: "."main.php?message=Inte inloggad" );
}
if( $_GET['mode'] == "" ) {
	?>

		<td height="190" valign="top">
		<div class="regWindow1">     
		       <table width="100%" cellpadding="0" cellspacing="0" ID="Table2">
		       <tr valign="top">
		       <td>
		       <div class="newsText">
		Du som f&aring;r detta meddelande &auml;r f&ouml;reningsmedlem. Vi beh&ouml;ver ditt fullst&auml;ndiga personnummer f&ouml;r f&ouml;reningsdatabasen.
		<br>
		<br>
			<?php 

  $sql = "select personnummer from members where userid = ".intval( $_SESSION['userid'] );
	$db = $conn->execute( $sql );
	?>
			
				<form action="correctInfo.php?mode=personnummer" method="post" name="register" ID="register">
				<center>
				<TABLE CELLPADDING="2" CELLSPACING="5" border="0" width="100%" ID="Table1">
				<TR VALIGN="top" ALIGN="left">
				<TD>
				Personnummer (skrivs: 197902187835)<br>
				<input class="inputBorder" type="text" name="personnummer" id="personnummer"><br>
				<br>
				<input type="submit" value="spara">
				</TD>
		</TR>
	</TABLE>
				
				</center>
				</form>
			<?php
}
elseif( $_GET['mode'] == "personnummer" ) {
	if( $_POST['personnummer'] == "" ) {
		header( "Location: "."correctInfo.php&message=Inget personnummer angivet" );
	}
	$sql = "update members set personnummer = '".$_POST['personnummer']."' where userid = ".$_SESSION['userid'];
	$conn->execute( $sql );
	$sql = "update users set redirect = '' where userid =".$_SESSION['userid'];
	$conn->execute( $sql );
	header( "Location: "."main.php?message=Tack s&aring; mycket!" );
}
?>
				 </TD>
				 </div>
				 </TR>
		         </TABLE>

		</td>
		
		<td width="145" height="109" valign="top" align="right">

		<div class="boxRight">
		<h3 class="boxHeader">Aktiviteter</h3>
		<h4 class="boxContentCalendar">
				<?php require_once( 'calendar.php' );?>
		</h4></div>
		
			
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
