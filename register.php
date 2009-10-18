<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "username_session" );
session_register( "usertype_session" );
session_register( "userid_session" );
?>
<?php ob_start( );

// $dont_display_header = TRUE;
// require 'topInclude.php';
//response.Expires = 10

$noredirect = 1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
		<link rel=stylesheet href="style.css" TYPE="text/css">
		<meta name="GENERATOR" content="Microsoft Visual Studio.NET 7.0">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
	
	<script language="javascript">
	function openInfo(url)
	{
	window.open(url, 'artInfo', 'fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=auto,resizable=yes,directories=no,location=no,left=80,top=30,width=300,height=400');
	}
	</script>


	</head>
	<br>
	<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" <?php if( isset( $_GET['mode'] ) ) {
	print "onLoad=\"document.register.username.focus();window.alert('P.g.a. folk blivit medlemmar utan att f&ouml;rst&aring; att det inneb&auml;r ett engagemang\\nhar medlemsregistreringen blivit en medlemsans&ouml;kan.\\nAlla uppgifter skall fyllas i med korrekt information,\\n och en bra presentationstext &auml;r krav f&ouml;r att bli medlem p&aring; Eldsj&auml;l!\\n\\nOm du inte kan uppfylla detta ber vi dig avst&aring; fr&aring;n medlemsskap,\\nhar du s&auml;rskild anledning ta g&auml;rna kontakt med oss p&aring; Eldsj&auml;l genom att trycka p&aring; kontakt ovan!\\nVarje konto godk&auml;nns av en medlem p&aring; Eldsj&auml;l.\\nUnder sommaren kr&auml;vs att du bes&ouml;kt en av v&aring;ra tr&auml;ffar eller tr&auml;ffat n&aring;gon som &auml;r medlem som godk&auml;nner dig, om du inte tr&auml;ffat n&aring;gon kom d&aring; till n&auml;sta tr&auml;ff, kolla i kalendern s&aring; ser du n&auml;r det &auml;r!\\n\\nTack f&ouml;r &ouml;verseende!');\"";
}?> >
	<div align="center">
	<?php require_once( 'topInclude.php' );?>
	<tr>
<!-- SESSION RUTAN -->
		<td valign="top">

 		  <div class="boxLeft">
  		  <h3 class="boxHeader">
        	  Tjipp!</h3>
	          <h4 class="boxContent">

		
		<?php 
if( isset( $_SESSION['userid'] ) && $_SESSION['userid'] != "" && FALSE) {
	// User is logged in, present user menu

	print "Inloggad som ".$_SESSION['username']."<br> session userid: ".$_SESSION['userid']."<br> session usertype: ".$_SESSION['usertype']."<br> session username: ".$_SESSION['username'];
}
else {
	// User is not logged in, present form

	?>
<!-- SESSION RUTAN -->

		T&auml;nk p&aring; att ju mer information du anger nu desto roligare blir upplevelsen f&ouml;r dig och andra. 
		<br>
		Alla f&auml;lt &auml;r inte n&ouml;dv&auml;ndiga men det &auml;r t&auml;nkt att man skall fylla i efter b&auml;sta f&ouml;rm&aring;ga, det &auml;r &ouml;ppenhet
		vi bygger denna community p&aring;!
		
		<?php
}
?>
		</h4>
		</div>
		
		</td>

<td height="190" valign="top">

