<?php
  session_start( );
session_register( "userid_session" );
session_register( "userid_session" );
?>
<?php ob_start( );

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

//Still have to switch frmo AspUploadC to persits.ASPUpload
// create objects
// $imageCom is of type "GflAx.GflAx"
// $objUpload is of type "ASPUploadComponent.cUpload"
// $objFSO is of type "Scripting.FileSystemObject"

$imageCom->EnableLZW = true;

// Set variables for saving

$MaxSize = 10000000;
$strUploadPath = $application['imagepath'];
$strFileExtensions = ".exe;.dll;.com;.psd;.vbs;.bat;.txt";
$message = "1";
$imagePath = $application['imagepath']."\\".$objUpload->form( "file1" )->$Value;
if( file_exists( $imagePath ) ) {
	unlink( $imagePath );
}
$objUpload->Form( "file1" )->$SaveFile$strUploadPath$objUpload->Form( "file1" )->$Value$strFileExtensions$maxSize;
if( $err ) {
	//an error occured... ie file already exists, invalid extension etc

	$strMsg = "Uploaderror ".0

	/* not sure how to convert err.Number */.": ".

	/* don't know how to convert err.Description */;
	header( "Location: "."register.php?mode=collect4&message=".$strMsg.$message );
	if( file_exists( $imagePath ) ) {
		unlink( $imagePath );
	}
}
else {
	//add description to the database?
	//cConn.execute ("INSERT INTO mydocs (FileName,Description) VALUES ('" & objUpload.Form("thefile").Value & "','" & objUpload.Form("description").Value

	$strMsg = "The file was successfully uploaded.";
}
$message = "2";

//if upload.Files("UploadFileName") is nothing then response.Redirect("register.php?mode=collect4&message=Du m&aring;ste ange en bild!")

$imageCom->loadBitmap$imagePath;
$imageName = $_SESSION['userid'];
$imageCom->SaveFormat = 1;
$imageCom->saveBitmap$DOCUMENT_ROOT."."."\\images\\userImages\\".$imagename.".jpg";

//jpeg.width = 100
//jpeg.height = 80

$message = "3";
$imageCom->loadBitmap$imagePath;
if( $imageCom->Width > $imageCom->Height ) {
	$height = round( $imageCom->Height * 100 / $imageCom->Width, 0 );
	$imageCom->Resize100$height;
}
else {
	$Height = 89;
	$width = round( $imageCom->Width * 89 / $imageCom->Height, 0 );
	$imageCom->Resize$width
}
$imageName = $_SESSION['userid'];
$imageCom->SaveFormat = 1;
$imageCom->saveBitmap$DOCUMENT_ROOT."."."\\images\\userImages\\tn_".$imageName.".jpg";
if( file_exists( $imagePath ) ) {
	unlink( $imagePath );
}
$message = "3";
$imageCom = null;
if( $err != 0 ) {
	$message = $message."Det blev fel p&aring; bildhantering: ".

	/* don't know how to convert err.Description */."<br>";
	header( "Location: "."register.php?mode=collect4&message=".$message );
}
$sql = "update users set hasimage = 1, redirect = '' where userid = ".$_SESSION['userid'];
$updated = $updated_query = mysql_query(( $sql ), $conn );
$updated = mysql_fetch_array( $updated_query );;
$message = "4";
header( "Location: "."userPresentation.php?userid=".$_SESSION['userid'] );
$objUpload = null;
mysql_close( $conn );
?>
