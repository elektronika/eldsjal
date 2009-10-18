<?php
//SELECT CONVERT(CHAR(8), loginTime, 1) AS DateOfQuery, Count(*) AS CountOfUser FROM loginHistory GROUP BY CONVERT(CHAR(8), loginTime, 1)
//SQL = "SELECT Count(*) AS visitorCount FROM loginHistory WHERE CONVERT(CHAR(10), loginTime, 121) = '" & date() & "'"
//SET visitors = conn.execute(SQL)
//visitors("visitorCount")
/* Inloggade medlemmar: <?php echo $application['loggedincount']." / ".$application['membercount'];?><br/> */
$onlineCount = current($conn->execute('select count(*) from users where online = 1'));
?>
<div id="footer-wrap">
	<div id="footer" class="container_16">
		<div id="footer-left" class="grid_7 prefix_1">
			<a href = "members.php?mode=showOnline" class = "a2" ><?php echo $onlineCount; ?> eldsjälar är online</a><br/>
			Antal inloggade idag: <?php echo $application['visitorcount'];?>
		</div>
		<div id="footer-right" class="grid_7">
			Senast uppdaterad: En stund sedan.
<?php print $application['lastupdate']."<br/>eldsjal.org v.".$application['version']." (".$application['versionname'].") "; ?>
		</div>
		<div id="footer-text" class="grid_14 prefix_1">
			Det &auml;r ej till&aring;tet att kopiera, sprida eller vidaref&ouml;rmedla information fr&aring;n Eldsj&auml;l	F&ouml;reningen Eldsj&auml;l  (C) 2005 - <?php echo date('Y');?><br/>
			eldsjal.org drivs av f&ouml;reningen Eldsj&auml;l med st&ouml;d fr&aring;n Ungdomsstyrelsen
		</div>
	</div>
</div>
<?php if(isset($devTemplate)) { 
	$dev = DEV::get_dev();
	$devTemplate->assign('dev', array('logs'=>$dev->get_logs(), 'time'=>Util::timediff(), 'globals'=>$dev->get_globals()));
	$devTemplate->display('dev.tpl');
} ?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-201570-2";
urchinTracker();
</script>
</body>
</html>
<?php $conn->close(); ?>