<div class="regWindow1">
<!-- REGISTERSIDAN -->
<?php 
if( !isset( $_GET['mode'] ) ) {
	if( $_SESSION['userid'] != "" ) {
		header( "Location: "."logout.php?redirect=register.php" );
	}?>

	
		Medlemskapet &auml;r till f&ouml;r dom som vill vara en del av eldsj&auml;ls familj, m&auml;rk v&auml;l att du har tillg&aring;ng till det mesta i communityn, &auml;ven om du inte &auml;r medlem. 
		Att registrera sig &auml;r l&auml;tt och g&aring;r fort, men kommer att kr&auml;va en del engagemang, <b>om du inte har tid att skriva presentation eller har kort att ladda upp redo nu, &ouml;verv&auml;g d&aring; att v&auml;nta med registreringen tills att du har detta klart!</b>
		<br>
	
	<span class="redAngry">
		<?php print isset( $_GET['message'] ) ? $_GET['message'] : '';?>
	</span>


	<form action="register.php?mode=register" method="post" name="register" ID="register">
	<center>
		<div class="plainTheadBlack, boxtext2" align=left>
			<img src="images/1x1.gif" width="45" height="1"> Anv&auml;ndarnamn<br>
			<img src="images/1x1.gif" width="45" height="1"> <INPUT type="text" ID="username" NAME="username" maxlength="12"><br>
			<img src="images/1x1.gif" width="45" height="1"> L&ouml;senord
			<br>
			<img src="images/1x1.gif" width="45" height="1"> <INPUT type="text" ID="password" NAME="password" maxlength="12"><br>
			<br>
		</div>
	</center>
	<img src="images/1x1.gif" width="45" height="1"> <a href="javascript:ValidateAccountRegister();">
		<IMG SRC="images/register.gif" border="0"></a> 
		<table border="0" width="100%" cellpadding="0" class="inputbox" ID="Table1">
			<tr>
				<td width="100%">
				<b>Eldsj&auml;l f&ouml;reningen!</b><br>
					Eldsj&auml;l &auml;r inte en community i vanlig bem&auml;rkelse, utan ett verktyg f&ouml;r att tr&auml;ffas i verkligheten. Till communityn finns det knutet en f&ouml;rening som bla. sk&ouml;ter drift och utvecklnig av communityn, arrangerar nationella tr&auml;ffar mm. Att vara medlem i f&ouml;reningen och communityn eldsj&auml;l &auml;r samma sak. Man kan n&auml;r som helst beg&auml;ra uttr&auml;de ur f&ouml;reningen eldsj&auml;l.<BR>
					Jag godk&auml;nner h&auml;rmed medlemsskap i f&ouml;reningen eldsj&auml;l, samt f&ouml;reningens <A HREF="http://www.eldsjal.org/board.php?page=stadgar" target="_new" class=a2>stadgar</A>. I och med att jag loggar in p&aring; mitt medlemskonto f&ouml;rnyar jag mitt medlemsskap i f&ouml;reningen eldsj&auml;l.
					<br><br>
					<input type="checkbox" value="1" name="member" id="member">Genom att kryssa i denna ruta godk&auml;nner jag medlemsskap i F&ouml;reningen eldsj&auml;l.<BR>
						<SELECT name="region" class="selectbox" size="1" ID="region">
							<OPTION VALUE="0" SELECTED>V&auml;lj region*</OPTION>
							<OPTION VALUE="1">Svealand (Centrala sverige)</OPTION>
							<OPTION VALUE="2">G&ouml;taland (S&ouml;dra sverige)</OPTION>
							<OPTION VALUE="3">Norrland (Gissa...)</OPTION>
						</SELECT>
				</td>
			</tr>
			<tr>
			<td>&nbsp;
			</td>
			</tr>			<tr>
				<td width="100%">
				<b>Behandling av personuppgifter</b><br>
					Fr&aring;n och med den 1 oktober 2001 g&auml;ller personuppgiftslagen fullt ut. Uppgifter som registreras i samband med denna ans&ouml;kan och eventuellt senare vid komplettering av uppgifter kommer hanteras konfidentiellt och l&auml;mnas inte vidare
					till andra f&ouml;retag. F&ouml;r att bli medlem m&aring;ste du godk&auml;nna att denna information lagras som du sj&auml;lv fyllt i. Jag godk&auml;nner &auml;ven att mitt eventuellt
					ins&auml;nda foto f&aring;r visas f&ouml;r bes&ouml;kare och medlemmar p&aring; communityn eldsj&auml;l, nyhetsbrev, visitkort, presentation eller vid t&auml;vlingstillf&auml;llen.
					<br><br>
					<input type="checkbox" value="1" name="toa" id="toa">Genom att l&aring;ta denna vara ikryssad godk&auml;nner jag PUL och de copyrightregler som g&auml;ller p&aring; communityn Eldsj&auml;l. Jag g&aring;r &auml;ven med p&aring; att information om mig lagras p&aring; Eldsj&auml;ls servrar samt att eventuella inl&auml;gg jag g&ouml;r inte strider mot andra copyrightlagar.
				</td>
			</tr>
			<tr>
			<td>&nbsp;
			</td>
			</tr>
			<tr>
				<td width="100%">
				<b>Anv&auml;ndning av cookies</b><br>
				Enligt den nya lagen om elektronisk kommunikation, som tr&auml;dde i kraft den 25 
				juli 2003, ska bes&ouml;karen p&aring; en webbplats informeras om att webbplatsen anv&auml;nder 
				cookies. Anv&auml;ndaren ska ocks&aring; ges m&ouml;jlighet att hindra cookies.
				<br><br>
				<input type="checkbox" value="1" name="cookies" id="Checkbox1">Genom att l&aring;ta denna vara ikryssad godk&auml;nner jag som anv&auml;ndare att elektroniska cookies lagras p&aring; min dator i och med att jag anv&auml;nder webbplatsen Eldsjal.org
				</td>
			</tr>
		</table>
		
		
	</form>

<div valign=bottom>
	<h6 class="regNum2">1</h6><h6 class="regNum1">234</h6>
</div>




</td>
<td valign="top" align="right">
	<div class="boxRight">
	<h3 class="boxHeader">
	Hur g&aring;r det till?</h3>
	<h4 class="boxContent">
		Registrering &auml;r fyra steg. Dessa &auml;r uppdelade p&aring;:<br>
		Steg 1:<br>Skapa konto f&ouml;r inloggning<br>
		Steg 2:<br>Ange information om dig sj&auml;lv<br>
		Steg 3:<br>Ber&auml;tta om dig sj&auml;lv<br>
		Steg 4:<br>Ladda upp fotografi<br>
	</h4>
	</div>
</td>
</tr>

<?php
}
elseif( $_GET['mode'] == "collect2" ) {
	?>
		<form action="register.php?mode=register2" method="post" name="register2" id="register2">
			<img src="images\1x1.gif" width="450" height="1">
			<center><b>Nu vill vi ha lite personliga uppgifter...</b> 
	<TABLE CELLPADDING="2" CELLSPACING="5" border="0" width="100%">
		<TR VALIGN="top" ALIGN="left">
			<TD>
				<div class="boxtext2">
				F&ouml;rnamn<br>
				<input class="inputBorder" type="text" name="first_name" id="first_name"><br>
				Efternamn<br>
				<input class="inputBorder" type="text" name="last_name" id="last_name"><br>

				Kille <input class="inplutt" type="radio" value="0" ID="boy" NAME="gender">
				Tjej <input class="inplutt" type="radio" checked value="1" ID="girl" NAME="gender"><br>
				<br>
				Adress:<P>
				C/O<BR>
				<INPUT class="inputBorder" type="text" name="co" ID="co"><BR>
				Gatuadress 1<BR>
				<INPUT class="inputBorder" type="text" name="gatuadress1" ID="Gatuadress1"><BR>
				Gatuadress 2<BR>
				<INPUT class="inputBorder" type="text" name="gatuadress2" ID="Gatuadress2"><BR>
				Postnummer<BR>
				<INPUT class="inputBorder" type="text" name="postnummer" ID="postnummer" maxlength="5" onChange="isNumeric(document.register2.postnummer.value,'Postnummer &auml;r enbart siffror, du angav &auml;ven bokst&auml;ver nu, d&aring; blir det knas!\nG&Oring;R OM!');"><BR>
				Postadress<BR>
				<INPUT class="inputBorder" type="text" name="stad" ID="stad"><BR>
				Land<BR>
				<INPUT class="inputBorder" type="text" name="land" ID="land"><BR><BR>
				F&ouml;delse&aring;r<BR>
				<select class=selectBox name="born_year" size="1" ID="Select1">
					<?php 
  $born_year = 1900;
	while( $born_year <= date("Y") ) {
		print "<option value=".$born_year;
		if( $born_year == intval( 1979 ) ) {
			print " selected ";
		}
		print ">".$born_year."</option>";
		$born_year = $born_year + 1;
	}
	?>
				</select><BR>
				F&ouml;delsem&aring;nad<BR>
				<select name="born_month" class=selectBox size="1" ID="Select2">
					<option value="01">Januari</option>
					<option value="02" selected>Februari</option>
					<option value="03">Mars</option>
					<option value="04">April</option>
					<option value="05">Maj</option>
					<option value="06">Juni</option>
					<option value="07">Juli</option>
					<option value="08">Augusti</option>
					<option value="09">September</option>
					<option value="10">Oktober</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select><BR>
				F&ouml;delsedag<BR>
				<select name="born_date" class=selectBox size="1" ID="Select3">
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18" selected>18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
				</select><BR>
				Fyra sista<BR>
				<INPUT class="inputBorder" TYPE="text" MAXLENGTH="4" name="fourlast" id="fourlast" onChange="isNumeric(document.register2.fourlast.value,'Personnummer &auml;r enbart siffror, du angav &auml;ven bokst&auml;ver nu, d&aring; blir det knas!\nG&Oring;R OM!');">
				</div>
			</TD>
			<TD>
				<div class="boxtext2" align="left">
				D&ouml;lj privat info f&ouml;r ickemedlemmar?<br>
				Ja <input class="inplutt" type="radio" value="1" ID="radio" NAME="private">
				Nej <input class="inplutt" type="radio" checked value="0" ID="radio" NAME="private"><br><BR>
				Ort/Stadsdel<BR>
				<select name="city" class=selectBox class="text" style="width: 178; height: 23" ID="Select4">
					<option selected value="261">-- v&auml;lj l&auml;n eller land --</option>
					<?php 
  $sql = "select * from locations  order by sortorder asc, locationname";
	$dbLocations = $conn->execute( $sql );

	//(($sql),$conn);
	//$dbLocations=mysql_fetch_array($dbLocations_query);;
	$dbLocationss = $dbLocations;
	foreach( $dbLocationss as $dbLocations ) {
		print "<option value=".$dbLocations['locationid']." > ".$dbLocations['locationname']."</option>";

		//    $dbLocations=mysql_fetch_array($dbLocations_query);
	}
	?>
					</select><BR>
				<input type="text" class="inputBorder" name="cityname"><br><br>
				e-mail<br>
				<INPUT class="inputBorder" type="text" ID="email" NAME="email"><br>
				Icq<BR>
				<INPUT class="inputBorder" type="text" ID="icq" NAME="icq" onChange="isNumeric(document.register2.icq.value,'Icq Nummer &auml;r enbart siffror, du angav &auml;ven bokst&auml;ver nu, d&aring; blir det knas!\nG&Oring;R OM!');"><br>
				MSN<BR>
				<INPUT class="inputBorder" type="text" ID="msn" NAME="msn"><br>
				Telefon<BR>
				<INPUT class="inputBorder" type="text" ID="yahoo" NAME="yahoo">
				<br><br>
					Vilken tr&auml;ff har du bes&ouml;kt och/eller vem har du tr&auml;ffat som &auml;r medlem p&aring; Eldsj&auml;l? (m&aring;ste fyllas i)<br>
					<textarea name="howInform" cols="30" rows="10" wrap class="inputBorder" ID="Textarea1"></textarea>
					<br><br>

				<img src="images/1x1.gif" width="45" height="10">Vidare 
				
				<a href="javascript:ValidateInfo();">
				<img src="images/icons/arrows.gif" border="0">
				</a> 
					</div>

			</TD>
		</TR>
	</TABLE>
	<h6 class="regNum1">1</h6><h6 class="regNum2">2</h6><h6 class="regNum1">34</h6>
</center>
</td>
	<td width="145" height="109" valign="top" align="right">
	
	<div class="boxRight">
	<h3 class="boxHeader">
	eldsjal.org</h3>
	<h4 class="boxContent">
	<div class="newsText">
		Eldsj&auml;l &auml;r den mest levande communityn i Sverige f&ouml;r alla som har ett 
		intresse f&ouml;r alternativkonst, vare sig det &auml;r eld, trummor, eller dans, enda 
		kriteriet &auml;r egentligen att sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det 
		praktiseras. Vi s&auml;tter stor tilltro till varje medlem och m&ouml;ts hela tiden 
		av varma sk&ouml;na m&auml;nniskor med massor att ge. V&auml;lkommen!
	</div>
	</h4>
	</div>
</td>
</tr>

<?php
}
elseif( $_GET['mode'] == "collect3" ) {
	?>
	
		<form action="register.php?mode=register3" method="post" name="collect3" id="collect3">
		<div align=center>
		
		<div class="plainText">
			Med handen p&aring; hj&auml;rtat: vilka aktiviteter &auml;gnar du dig regelbundet &aring;t?</div>
			<br>
			<table border="0" class="activityList">
			<tr>
			<?php 
  $sql = "select * from artlist where imageonly = 0 order by artname";
	$artLists = $conn->execute( $sql );

	$styleCount = 0;
	$iCount = 0;
	foreach( $artLists as $artList) {
		print "<td><INPUT type=checkbox ID=art".$iCount." NAME=art[".$artList['artid']."] value=".$artList['artid']."><a class=a2 href=javascript:openInfo('shortInfo.php?mode=".$artList['artid']."') >".$artList['artname']."</a></td>";
		$iCount = $iCount + 1;
		$styleCount = $styleCount + 1;
		if( $styleCount == 3 ) {
			print "</tr><tr>";
			$styleCount = 0;
		}
	}
	?>
			</tr>
			</table>
			<br>

				<div class="plainText">	
			Skriv en presentationstext, t.ex om vad du sysslar med och hur du &auml;r som person</div>
			<textarea name="presentation" cols="50" rows="10" wrap></textarea><br>
			<input type = "hidden" name ="txtCount" value="<?php   echo $iCount;?>" ID="Hidden1">
			<img src="images/1x1.gif" width="45" height="10">Vidare 
				
				<a href="javascript:ValidatePresentation();">
				<img src="images/icons/arrows.gif" border="0">
				</a> 



	</div>
		</form>
	<h6 class="regNum1">12</h6><h6 class="regNum2">3</h6><h6 class="regNum1">4</h6>
</td>
<td valign="top">
	
	
	<div class="boxRight">
	<h3 class="boxHeader">
	Presentationen</h3>
	<h4 class="boxContent">

	<div class="newsText">
		Allt blir mycket roligare desto utf&ouml;rligare presentationer som folk skriver.
		Vi &auml;r juh h&auml;r f&ouml;r att tr&auml;ffa nytt folk eller hur, d&aring; vill man g&auml;rna veta lite om
		sina medm&auml;nniskor. Ta dig lite extra tid och skriv en fin presentationstext.
	</div>
	
	
	</h4>
	</div>
</td>
</tr>

<?php
}
elseif( $_GET['mode'] == "register" ) {
	$error = '';
	if( $_POST['password'] == "" )
		$error .= "Du måste ange lösenord! ";
	if( $_POST['username'] == "" && $error == "" )
		$error .= "Du måste ange användarnamn ";
	if( $_POST['toa'] != "1" )
		header( "Location: "."register.php?message=Du måste acceptera avtalet om PUL om du vill vara medlem här!" );
	if( $_POST['cookies'] != "1" )
		header( "Location: "."register.php?message=Du måste acceptera cookies om du vill vara medlem här!" );
		
	// if( !isset( $error ) ) {
		$username = trim(cq( strtolower( $_POST['username'] ) ));

		$sql = "select * from lockedusernames where username = '".$username."'";
		// print $sql;
		$nameIsLocked = $conn->execute($sql);
		// print_r($nameIsLocked);
		if( $nameIsLocked ) {
			$error .= "Detta användarnamn är ej registrerbart! ";
		}

		$sql = "select * from users where username = '".$username."'";
		// print $sql;
		$nameIsTaken = $conn->execute($sql);
		// print_r($nameIsTaken);
		if( $nameIsTaken ) {
			$error .= "Detta användarnamn är redan upptaget! ";
		}
	// }
	if( !empty($error) ) {
		header( "Location: "."register.php?message=".$error );
		exit();
	}
	$sql = "insert into users (username, password, usertype, redirect, online, register_date, hasimage, lastlogin, approvedby, private, member) values ('".$username."', '".cq( $_POST['password'] )."', 0, 'http://www.eldsjal.org/register.php?mode=collect2', 1, getdate(), 0, getdate(), 0, 0, ".cq( $_POST['member'] ).")";
	$conn->execute( $sql );

	$sql = "select username, userid, usertype from users where username = '".$username."'";
	$dbUser = $conn->execute( $sql );

	$_SESSION['userid'] = $dbUser['userid'];
	$_SESSION['usertype'] = $dbUser['usertype'];
	$_SESSION['username'] = $dbUser['username'];

	$sql = "insert into loginhistory (userid, username, logintime) values (".$_SESSION['userid'].",'".$_SESSION['username']."', getdate())";
	$conn->execute( $sql );

	header( "Location: "."register.php?mode=collect2" );
}

