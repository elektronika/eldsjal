<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
?>
<?php require_once( 'topInclude.php" -->

<?php 

if ($_SESSION['usertype']=="" || $_SESSION['userid']=="" || $_SESSION['userid']==0)
{
  header("Location: "."calendarView.php?message=Du &auml;r inte inloggad eller saknar r&auml;ttigheter");
} 

if ($_GET['mode']=="addNews")
{

  $title=CQ($_POST['newsheader']);
  $text=CQ($_POST['newstext']);
  $ingress=CQ($_POST['newsingress']);
  $URL=CQ($_POST['newsurl']);
  $URLDesc=CQ($_POST['newsurldesc']);
  $yy=CQ($_POST['yyyy']);
  $mm=CQ($_POST['mm']);
  $dd=CQ($_POST['dd']);

  if ($URL=="http://")
  {
    $URL="";
  } 
  if (strlen($dd)<=1)
  {
    $dd="0".$dd;
  } 
  if (strlen($mm)<=1)
  {
    $mm="0".$mm;
  } 
  $datum=$formatDateTime[$mm."/".$dd."/".$yy][0];

  $sql="INSERT INTO news (newsHeader, newsIngress, newsText, newsDate, newsAuthor, newsRegDate, newsURL, newsURLDesc, newsImageName) VALUES('".$title."', '".$ingress."', '".$text."', '".$datum."', ".$_SESSION['userid'].", getdate(), '".$URL."', '".$URLDesc."', '')";
//response.Write(SQL)
//response.end
  $Conn->execute($sql);

  $sql="SELECT userid FROM users WHERE userid <> ".$_SESSION['userid'];
  $userList=$conn->execute($sql);

  $sql="SELECT max(newsID) AS newsID FROM news";
  $newsID=$conn->execute($sql);

  if ($userList)
  {

    $counter=0;
    $userLists = $userList; foreach( $userLists as $userList)
    {

      $sql="INSERT INTO newsNotify (userid, newsID) VALUES(".$userList['userid'].", ".$newsID['newsid'].")";
      $Conn->execute($sql);
      $counter=$counter+1;
//      $userList->moveNext;
    } 
  } 


//response.Write(request.Form("bild"))
//response.end

  if ($_POST['bild']=="1")
  {

    header("Location: "."News.php?mode=getImageName&newsid=".$newsid['newsid']."&date=".$datum."&Message=Nyhet inf&ouml;rd den ".$datum." och ".$counter." anv&auml;ndare informerade!");
  }
    else
  {

    header("Location: "."main.php?Message=Nyhet inf&ouml;rd den ".$datum." och ".$counter." anv&auml;ndare informerade!");
  } 

  $newsid=null;

  $userList=null;


}
  else
if ($_GET['mode']=="addImage")
{


  if ($_GET['newsid']=="")
  {
    header("Location: "."News.php?message=Ingen aktivitet angedd!");
  } 

  // $imageCom is of type "GflAx.GflAx"
  // $Upload is of type "persits.Upload"
  // $objFSO is of type "Scripting.FileSystemObject"

  $imageCom->EnableLZW=true;



// Set variables for saving
//	upload.SetMaxSize = 1000000, true


  $Upload->save;

  if ($upload->files==null)
  {
    header("Location: "."News.php?message=Nyhet inf&ouml;rd men jag fick inte n&aring;gon bild uppladdad!");
  } 

  $file=$Upload->files;
//if not file is nothing then

  foreach ($upload->files as $file)
  {
    if ($file->ext!=".jpg" && $file->ext!=".gif" && $file->ext!=".png" && $file->ext!=".JPG" && $file->ext!=".GIF" && $file->ext!=".PNG")
    {
      header("Location: "."calendarView.php?yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=Endast bilder av typen, gif, jpg eller png till&aring;tna!");
    } 
//	imagePath = application("newsImagePath") & "\\" & file.filename
//	imageName = file.fileName
    $imagePath=$application['newsimagepath']."\\".$_GET['newsid'].$file->ext;
    $imageName=$_GET['newsid'].$file->ext;

    if (file_exists($imagePath))
    {
      unlink($imagePath);
    } 
    $file->SaveAs$imagePath;

  }


  if ($err)
  {

//an error occured... ie file already exists, invalid extension etc
    if (file_exists($imagePath))
    {
      unlink($imagePath);
    } 
    $strMsg="Uploaderror ".0 /* not sure how to convert err.Number */ .": ". /* don'tknowhowtoconverterr.Description * /;
header( "Location: "."News.php?message=".$message."<br>".$strMsg );
}
else {
	//add description to the database?
	//Conn.execute ("INSERT INTO mydocs (FileName,Description) VALUES ('" & objUpload.Form("thefile").Value & "','" & objUpload.Form("description").Value

	$strMsg = "The file was successfully uploaded.";
}

//response.Write(message & strMsg & "<br>" & imagePath & "<br>" & imageName)
//response.end
//Create thumbnail

$imageCom->loadBitMap$imagePath;
if( $imageCom->Width > $imageCom->Height ) {
	$height = round( $imageCom->Height * 90 / $imageCom->Width, 0 );
	$imageCom->Resize100$height;
}
else {
	$width = round( $imageCom->Width * 110 / $imageCom->Height, 0 );
	$imageCom->Resize$width
}
$imageCom->saveBitmap$DOCUMENT_ROOT."."."\\images\\news\\tn_".$imageName;
print "RESIZAR p&aring;: ".$DOCUMENT_ROOT."."."\\images\\news\\tn_".$imageName;

//Ta bort orginalet?
//if objFSO.FileExists(imagePath) then objFSO.DeleteFile imagePath, True
//set imageCom = nothing

if( $err != 0 ) {
	$message = $message."Det blev fel p&aring; bildhatering: ".

	/* don't know how to convert err.Description */."<br>";
	header( "Location: "."News.php?message=".$strMsg );
}
else {
	$sql = "update news set newsimagename = '".$imagename."' where newsid = ".intval( $_GET['newsid'] );
	$conn->execute( $sql );
	$updater = null;
	$upload = null;
	$imageCom = null;
	$objFSO = null;
	header( "Location: "."main.php?message=Nyhet och bild inf&ouml;rd" );
	exit( );
}
}
elseif( $_GET['mode'] == "updateNews" ) {
	$title = CQ( $_POST['rubrik'] );
	$text = CQ( $_POST['text'] );
	$yy = CQ( $_POST['yyyy'] );
	$mm = CQ( $_POST['mm'] );
	$dd = CQ( $_POST['dd'] );
	$eventid = intval( $_GET['eventid'] );
	$locationid = intval( $_POST['locationid'] );

	//response.Write(request.Form("bild"))
	//response.end

	if( strlen( $dd ) <= 1 ) {
		$dd = "0".$dd;
	}
	if( strlen( $mm ) <= 1 ) {
		$mm = "0".$mm;
	}
	$datum = $formatDateTime[$mm."/".$dd."/".$yy][0];
	$sql = "select eventimage from calendarevents where eventid = ".$eventid;
	$image = $conn->execute( $sql );
	if( $_POST['bild'] == "1" && $image['eventimage'] != "" ) {
		$sql = "update calendarevents set title = '".$title."', [text] = '".$text."', yyyy = '".$yy."', mm = '".$mm."', dd = '".$dd."', locationid = ".$locationid.", fulldate = '".$datum."' where eventid =".$eventid;

		//response.Write("bild finnes och &auml;r intryckt = ingen &aring;tg&auml;rd")
		//response.end
	}
	else {
		$sql = "update calendarevents set title = '".$title."', [text] = '".$text."', yyyy = '".$yy."', mm = '".$mm."', dd = '".$dd."', locationid = ".$locationid.", fulldate = '".$datum."', eventimage = '' where eventid =".$eventid;

		//response.Write("bild &auml;r avkryssa = ta bort och skriv tomt")
		//response.end
		// $objFSO is of type "Scripting.FileSystemObject"

		if( file_exists( $application['calendarimagepath']."\\".$image['eventimage'] ) ) {
			unlink( $application['calendarimagepath']."\\".$image['eventimage'] );
		}
		if( file_exists( $application['calendarimagepath']."\\tn_".$image['eventimage'] ) ) {
			unlink( $application['calendarimagepath']."\\tn_".$image['eventimage'] );
		}
	}
	$Conn->execute( $sql );
	if( $_POST['bild'] == "1" && $image['eventimage'] != "" ) {
		//response.Write("bild finnes och &auml;r intryckt = ingen &aring;tg&auml;rd")
		//response.end

		header( "Location: "."calendarView.php?yy=".$yy."&mm=".$mm."&dd=".$dd."&Message=Aktivitet uppdaterad den ".$yy."-".$mm."-".$dd );
	}
	elseif( $_POST['bild'] == "1" ) {
		//response.Write("bild &auml;r intryckt = ladda upp bild")
		//response.end

		header( "Location: "."calendarView.php?mode=getImageName&eventid=".$_GET['eventid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."&Message=Aktivitet inf&ouml;rd den ".$yy."-".$mm."-".$dd );
	}
	else {
		//response.Write("bild ej intryckt = ingen &aring;tg&auml;rd")
		//response.end

		header( "Location: "."calendarView.php?yy=".$yy."&mm=".$mm."&dd=".$dd."&Message=Aktivitet uppdaterad den ".$yy."-".$mm."-".$dd );
	}
}
elseif( $_GET['mode'] == "delete" ) {
	if( $_SESSION['usertype'] < $application['newsadmin'] ) {
		header( "Location: "."news.php?message=Du har inte r&auml;ttigheter att ta bort nyheter!" );
	}
	if( $_GET['newsid'] == "" ) {
		header( "Location: "."news.php?message=Det finns ingen s&aring;dan nyhet!" );
	}
	$sql = "delete from news where newsid = ".intval( $_GET['newsid'] );
	$conn->execute( $sql );
	header( "Location: "."news.php?message=Nyheten borttagen!" );
}
elseif( $_GET['mode'] == "newsCount" ) {
	if( $_SESSION['usertype'] < $application['newsadmin'] ) {
		header( "Location: "."news.php?message=Du har inte r&auml;ttigheter att &auml;ndra nyhetsantal!" );
	}
	if( $_GET['newsitems'] == "" ) {
		header( "Location: "."news.php?message=Det finns inget v&auml;rde - niga nyheter = 0!" );
	}
	$application->Lock;
	$application['systemnewsitems'] = intval( $_GET['newsitems'] );
	$application->UnLock;
	$sql = "update system set systemnewsitems = ".intval( $_GET['newsitems'] );
	$conn->execute( $sql );
	header( "Location: "."main.php?message=Antalet nyheter nu &auml;ndrat!" );
}
else {
	header( "Location: "."main.php" );
}
?>

