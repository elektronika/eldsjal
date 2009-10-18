<?php
session_start( );




$dont_display_header = TRUE;

require_once( 'header.php' );
if( $_SESSION['usertype'] == "" || $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	header( "Location: "."calendarview.php?message=Du &auml;r inte inloggad eller saknar r&auml;ttigheter" );
}
if( $_GET['mode'] == "delete" ) {
	$sql = "select userid,eventimage, title from calendarevents where eventid = ".intval( $_GET['eventid'] );
	$owner = $conn->execute( $sql );
	if( $owner ) {
		header( "Location: "."calendarview.php?message=Ingen aktivitet registrerad f&ouml;r det id du vill ta bort!" );
	}
	if( $_SESSION['usertype'] < 4 ) {
		header( "Location: "."calendarview.php?message=Du har inte r&auml;ttigheter nog att ta bort angiven aktivitet!" );
	}
	$sql = "delete from calendarevents where eventid = ".intval( $_GET['eventid'] );
	$conn->execute( $sql );
	$sql = "delete from calendarnotify where eventid = ".intval( $_GET['eventid'] );
	$conn->execute( $sql );
	$sql = "delete from joinactivity where eventid = ".intval( $_GET['eventid'] );
	$conn->execute( $sql );
	$sql = "delete from privateevent where eventid = ".intval( $_GET['eventid'] );
	$conn->execute( $sql );

	// $objFSO is of type "Scripting.FileSystemObject"

	if( file_exists( $application['calendarimagepath']."\\".$owner['eventimage'] ) ) {
		unlink( $application['calendarimagepath']."\\".$owner['eventimage'] );
	}
	if( file_exists( $application['calendarimagepath']."\\tn_".$owner['eventimage'] ) ) {
		unlink( $application['calendarimagepath']."\\tn_".$owner['eventimage'] );
	}

	//response.Write(application("calendarImagePath") & "\\" & owner("eventImage"))
	//response.end

	if( $_GET['page'] != "" ) {
		header( "Location: "."calendarview.php?mode=".$_GET['page']."&yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=Aktivitet \" ".$owner['title']."\" borttagen!" );
	}
	else {
		header( "Location: "."calendarview.php?yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=Aktivitet \" ".$owner['title']."\" borttagen!" );
	}
	$owner = null;
}
elseif( $_GET['mode'] == "participate" ) {
	if( $_GET['eventid'] == "" || $_GET['userid'] == "" || $_SESSION['userid'] == "" ) {
		header( "Location: "."calenderView.php?message=Ej inloggad eller ingen aktivitet angedd!" );
	}
	$sql = "select private, userid from calendarevents where eventid = ".intval( $_GET['eventid'] );
	$check = $conn->execute( $sql );
	if( $check ) {
		if( $check['private'] == true && $check['userid'] != $_SESSION['userid'] ) {
			$sql = "select id from friends where (user_id = ".$_SESSION['userid']." and friend_id = ".$check['userid'].") or (friend_id = ".$_SESSION['userid']." and user_id = ".$check['userid'].")";
			$friends = $conn->execute( $sql );
			if( $friends ) {
				header( "Location: "."calendarview.php?eventID=".$_GET['eventid']."&message=Du är inte bjuden till den aktiviteten!" );
			}
			$friends = null;
		}
	}
	else {
		header( "Location: "."calendarview.php?eventID=".$_GET['eventid']."&message=Den aktiviteten finns inte!" );
	}
	if( $_GET['new'] == "y" ) {
		$sql = "insert into joinactivity (eventid, userid) values (".intval( $_GET['eventid'] ).", ".$_SESSION['userid'].")";
	}
	else {
		$sql = "delete from joinactivity where eventid = ".intval( $_GET['eventid'] )." and userid = ".$_SESSION['userid'];
	}
	$db = $conn->execute( $sql );
	$db = null;
	$check = null;
	if( $_GET['new'] == "y" ) {
		header( "Location: "."calendarview.php?message=Du har nu anmält deltagande, Smutt alltså!&yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd'] );
	}
	else {
		header( "Location: "."calendarview.php?message=Du är nu inte anmäld längre, tråkigt =(&yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd'] );
	}
}
elseif( $_GET['mode'] == "addImage" ) {
	if( $_GET['eventid'] == "" ) {
		header( "Location: "."calendarview.php?yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=Ingen aktivitet angedd!" );
	}

	// $imageCom is of type "GflAx.GflAx"
	//Set objUpload = Server.CreateObject("ASPUploadComponent.cUpload")
	// $Upload is of type "persits.Upload.1"
	// $objFSO is of type "Scripting.FileSystemObject"

	$imageCom->EnableLZW = true;

	// Set variables for saving
	//	upload.SetMaxSize = 1000000, true

	$imageName = "";
	$Upload->save;
	$file = $Upload->files;
	if( !$file == null ) {
		if( $file->ext != ".jpg" && $file->ext != ".gif" && $file->ext != ".png" && $file->ext != ".JPG" && $file->ext != ".GIF" && $file->ext != ".PNG" ) {
			header( "Location: "."calendarview.php?yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=Endast bilder av typen, gif, jpg eller png tillåtna!" );
		}
		$imagePath = $application['calendarimagepath']."\\".$_GET['eventid'].$file->ext;

		//imageName = CQ(objUpload.form("file1").value)

		$imageName = $_GET['eventid'].$file->ext;
		if( file_exists( $imagePath ) ) {
			unlink( $imagePath );
		}
		$file->SaveAs( $imagePath );
		if( $err ) {
			//an error occured... ie file already exists, invalid extension etc

			if( file_exists( $imagePath ) ) {
				unlink( $imagePath );
			}
			$strMsg = "Uploaderror ";

			//.0 /* not sure how to convert err.Number */ .": ". /* don't know how to convert err.Description */ ;

			header( "Location: "."calendarview.php?yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=".$message."<br/>".$strMsg );
		}
		else {
			//add description to the database?
			//Conn.execute ("INSERT INTO mydocs (FileName,Description) VALUES ('" & objUpload.Form("thefile").Value & "','" & objUpload.Form("description").Value

			$strMsg = "The file was successfully uploaded.";
		}

		//response.Write(message & strMsg & "<br/>" & imagePath & "<br/>" & imageName)
		//response.end
		//Create thumbnail

		$imageCom->loadBitMap( $imagePath );
		if( $imageCom->Width > $imageCom->Height ) {
			$height = round( $imageCom->Height * 100 / $imageCom->Width, 0 );
			$imageCom->Resize( 100, $height );
		}
		else {
			$width = round( $imageCom->Width * 89 / $imageCom->Height, 0 );
			$imageCom->Resize( $width );
		}
		$imageCom->saveBitmap( $DOCUMENT_ROOT."."."\\images\\calendar\\tn_".$imageName );

		//Ta bort orginalet?
		//if objFSO.FileExists(imagePath) then objFSO.DeleteFile imagePath, True
		//set imageCom = nothing
	}
	else {
		$err = "Ingen fil";
	}
	if( $err != 0 ) {
		$message = $message."Det blev fel på bildhanteringen. ";

		//. /* don't know how to convert err.Description */ ."<br/>";

		header( "Location: "."calendarview.php?yy=".$_GET['yy']."&mm=".$_GET['mm']."&dd=".$_GET['dd']."&message=".$message."<br/>".$strMsg );
	}
	else {
		$sql = "update calendarevents set eventimage = '".$imagename."' where eventid = ".intval( $_GET['eventid'] );
		$updater = $conn->execute( $sql );
		$updater = null;
		$upload = null;
		$imageCom = null;
		$objFSO = null;
		header( "Location: "."calendarview.php?eventID=".$_GET['eventid'] );
	}
}
elseif( $_GET['mode'] == "addEvent" ) {
	$title = CQ( $_POST['rubrik'] );
	$text = CQ( $_POST['text'] );
	$location = intval( $_POST['locationid'] );
	$yy = CQ( $_POST['yyyy'] );
	$mm = CQ( $_POST['mm'] );
	$dd = CQ( $_POST['dd'] );

	$datum = mktime(0,0,0, $mm, $dd, $yy);

	if( $datum < time() ) {
		header( "Location: "."calendarview.php?mode=addEvent&yy=".$yy."&mm=".$mm."&dd=".$dd."&title=".$title."&describe=".$text."&message=Du kan inte registrera aktivitet p&aring; ett passerat datum!" );
	}
	
	$privates = ($_POST['private'] == 1 ? 1 : 0);
		
	$sql = "insert into calendarevents(title, text, yyyy, mm, dd, userid, regdate, locationid, fulldate, private) values ('".$title."', '".$text."',".$yy.", ".$mm.", ".$dd.", ".$_SESSION['userid'].", getdate(), ".$location.", FROM_UNIXTIME(".$datum."), ".$privates.")";
	
	$conn->execute( $sql );

	$sql = "select max(eventid) as eventid from calendarevents";
	$eventid = $conn->execute( $sql );
	if( $_POST['private'] == 1 ) {
		//informera endast de i vännerlista

		$sql = "select user_id from friends where friend_id = ".$_SESSION['userid'];
		$userlist = $conn->execute( $sql );
		if( $userList ) {
			$userLists = $userList;
			foreach( $userLists as $userList ) {
				$sql = "insert into calendarnotify (userid, eventid, notified) values (".$userlist['user_id'].", ".intval( $eventid['eventid'] ).", 0)";
				$notified = $conn->execute( $sql );
			}
		}
		$sql = "select friend_id from friends where user_id = ".$_SESSION['userid'];
		$userList = $conn->execute( $sql );
		if( $userList ) {
			$userLists = $userList;
			foreach( $userLists as $userList ) {
				$sql = "insert into calendarnotify (userid, eventid, notified) values (".$userlist['friend_id'].", ".intval( $eventid['eventid'] ).", 0)";
				$notified = $conn->execute( $sql );
			}
		}
	}
	elseif( $_POST['informAll'] == 1 ) {
		//	response.Write("kommer att informera alla för att värdet är: " & request.Form("informAll"))

		$sql = "select userid from users where userid <> ".$_SESSION['userid'];
		$userList = $conn->execute( $sql );
		if( $userList ) {
			$userLists = $userList;
			foreach( $userLists as $userList ) {
				$sql = "insert into calendarnotify (userid, eventid, notified) values (".$userlist['userid'].", ".$eventid['eventid'].", 0)";
				$notified = $conn->execute( $sql );
			}
		}
	}
	else {
		//response.Write("kommer att informera din region för att värdet är: " & request.Form("informAll"))

		$sql = "select userid from users where city = ".$location." and userid <> ".$_SESSION['userid'];
		$userList = $conn->execute( $sql );
		if( $userList ) {
			$userLists = $userList;
			foreach( $userLists as $userList ) {
				$sql = "insert into calendarnotify (userid, eventid, notified) values (".$userlist['userid'].", ".$eventid['eventid'].", 0)";
				$notified = $conn->execute( $sql );
			}
		}
	}

	$sql = "insert into joinactivity (eventid, userid) values (".$eventid['eventid'].", ".$_SESSION['userid'].")";
	$notified = $conn->execute( $sql );
	$notified = null;
	$userList = null;
	if( $_POST['bild'] == "1" ) {
		header( "Location: "."calendarview.php?mode=getImageName&eventid=".$eventid['eventid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."&Message=Aktivitet införd den ".$yy."-".$mm."-".$dd.". Informerade ".$i." medlemmar!" );
	}
	else {
		header( "Location: "."calendarview.php?yy=".$yy."&mm=".$mm."&dd=".$dd."&message=Aktivitet införd den ".$yy."-".$mm."-".$dd.". Informerade ".$i." medlemmar!" );
	}
	$eventid = null;
}
elseif( $_GET['mode'] == "updateEvent" ) {
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
	$conn->execute( $sql );

	//	SQL = "SELECT userid FROM users where city = " & locationid
	//	SET userList = conn.execute(SQL)
	//	if not userList.eof then
	//		while not userList.eof
	//			SQL = "DELETE FROM calendarNotify WHERE eventid = " & eventid
	//			 SET notified = conn.execute(SQL)
	//			SQL = "INSERT INTO calendarNotify (userid, eventid, notified) VALUES (" & userList("userid") & ", " & eventid & ", 0)"
	//			SET notified = conn.execute(SQL)
	////			userList.moveNext
	//	wend
	//	end if
	//	SQL = "DELETE FROM calendarNotify WHERE eventid = " & Cint(request.QueryString("eventid")) & " AND userid = " & session("userid")
	//		SET rsConn = conn.execute(SQL)

	if( $_POST['bild'] == "1" && $image['eventimage'] != "" ) {
		//response.Write("bild finnes och &auml;r intryckt = ingen &aring;tg&auml;rd")
		//response.end

		header( "Location: "."calendarview.php?yy=".$yy."&mm=".$mm."&dd=".$dd."&Message=Aktivitet uppdaterad den ".$yy."-".$mm."-".$dd );
	}
	elseif( $_POST['bild'] == "1" ) {
		//response.Write("bild &auml;r intryckt = ladda upp bild")
		//response.end

		header( "Location: "."calendarview.php?mode=getImageName&eventid=".$_GET['eventid']."&yy=".$yy."&mm=".$mm."&dd=".$dd."&Message=Aktivitet inf&ouml;rd den ".$yy."-".$mm."-".$dd );
	}
	else {
		//response.Write("bild ej intryckt = ingen &aring;tg&auml;rd")
		//response.end

		header( "Location: "."calendarview.php?yy=".$yy."&mm=".$mm."&dd=".$dd."&Message=Aktivitet uppdaterad den ".$yy."-".$mm."-".$dd );
	}
}
else {
	header( "Location: "."calendarview.php" );
}
?>