elseif( $_GET['mode'] == "register2" ) {
	$sql = "UPDATE users SET first_name =  '".cq( $_POST['first_name'] )."', last_name = '".cq( $_POST['last_name'] )."', email = '".cq( $_POST['email'] )."', born_year = '".cq( $_POST['born_year'] )."', born_month = '".$_POST['born_month']."', born_date = '".cq( $_POST['born_date'] )."', icq = '".cq( $_POST['icq'] )."', msn = '".cq( $_POST['msn'] )."', yahoo = '".cq( $_POST['yahoo'] )."', webpage = '".cq( $_POST['webpage'] )."', redirect = 'http://www.eldsjal.org/register.php?mode=collect3', gender = ".intval( $_POST['gender'] ).", city = ".intval( $_POST['city'] ).", eldsjalFind = '".cq( $_POST['howInform'] )."', private = ".$_POST['private'].", inhabitance = '".cq( $_POST['cityname'] )."', fourlast = ".cq( $_POST['fourlast'] )." WHERE userid = ".$_SESSION['userid'];
	// print $sql;
	$conn->execute( $sql );

	$mail = new Mail();
	$mail->set_from("eldsjal@eldsjal.org","Eldsjäl");
	$mail->add_to( cq( $_POST['email'] ), cq( $_POST['first_name'] ).' '.cq( $_POST['last_name'] ) );
	$mail->set_subject('Du väntar nu på att bli godkänd medlem på Eldsjäl!');
	$mail->add_bodypart("Det känns superkul att du har hittat fram till oss på Eldsjäl. Tyvärr så har vi lagt till en liten extrasnurra för att försäkra oss om att alla medlemmar på eldsjäl verkligen delar med sig av sig själva och blir lika delaktiga som de andra medlemmarna är, något som gör vår community lite annorlunda! Detta går till så att någon av oss andra medlemmar kommer att kolla på dina uppgifter och se att de ser bra ut, att du har en passande och bra presentation och att du inte heter kalle anka t.ex. Om allt ser fint ut så blir du godkänd och får då ett nytt mail om det med inloggningsuppgifter, detta brukar gå rätt snabbt!"."\r\n"."\r\n"."Visst är det tråkigt att behöva vänta men det är nödvändigt ont för att upplevelsen ska bli desto bättre för alla i slutändan!"."\r\n"."\r\n"."Under tiden du väntar kan du passa på att logga in och bättra på dina uppgifter om du känner att det är något du slarvade med, eller passa på att logga ut och läsa i forumet så du får en bild om vilka vi Eldsjälar är och vad vi står för!"."\r\n"."\r\n"."Hoppas vi ses snart på sajten, ännu bättre, på en träff!"."\r\n"."\r\n"."Många kramar, Eldsjäl!");
	$mail->send();


	$sql = "insert into address (userid, co, gatuadress1, gatuadress2, postnummer, stad, land) values ('".$_SESSION['userid']."','".cq( $_POST['co'] )."','".cq( $_POST['gatuadress1'] )."','".cq( $_POST['gatuadress2'] )."','".cq( $_POST['postnummer'] )."','".cq( $_POST['stad'] )."','".cq( $_POST['land'] )."')";
	print $sql;
	$conn->execute( $sql );

	header("Location: "."register.php?mode=collect3");
}

elseif( $_GET['mode'] == "register3" ) {
	if( $_SESSION['userid'] == "" ) {
		header( "Location: "."main.php?message=ditt konto finns inte eller så är du inte inloggad!" );
	}

	$sql = "delete from userartlist where userid =".$_SESSION['userid'];
	$conn->execute( $sql );

	foreach( $_POST['art'] as $artId => $something) {
			$sql = " insert into userartlist (userid, artid) values (".$_SESSION['userid'].", ".$artId.")";
			$results = $conn->execute( $sql );
	}
	$formatTexten = cq( $_POST['presentation'] );
	$sql = "update users set presentation = '".$formatTexten."', redirect = '' where userid = ".$_SESSION['userid'];
	$conn->execute( $sql );

	header( "Location: "."userEdit.php?mode=image&userid=".$_SESSION['userid']."&message=Bra jobbat, snart klar!" );
}
?>
</div>
	<tr>
	</tr>
<?php require_once( 'bottomInclude.php' );?>
