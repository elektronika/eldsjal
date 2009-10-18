<?php 
$noredirect = 1;
require( 'header.php' ); ?>
<div id="content-wrap">
	<div id="content" class="container_16">
<div class="column column-left grid_3 prefix_1">
<?php require_once( 'toolbox.applet.php' );
require_once( 'userHistory.applet.php' );
require_once( 'diarys.applet.php' );?>			
	</div>
	<div class="column column-middle grid_8">
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
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
if (document.register.username.value.length<2){
alert("Ditt användarnamn måste innehålla fler än 2 tecken.\n\nPröva igen!");
document.register.username.focus();
return;
}
if (document.register.password.value.length<3){
alert("Ditt lösenord måste innehålla fler än 3 tecken.\n\nPröva igen!");
document.register.password.focus();
return;
}
if (document.register.first_name.value.length<2){
alert("Du måste ange ditt förnamn.\n\nPröva igen!");
document.register.first_name.focus();
return;
}
if (document.register.last_name.value.length<2){
alert("Du måste ange ditt efternamn.\n\nPröva igen!");
document.register.last_name.focus();
return;
}
if (document.register.city.value == '0'){
alert("Ange ett län.\n\nPröva igen!");
document.register.city.focus();
return;
}
if (document.register.cityname.value.length<2){
alert("Du måste ange stadsnamn.\n\nPröva igen!");
document.register.cityname.focus();
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
document.register.icq.value = "";

}
return;
}
				
-->
</SCRIPT>
		<div class="regWindow1">     
		       <table width="100%" cellpadding="0" cellspacing="0" id="Table2">
		       <tr>
		       <td>
		       <div class="newsText">
<?php
// Check validity of users request, if invalid send user to requested users homepage
// Replaced with a function that always displays and updates the logged in users, no matter whos presentation the users try to change
//if Cint(request.QueryString("userid")) <> session("userid) then response.redirect("userPresentation.php?userid=" & request.queryString("userid") & "&message=Du har försökt ändra en presentation du inte är ägare till, lägg av med sånt!")

