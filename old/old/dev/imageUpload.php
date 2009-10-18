<?php
session_start( );
$dont_display_header = TRUE;
require_once( 'header.php' );

ob_start( );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
		<link rel="stylesheet" href="style.css" type="text/css">
		<meta name="GENERATOR" content="Microsoft Visual Studio.NET 7.0">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta name="Expires" content="<?php echo time( );?>">
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		
	<script language="javascript">
	<!--
	function CheckForm() {

	if (!document.submitPicture.agree.checked) {
	alert("Du m&aring;ste godk&auml;nna avtalet!");
	return false;
	}
	return true;
	}
	-->
	</script>
	</head>

<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" bgcolor="#ffcc66">
<?php
//<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" bgcolor="#ffcc66"onLoad="javascript:window.alert('Jag sitter och bygger om bilduppladdningen f&ouml;r att st&ouml;dja mac, f&ouml;rs&ouml;k igen om en stund!');">

if( isset( $_GET['mode'] ) && $_GET['mode'] == "regInfo" ) {
	if( $_POST['private'] == "" ) {
		$privatePic = 0;
	}
	else {
		$privatePic = 1;
	}
	$sql = "update images set imagename = '".cq( $_POST['imagename'] )."', imagedesc = '".cq( $_POST['imagedesc'] )."', approved = 0, private = '".intval( $privatepic )."' where imageid = ".intval( $_POST['imageid'] );
	$conn->execute( $sql );
	$iCount = $_POST['txtcount'];
	for( $i = 0; $i <= $iCount; $i = $i + 1 ) {
		$sid = $_POST["category".$i];
		if( $sid != "" ) {
			$sql = "insert into imageartlist (artid, imageid) values ('".intval( $sid )."', '".intval( $_POST['imageid'] )."')";
			$updateInfo = $conn->execute( $sql );;
		}
	}
	?>
<script language="javascript">
//window.opener.location='gallery.php';
//window.close();
</script>
<?php
}
else {
	?>


<!---------------------------------->


<table cellpadding="3" cellspacing="0" border="0" id="Table1">
	<tr>
	 <td bgcolor="#ffcc66">



<form action="imageUploadAct.php" method="post" onsubmit="return CheckForm();" name="submitPicture" id="submitPicture" ENCTYPE="multipart/form-data">
	<b><?php   echo isset( $_GET['message'] ) ? $_GET['message'] : '';?></b>
	<div class=plainText>
	<strong>F&ouml;rst ska vi leta r&auml;tt p&aring; bilden att ladda upp!</strong>
	 </div>
	
	
</td>
</tr>
<tr>
<td bgcolor="#ffcc66">

	
	
	<input type="file" name="file1" size="16" class="formButton"/>
	<br/>
	<input type="submit" name="proceed" id="Submit1" value="&raquo;&raquo;"/>


</td>
</tr>
<tr>

<td bgcolor=#ffcc66>
<br/> <hr><div class=plainText>
I och med att Du v&auml;ljer att ladda upp bilden till Eldsj&auml;ls servrar har Du ocks&aring; avsagt dig ensamr&auml;tten, men inte copyrighten till bilden. Detta inneb&auml;r i praktiken att Eldsj&auml;l som f&ouml;rening fritt kan nyttja bilden i andra avseenden &auml;n de som erbjuds i och med galleriet. Du &auml;r fortfarande upphovsman till bilden men har inte l&auml;gre &auml;gander&auml;tten. Om Du har n&aring;gra fr&aring;gor r&ouml;rande detta ser vi g&auml;rna att Du kontaktar v&aring;r personal innan Du laddar upp en bild.
<br/><b>Jag godk&auml;nner detta</b></div>
<input type="checkbox" name="agree" value="1" id="agree"/>
</form>
<?php
}

//mysql_close($conn);

?>

</TD>
</tr>
</TABLE> 
</body>
</html>
