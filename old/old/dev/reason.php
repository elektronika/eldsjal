<?php
session_start( );






require_once( 'header.php' );?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );
require_once( 'diarys.applet.php' );
require_once( 'image.applet.php' );?>
		
		
	</td>

		<td width="421" height="190">
<?php if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
$sql = "select username,eldsjalfind from users";
$reason = $conn->execute( $sql );
$reasons = $reason;
foreach( $reasons as $reason ) {
	print "<b>".$reason['username'].":</b>&nbsp;&nbsp;".$reason['eldsjalfind']."<br/><br/>";

	//  $reason->moveNext;
}
?>
		</td>			

	</tr>
<?php require_once( 'footer.php' );?>