if( $_SESSION['userid'] == 0 || $_SESSION['userid'] == "" ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid']."&message=Du har försökt ändra en presentation fast du inte är inloggad, prova att logga in först!" );
}
print isset( $_GET['message'] ) ? htmlentities(urldecode($_GET['message'])) : '';
if( $_GET['mode'] == "updateEditAccount" ) {
	
	$username = trim(cq( strtolower( $_POST['username'] ) ));
	
	$sql = "select * from lockedusernames where username = '".$username."'";
	$nameIsLocked = $conn->execute($sql);
	if( $nameIsLocked ) {
		$error = "Detta användarnamn är ej registrerbart!";
	}

	$sql = "select * from users where username = '".$username."' and username != '".$_SESSION['username']."'";
	$nameIsTaken = $conn->execute($sql);
	if( $nameIsTaken ) {
		$error = "Detta användarnamn är redan upptaget!";
	}

	if( isset($error) && !empty($error) ) {
		header( "Location: "."userEdit.php?mode=editAccount&message=".urlencode($error) );
		exit();
	}

	$sql = "select * from users where userid = ".$_SESSION['userid']." and first_name='".cq( $_POST['first_name'] )."' and last_name = '".cq( $_POST['last_name'] )."'and email = '".cq( $_POST['email'] )."'and username = '".$username."'";
	$history_name = $conn->execute( $sql );
	if( $history_name ) {
		$sql = "insert into historyname (user_id, fornamn, efternamn, smeknamn, email) select userid, first_name, last_name, username, email from users where userid = ".$_SESSION['userid'];
		$conn->execute( $sql );
	}

	$sql = "select * from address where userid = ".$_SESSION['userid']." and co = '".cq( $_POST['co'] )."' and gatuadress1 = '".cq( $_POST['gatuadress1'] )."' and gatuadress2 = '".cq( $_POST['gatuadress2'] )."' and postnummer = '".cq( $_POST['postnummer'] )."' and stad = '".cq( $_POST['stad'] )."' and land = '".cq( $_POST['land'] )."'";
	$addresshistory = $conn->execute( $sql );
	if( $addresshistory ) {
		$sql = "insert into address (userid, co, gatuadress1, gatuadress2, postnummer, stad, land) values ('".$_SESSION['userid']."','".cq( $_POST['co'] )."','".cq( $_POST['gatuadress1'] )."','".cq( $_POST['gatuadress2'] )."','".cq( $_POST['postnummer'] )."','".cq( $_POST['stad'] )."','".cq( $_POST['land'] )."')";
		$conn->execute( $sql );
	}
	$sleeper = 0;
	if( $_POST['sleeper'] != 0 ) {
		$sleeper = $_POST['sleeper'];
	}

	// update account info

	$sql = "update users set username = '".$username."', password = '".cq( $_POST['password'] )."', first_name = '".cq( $_POST['first_name'] )."', last_name = '".cq( $_POST['last_name'] )."', email = '".cq( $_POST['email'] )."', msn = '".cq( $_POST['msn'] )."', icq = '".cq( $_POST['icq'] )."', yahoo = '".cq( $_POST['yahoo'] )."', gender = ".cq( $_POST['gender'] ).", city = ".cq( $_POST['city'] ).", webpage = '".cq( $_POST['webpage'] )."', inhabitance = '".cq( $_POST['cityname'] )."', private = ".cq( $_POST['private'] ).", sleeper = ".$sleeper." where userid = ".$_SESSION['userid'];
	$db = $conn->execute( $sql );
	$_SESSION['username'] = $username;
	setcookie( "eldsjalUsername", $_SESSION['username'], 0, "", "", 0 );
	$sql = "delete from pendingdelete where userid = ".$_SESSION['userid'];
	$conn->execute( $sql );
	header( "Location: userPresentation.php?userid=".$_SESSION['userid']."&message=Användaruppgifter sparade!" );
}
elseif( $_GET['mode'] == "updatePresentation" ) {
	$formatTexten = cq( $_POST['presentation'] );
	$sql = "update users set presentation = '".$formatTexten."', redirect = '' where userid = ".$_SESSION['userid'];
	$result = $conn->execute( $sql );
	$sql = "delete from pendingdelete where userid = ".$_SESSION['userid'];
	$conn->execute( $sql );
	header( "Location: "."userPresentation.php?userid=".$_SESSION['userid']."&message=Presentation sparad!" );
}
elseif( $_GET['mode'] == "updateArtList" ) {
	$iCount = $_POST['txtcount'];
	$sql = "delete from userartlist where userid =".$_SESSION['userid'];
	$results = $conn->execute( $sql );
	foreach ($_POST['art'] as $artId => $something) {
			$sql = " insert into userartlist (userid, artid) values (".$_SESSION['userid'].", ".$artId.")";
			$results = $conn->execute( $sql );
	}
	$sql = "delete from pendingdelete where userid = ".$_SESSION['userid'];
	$conn->execute( $sql );
	// print_r($_POST);
	// exit();
	header( "Location: "."userPresentation.php?userid=".$_SESSION['userid']."&message=Sysslar med-lista sparad!" );
}
elseif( $_GET['mode'] == "updateImage" ) {
	$strUploadPath = $application['userimagepath'];
	
	if( move_uploaded_file( $_FILES['file1']['tmp_name'], $strUploadPath.'/'.$_FILES['file1']['name'] ) ) {
		$file = $_FILES['file1'];
		$file['path'] = $strUploadPath.'/'.$file['name'];
		$file['extension'] = end( explode( '.', $file['name'] ) );
	} else {
		header( "Location: "."userEdit.php?mode=image&userid=".$_SESSION['userid']."&message=Ingen bild laddades upp, försök gärna igen!" );
		exit();
	}
	// print_r($file);
	// 	exit();
	$imageTransform = new ImageTransform();
	$imageTransform->sourceFile = $file['path'];
	$imageTransform->targetFile = '../uploads/userImages/'.$_SESSION['userid'].'.jpg';
	$imageTransform->resizeToWidth = 100;

	if(!$imageTransform->resize()) {
		print_r($imageTransform->error);
	} else {
		// print 'stor version skapad';
	}
	
	$imageTransform->targetFile = '../uploads/userImages/tn_'.$_SESSION['userid'].'.jpg';
	$imageTransform->resizeToHeight = 89;

	if(!$imageTransform->resize()) {
		print_r($imageTransform->error);
	} else {
		// print 'liten version skapad';
	}
	
	/*
	foreach( $upload->files as $file ) {
		$imagePath = $application['userimagepath']."\\".$file->filename;
	}
	if( 0

	/* not sure how to convert err.number  == 8 ) {
		header( "Location: "."userEdit.php?mode=image&userid=".$_SESSION['userid']."&message=Your image-file is too large" );
	}
	elseif( $err ) {
		//an error occured... ie file already exists, invalid extension etc

		$strMsg = "Uploaderror ";

		//.0 /* not sure how to convert err.Number  .": ". /* don't know how to convert err.Description  ;

		header( "Location: "."userEdit.php?mode=image&userid=".$_SESSION['userid']."&message=".$strMsg.$message );

		//objFSO.DeleteFile imagePath, True
	}
	else {
		//add description to the database?
		//cConn.execute ("INSERT INTO mydocs (FileName,Description) VALUES ('" & objUpload.Form("thefile").Value & "','" & objUpload.Form("description").Value

		$strMsg = "The file was successfully uploaded.";
	}
	*/
	/*
	$imageCom->loadBitmap( $imagePath );
	$imageName = $_SESSION['userid'];
	$imageCom->SaveFormat = 1;
	$imageCom->saveBitmap( $DOCUMENT_ROOT."."."\\images\\userImages\\".$imagename.".jpg" );

	//jpeg.width = 100
	//jpeg.height = 80

	$imageCom->loadBitmap( $imagePath );
	if( $imageCom->Width > $imageCom->Height ) {
		$height = round( $imageCom->Height * 100 / $imageCom->Width, 0 );
		$imageCom->Resize( 100, $height );
	}
	else {
		$Height = 89;
		$width = round( $imageCom->Width * 89 / $imageCom->Height, 0 );
		$imageCom->Resize( $width );
	}
	$imageName = $_SESSION['userid'];
	$imageCom->SaveFormat = 1;
	$imageCom->saveBitmap( $DOCUMENT_ROOT."."."\\images\\userImages\\tn_".$imageName.".jpg" );
	if( file_exists( $imagePath ) ) {
		unlink( $imagePath );
	}

	//if imageCom <> nothing then set imageCom = nothing

	if( $err != 0 ) {
		$message = $message."Error in imageprocessing: ";

		//. /* don't know how to convert err.Description  ."<br/>";

		header( "Location: "."userEdit.php?mode=image&userid=".$_SESSION['userid']."&message=".$message );
	}
	*/
	$sql = "update users set hasimage = 1, redirect = '' where userid = ".$_SESSION['userid'];
	$updated = $conn->execute( $sql );
	$sql = "delete from pendingdelete where userid = ".$_SESSION['userid'];
	$conn->execute( $sql );
	header( "Location: "."userPresentation.php?userid=".$_SESSION['userid'] );
}
elseif( $_GET['mode'] == "editAccount" ) {
	$sql = "select * from users where userid = ".$_SESSION['userid'];
	$info = $conn->execute( $sql );
	if( $conn->type == 'mssql' )
		$sql = "select top 1 * from address where userid = ".$_SESSION['userid']." order by id desc";
	else
		$sql = "select * from address where userid = ".$_SESSION['userid']." order by id desc limit 1";
	$address = $conn->execute( $sql );

	//L&aring;t ligga under testperioden, n&auml;r nya f&ouml;rstasidan &auml;r uppe kan denna tas bort!

	if( $address ) {
		$sql = "select * from address where id = 6";
		$address = $conn->execute( $sql );
	}
	?>
			
				<form action="userEdit.php?mode=updateEditAccount" method="post" name="register" id="register" onSubmit="return validateLogin();">
				<center>
				<TABLE CELLPADDING="2" CELLSPACING="5" border="0" width="100%" id="Table1">
				<TR>
				<TD>
				<div class="boxtext2">
				F&ouml;rnamn<br/>
				<input class="inputBorder" type="text" name="first_name" id="first_name" value="<?php   echo $info['first_name'];?>"/><br/>
				Efternamn<br/>
				<input class="inputBorder" type="text" name="last_name" id="last_name" value="<?php   echo $info['last_name'];?>"/><br/>

				Kille <input class="inplutt" type="radio" <?php   if( $info['gender'] == false ) {
		print "checked";
	}?> value="0" id="boy" NAME="gender">
				Tjej <input class="inplutt" type="radio" <?php   if( $info['gender'] == true ) {
		print "checked";
	}?> value="1" id="girl" NAME="gender"><br/>
				<br/>
				Adress:<P>
				C/O<br/>
				<input class="inputBorder" type="text" name="co" id="co" value="<?php   echo $address['co'];?>"/><br/>
				Gatuadress 1<br/>
				<input class="inputBorder" type="text" name="gatuadress1" id="Gatuadress1" value="<?php   echo $address['gatuadress1'];?>"/><br/>
				Gatuadress 2<br/>
				<input class="inputBorder" type="text" name="gatuadress2" id="Gatuadress2" value="<?php   echo $address['gatuadress2'];?>"/><br/>
				Postnummer<br/>
				<input class="inputBorder" type="text" name="postnummer" id="postnummer" maxlength="10" value="<?php   echo $address['postnummer'];?>"/><br/>
				Postadress<br/>
				<input class="inputBorder" type="text" name="stad" id="stad" value="<?php   echo $address['stad'];?>"/><br/>
				Land<br/>
				<input class="inputBorder" type="text" name="land" id="land" value="<?php   echo $address['land'];?>"/><br/><br/>
				</div>
				</TD>
				<TD>
				<div class="boxtext2">
				D&ouml;lj privat info f&ouml;r ickemedlemmar?<br/>
				Ja <input class="inplutt" type="radio" <?php   if( $info['private'] == 1 ) {
		print "checked";
	}?> value="1" id="radio" NAME="private">
				Nej <input class="inplutt" type="radio" <?php   if( $info['private'] == 0 ) {
		print "checked";
	}?> value="0" id="radio" NAME="private"><br/><br/>

				Anv&auml;ndarnamn<br/>
				<input class="inputBorder" type="text" id="username" NAME="username" maxlength="12" value="<?php   echo $info['username'];?>"/><br/>
				L&ouml;senord<br/>
				<input class="inputBorder" type="password" id="password" NAME="password" maxlength="12" value="<?php   echo $info['password'];?>"/><br/>
				e-mail<br/>
				<input class="inputBorder" type="text" id="email" NAME="email" value="<?php   echo $info['email'];?>"/><br/>
				hemsida<br/>
				<input class="inputBorder" type="text" id="webpage" NAME="webpage" value="<?php   echo $info['webpage'];?>"/><br/>
				ICQ<br/>
				<input class="inputBorder" type="text" id="icq" NAME="icq" value="<?php   echo $info['icq'];?>" onChange="isNumeric(document.register.icq.value,'ICQ Nummer är enbart siffror, du angav även bokstäver nu, då blir det knas!\nGÖR OM!');"/><br/>
				MSN<br/>
				<input class="inputBorder" type="text" id="msn" NAME="msn" value="<?php   echo $info['msn'];?>"/><br/>
				Telefon<br/>
				<input class="inputBorder" type="text" id="yahoo" NAME="yahoo" value="<?php   echo $info['yahoo'];?>"/>
				<br/><br/>
				Ort/Stadsdel<br/>

				<select name="city" class=selectBox class="text" style="width: 178; height: 23" id="Select4">
					<option selected value="261">-- välj län --</option>
<?php 
$sql = "select * from locations order by sortorder asc, locationname";
	$dbLocations = $conn->execute( $sql );
	$dbLocationss = $dbLocations;
	foreach( $dbLocationss as $dbLocations ) {
		print "<option value=".$dbLocations['locationid'];
		if( intval( $info['city'] ) == intval( $dbLocations['locationid'] ) ) {
			print " selected ";
		}
		print ">".$dbLocations['locationname']."</option>";

		//    $dbLocations->moveNext;
	}
	?>
					</select><br/>
				<input type="text" class="inputBorder" name="cityname" value="<?php   echo $info['inhabitance'];?>"/>
				<br/><br/>
				Semester <input class="inplutt" type="checkbox" <?php   if( $info['sleeper'] == true ) {
		print "checked";
	}?> value=1 id="checkbox" <?php   if( $info['sleeper'] == true ) {
		print "checked";
	}?>1 NAME="sleeper"><br/>

				<br/><br/><br/><br/>
				<img src="images/1x1.gif" width="45" height="1"> <a href="javascript:ValidateAccount();">
					<br/><br/><img src="images/register.gif" border="0"></a> 
				</div>

			</TD>
		</TR>
	</TABLE>
				
				</center>
				</form>
<?php
}
elseif( $_GET['mode'] == "presentation" ) {
	$sql = "select presentation from users where userid =".$_SESSION['userid'];
	$info = $conn->execute( $sql );
	?>
			
			<form action="userEdit.php?mode=updatePresentation" method="post" name="artList" id="Form1">
			<div>
			
			<div class="plainText">	
			Skriv en presentationstext, t.ex om vad du sysslar med och vem du &auml;r som person!</div>
<?php 
$formatTexten = "";
	$formatTexten = RQ( $info['presentation'] );
	$formatTexten = str_replace( "<br/>", "\r\n", $formatTexten );
	?>
			<textarea class="inputBorder" name="presentation" cols="80" rows="30" wrap><?php   echo $formatTexten;?></textarea><br/>
			<input class="inputBorder" type = "hidden" name ="txtCount" value="<?php   echo $iCount;?>" id="Hidden1"/>
			Vidare
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
<?php
}
elseif( $_GET['mode'] == "artList" ) {
	?>
			
			<form action="userEdit.php?mode=updateArtList" method="post" name="artList" id="artList">
			<div>
		
			<div class="plainText">
			Med handen p&aring; hj&auml;rtat: vilka aktiviteter &auml;gnar du dig regelbundet &aring;t?</div>
			<br/>
			<table border="0" class="activityList">
			<tr>
<?php 
$sql = "select * from artlist where imageonly = 0 order by artname";
	$artList = $conn->execute( $sql );
	$sql = "select * from userartlist where userid = ".$_SESSION['userid'];
	$userArtLists = $conn->execute( $sql );
	$styleCount = 0;
	$iCount = 0;
	$artLists = $artList;
	foreach( $artLists as $artList ) {
		print "<td><input class=checkboxar type=checkbox ID=art".$iCount." NAME=art[".$artList['artid']."] value=".$artList['artid'];
		// $userArtLists = $userArtList;
		foreach( $userArtLists as $userArtList ) {
			if( intval( $userArtList['artid'] ) == intval( $artList['artid'] ) ) {
				print " checked ";
			}
		}
		// $userArtList = $conn->execute( $sql );
		print "><a class=a2 href=javascript:openInfo('shortInfo.php?mode=".$artList['artid']."') >".$artList['artname']."</a></td>";
		$iCount = $iCount + 1;
		$styleCount = $styleCount + 1;
		if( $styleCount == 3 ) {
			print "</tr><tr>";
			$styleCount = 0;
		}

		//    $artList->movenext;
	}
	?>
			</tr>
			<tr>
			<td colspan="3">
			<input type = "hidden" name ="txtCount" value="<?php   echo $iCount;?>" id="Hidden1"/>
			Spara 
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			</td>
			</tr>
			</table>			
<?php
}
elseif( $_GET['mode'] == "image" ) {
	?>
			<form action="userEdit.php?mode=updateImage" method="post" name="register3" id="Form2" ENCTYPE="multipart/form-data">
		
			<div class="boxText">
			<center><b>Ladda upp en ny bild p&aring; dig sj&auml;lv</b></center><br/><br/>
			Filen m&aring;ste heta .jpg, .gif, .bmp eller .png i efternamn!
			<br/><br/>
			
			<input class="inputBorder" type="file" name="file1" size="40" id="file1"/>
			<br/>
			<img src="images\1x1.gif" width="210" height="1"> Klar!
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			<br/><br/>
			<a href="userEdit.php" class=a2>Hoppa &ouml;ver!</a>
			</form>
			</div>			
<?php
}
else {
	header( "Location: "."userPresentation.php?userid=".$_SESSION['userid'] );
}
?>
				 
				 </TD>
				 </TR>
		         </TABLE>
				</div>
				</div>
				<div class="column column-right grid_3">
