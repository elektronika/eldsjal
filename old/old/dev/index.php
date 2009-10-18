<?php 
ob_start( );
// print 'hej';

$dont_display_header = TRUE;

require_once( 'header.php' );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
      "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
<link REL=Stylesheet type="text/css" HREF=style.css>
<META HTTP-EQUIV=Refresh CONTENT="10; URL=main.php"><meta name="verify-v1" content="XbqXT+XFPnPA96AFg1m4i1AdFaAu21STr6ZqnMHXHrA=" />
</head>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" bgcolor="#1A0601" >
<?php
/*
function skapaNuDatum()
{
extract($GLOBALS);

$Y=strftime("%Y",time());
$M=strftime("%m",time());
if (strlen($M)==1)
{

 $M=0.$M;
} 

$D=$day[time()];
if (strlen($D)==1)
{

 $D=0.$D;
} 

$function_ret=$Y."-".$M."-".$D;
return $function_ret;
} 
$ForAppending=8;
$referer=$_SERVER['http_referer'];
if (strlen($referer)>0 && (strpos($referer,"http://www.eldsjal.org") ? strpos($referer,"http://www.eldsjal.org")+1 : 0)==false && (strpos($referer,"http://dev2.eldsjal.org") ? strpos($referer,"http://dev2.eldsjal.org")+1 : 0)==false)
{

$fname=$DOCUMENT_ROOT."\\Logfiles\\referer_".skapaNuDatum().".txt";
// $FSO is of type "Scripting.FileSystemObject"
if (file_exists($fname))
{

 $WriteToFile=fopen($fname,"r");
}
 else
{

 $WriteToFile=fopen($fname, "w");
} 

fputs($WriteToFile,$referer."\n");
fclose($WriteToFile);
$FSO=null;

} 
*/

$sql = "update counter set count  = count + 1";
$dbCount = $conn->execute( $sql );;?>
<span class="plainThead"><font color="#FFFFFF"><?php echo isset( $_GET['message'] ) ? $_GET['message'] : '';?></font></span>
<div valign="middle"><a href="main.php"><img src="eldsjal2.jpg" width="800" height="600" border="0"></a></div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-201570-2";
urchinTracker();
</script>
</body>
</html>
