</table>
</div>
<?php
//SELECT CONVERT(CHAR(8), loginTime, 1) AS DateOfQuery, Count(*) AS CountOfUser FROM loginHistory GROUP BY CONVERT(CHAR(8), loginTime, 1)
//SQL = "SELECT Count(*) AS visitorCount FROM loginHistory WHERE CONVERT(CHAR(10), loginTime, 121) = '" & date() & "'"
//SET visitors = conn.execute(SQL)
//visitors("visitorCount")
/* Inloggade medlemmar: <?php echo $application['loggedincount']." / ".$application['membercount'];?><br> */
$onlineCount = current($conn->execute('select count(*) from users where online = 1'));
?>
<div id="footer-wrap">
	<div id="footer">
		<div class="float-left">
			<a href = "members.php?mode=showOnline" class = "a2" ><?php echo $onlineCount; ?> eldsjälar är online</a><br/>
			Antal inloggade idag: <?php echo $application['visitorcount'];?>
		</div>
		<div class="float-right">
			<?php if(file_exists('revision')): ?>
				Senast uppdaterad: <?php echo date('d/m/y, H:i', filemtime('revision')); ?><br/>
				eldsjal.org <a href="development.php">rev. <?php require('revision');?></a>
			<?php else: ?>
				DEV
			<?php endif; ?>
		</div>
		<div id="footer-text">
			Det &auml;r ej till&aring;tet att kopiera, sprida eller vidaref&ouml;rmedla information fr&aring;n Eldsj&auml;l	F&ouml;reningen Eldsj&auml;l  (C) 2005 - <?php echo date('Y');?><br>
			eldsjal.org drivs av f&ouml;reningen Eldsj&auml;l med st&ouml;d fr&aring;n Ungdomsstyrelsen
		</div>
	</div>
</div>
<script type="text/javascript" src="/jquery.min.js"></script>
<script type="text/javascript" src="/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<script type="text/javascript" src="/scripts.js"></script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
_uacct = "UA-201570-2";
urchinTracker();
</script>
</body>
</html>
<?php $conn->close(); ?>