<?php if( intval( $_SESSION['userid'] ) != "" || $_SESSION['userid'] != 0 ) { ?>
		<div class="box">
		<h3 class="boxHeader">&Auml;ndra mina uppgifter</h3>
		<div class="boxContents">	
		
		<a class="a2" href="userEdit.php?mode=editAccount&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Personuppgifter</a><br/>
		<a class="a2" href="userEdit.php?mode=presentation&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Presentation</a><br/>
		<a class="a2" href="userEdit.php?mode=artList&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Sysslar med</a><br/>
		<a class="a2" href="userEdit.php?mode=image&userid=<?php   echo $_SESSION['userid'];?>"><img src="images/icons/ruta.gif" border="0"> Bild</a><br/><br/>
</div></div>

<?php } ?>
<div class="box">
<h3 class="boxHeader">Information</h3>
<div class="boxContents">
		Att fylla i korrekta uppgifter &auml;r A och O p&aring; eldsj&auml;l. Vi som &auml;r medlemmar har stort f&ouml;rtroende f&ouml;r varandra och relationen oss emellan bygger p&aring; &ouml;ppenhet, d&auml;rf&ouml;r h&aring;ller det inte att ange falska eller ofullst&auml;ndiga uppgifter, det tj&auml;nar bara till att du som medlem kommer att k&auml;nna dig utest&auml;ngd!<br/><br/>
		Som p&aring; alla communitys &auml;r det inte s&aring; viktigt exakt vad man s&auml;ger i presentationen, men att det finns en presentation och en bild, utan det finns inget ansikte, se ocks&aring; till att tr&auml;ffa oss andra i verkligheten s&aring; fort som du bara kan!
	</div></div>
<?php require_once( 'calendar.php' );
require_once( 'image.applet.php' );?>
			
</div>
</div>
</div>
<?php require_once( 'footer.php' );?>
