<?php
include('topInclude.php');
	$mail = new Mail();
	$mail->set_from("eldsjal@eldsjal.org","Eldsj&auml;l");
	$mail->add_to('johnny@nurrd.se');
	$mail->set_subject('Du v&auml;ntar nu p&aring; att bli godk&auml;nd medlem p&aring; Eldsj&auml;l!');
	$mail->add_bodypart("Det k&auml;nns superkul att du har hittat fram till oss p&aring; Eldsj&auml;l. Tyv&auml;rr s&aring; har vi lagt till en liten extrasnurra f&ouml;r att f&ouml;rs&auml;kra oss om att alla medlemmar p&aring; eldsj&auml;l verkligen delar med sig av sig sj&auml;lva och blir lika delaktiga som de andra medlemmarna &auml;r, n&aring;got som g&ouml;r v&aring;r community lite annorlunda! Detta g&aring;r till s&aring; att n&aring;gon av oss andra medlemmar kommer att kolla p&aring; dina uppgifter och se att de ser bra ut, att du har en passande och bra presentation och att du inte heter kalle anka t.ex. Om allt ser fint ut s&aring; blir du godk&auml;nd och f&aring;r d&aring; ett nytt mail om det med inloggningsuppgifter, detta brukar g&aring; r&auml;tt snabbt!"."\r\n"."\r\n"."Visst &auml;r det tr&aring;kigt att beh&ouml;va v&auml;nta men det &auml;r n&ouml;dv&auml;ndigt ont f&ouml;r att upplevelsen ska bli desto b&auml;ttre f&ouml;r alla i slut&auml;ndan!"."\r\n"."\r\n"."Under tiden du v&auml;ntar kan du passa p&aring; att logga in och b&auml;ttra p&aring; dina uppgifter om du k&auml;nner att det &auml;r n&aring;got du slarvade med, eller passa p&aring; att logga ut och l&auml;sa i forumet s&aring; du f&aring;r en bild om vilka vi Eldsj&auml;lar &auml;r och vad vi st&aring;r f&ouml;r!"."\r\n"."\r\n"."Hoppas vi ses snart p&aring; sajten, &auml;nnu b&auml;ttre, p&aring; en tr&auml;ff!"."\r\n"."\r\n"."M&aring;nga kramar, Eldsj&auml;l!");
	$mail->send();
	
?>
<tr><td colspan="3">
	<pre>
	<?php print_r($mail);?>
	</pre>
</td></tr>
<?php include('bottomInclude.php');?>