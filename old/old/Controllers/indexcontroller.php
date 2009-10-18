<?php
class IndexController extends Spiffy_Controller { 
	public function get_index() { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>eldsj&auml;l - communityn f&ouml;r v&auml;rme och alternativkonst</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="Refresh" content="10;url=main.php" />
	<meta name="verify-v1" content="XbqXT+XFPnPA96AFg1m4i1AdFaAu21STr6ZqnMHXHrA=" />
</head>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" bgcolor="#1A0601" >
    <span class="plainThead" style="color: white"><?php echo isset( $_GET['message'] ) ? $_GET['message'] : '';?></span>
   	<div align="center">
   		<a href="main.php"><img src="eldsjal2.jpg" width="800" height="600" border="0"/></a>
   	</div>
   	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
   	<script type="text/javascript">
   	_uacct = "UA-201570-2";
   	urchinTracker();
   	</script>
    </body>
</html>
	<?php }
}