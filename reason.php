<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
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
						
		<div class="boxLeft">
		<h3 class="boxHeader">
		Senaste bilder:</h3>
		<h4 class="boxContent">

			<?php require_once( 'image.applet.php' );?>
		</h4>
		</div>
		
	</td>

		<td width="421" height="190" valign="top">
				
		<?php if( $_GET['message'] != "" ) {
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
$sql = "select username,eldsjalfind from users";
$reason = $conn->execute( $sql );
$reasons = $reason;
foreach( $reasons as $reason ) {
	print "<b>".$reason['username'].":</b>&nbsp;&nbsp;".$reason['eldsjalfind']."<br><br>";

	//  $reason->moveNext;
}
?>
		</td>			

	</tr>

<?php require_once( 'bottomInclude.php' );?>

