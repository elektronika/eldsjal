<?php
  session_start( );
session_register( "userid_session" );
$dont_display_header = true;
require_once( 'topInclude.php' );
?>
<?php
  ob_start( );
header( "Expires: ".gmdate( "D, d M Y H:i:s", time( ) + ( 10 * 60 ) )." GMT" );
if( $_SESSION['userid'] == "" ) {
	header( "Location: "."main.php?message=Du hamnade galet nu, skaffa ett konto om du inte har ett och f&ouml;rs&ouml;k sedan igen" );
}

if( $_GET['mode'] == "dismiss" ) {
	if( $_GET['id'] != "" ) {
		$sql = "select user_id from friends where id=".intval( $_GET['id'] );
		$dbAction = $conn->execute( $sql );

		//$dbAction=mysql_fetch_array($dbAction_query);;

		if( $dbAction['user_id'] != $_SESSION['userid'] ) {
			header( "Location: "."main.php?message=Du f&ouml;rs&ouml;kte dissa en relation du inte &auml;ger, aja baja!" );
		}
		$sql = "delete from friends where id = ".intval( $_GET['id'] );
		$dbAction = $conn->execute( $sql );

		//$dbAction=mysql_fetch_array($dbAction_query);;

		$dbAction = null;
		header( "Location: "."friends.php?userid=".$_SESSION['userid']."&message=".urlencode("Där rök den vänskapen!") );
	}
	else {
		header( "Location: "."main.php?message=Det blev n&aring;got tokigt vid dissandet av relationen, f&ouml;rs&ouml;k g&auml;rna igen och kontrollera att du inte blivit utloggad!" );
	}
}
elseif( $_GET['mode'] == "approve" ) {
	if( $_GET['id'] != "" ) {
		$sql = "select * from friends where id=".intval( $_GET['id'] );
		$dbAction = $conn->execute( $sql );

		//$dbAction=mysql_fetch_array($dbAction_query);;

		if( $dbAction['user_id'] != $_SESSION['userid'] ) {
			header( "Location: "."main.php?message=Du f&ouml;rs&ouml;kte godk&auml;nna en relation du inte &auml;ger, aja baja!" );
		}
		$sql = "update friends set accepted = 1 where id = ".intval( $_GET['id'] );
		$dbAction = $conn->execute( $sql );

		//$dbAction=mysql_fetch_array($dbAction_query);;

		$dbAction = null;
		header( "Location: "."friends.php?userid=".$_SESSION['userid']."&message=Smutt...ny relation och allt!" );
	}
	else {
		header( "Location: "."main.php?message=Det blev n&aring;got tokigt vid dissandet av relationen, f&ouml;rs&ouml;k g&auml;rna igen och kontrollera att du inte blivit utloggad!" );
	}
}
else {
	if( $_POST['friendType'] == "" || $_SESSION['userid'] == "" || $_POST['touserid'] == "" ) {
		$message = urlencode("Det saknas information nog för att fixa biffen, prova igen!");
		header( "Location: "."userPresentation.php?userid=".$_POST['touserid']."&message=".$message );
	}
	else {
		$sql = "delete from friends where user_id = ".intval( $_POST['touserid'] )." and friend_id = ".intval( $_SESSION['userid'] )." or friend_id = ".intval( $_POST['touserid'] )." and user_id = ".intval( $_SESSION['userid'] );
		$storeFriend = $conn->execute( $sql );

		//$storeFriend=mysql_fetch_array($storeFriend_query);;

		$sql = "insert into friends (user_id, friend_id, friendtype, date, accepted) values (".intval( $_POST['touserid'] ).", ".intval( $_SESSION['userid'] ).", ".intval( $_POST['friendType'] ).", getdate(), 0)";
		$storeFriend = $conn->execute( $sql );

		//$storeFriend=mysql_fetch_array($storeFriend_query);;

		$storeFriend = null;
		$message = urlencode("Nu har en ödmjuk förfrågan skickats, håll tummarna!");
		header( "Location: "."userPresentation.php?userid=".$_POST['touserid']."&message=".$message );
	}
}
mysql_close( $conn );
?>