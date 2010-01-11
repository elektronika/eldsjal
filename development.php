<?php
session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>
	<tr>
		<td valign="top" align="left">
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>
<?php 
if( $_SESSION['userid'] != "" ) {
	?>
		<div class="boxLeft">
		<h3 class="boxHeader">
		just nu:</h3>
		<h4 class="boxContent">
		<?php require_once( 'action.applet.php' );?>
		</h4>
		</div>
<?php
}?>
<div class="boxLeft">
<h3 class="boxHeader">Aktiviteter</h3>
<h4 class="boxContentCalendar">
	<?php require_once( 'calendar.php' );?>
</h4></div>
		<div class="boxLeft">
		<h3 class="boxHeader">
		Visheter:</h3>
		<h4 class="boxContent">
			<?php require_once( 'wiseBox.applet.php' );?>
		</h4>
		</div>
		<div class="boxLeft">
		<h3 class="boxHeader">
		nya tankar:</h3>
		<h4 class="boxContent">
			<?php require_once( 'diarys.applet.php' );?>
		</h4>
		</div>
		<div class="boxLeft">
		<h3 class="boxHeader">
		senast inloggade:
		</h3>
		<h4 class="boxContent">
		<?php require_once( 'userHistory.applet.php' );?>
		</h4>
		</div>
		<div class="boxLeft">
		<h3 class="boxHeader">
		Senaste bilder:</h3>
		<h4 class="boxContent">
			<?php require_once( 'image.applet.php' );?>
		</h4>
		</div>
	</td>
	<td height="190" valign="top">
<?php if(file_exists('svnlog.xml')): ?>
<?php $log = new SimpleXMLElement(file_get_contents('svnlog.xml')); ?>
<?php foreach($log as $item):?>
	<h3><?php echo $item['revision'];?> - <?php echo $item->msg; ?></h3>
	<p><?php echo date('Y-m-d ', strtotime((string) $item->date)); ?> av <?php echo $item->author; ?></p>
<?php endforeach;?>
<?php else: ?>
	Ehm, svnlog.xml saknas. Antingen så har något gått snett eller så är det här någons privata utvecklingssida.
<?php endif;?>
</td>
<td valign="top">


<div class="boxRight">
<h3 class="boxHeader">
Utveckling</h3>
<h4 class="boxContent">
Här kan du se vad som händer med utvecklingen utav eldsjal.org. Om du är sugen på att hjälpa till så kan du alltid peta på intedinmamma, eller någon annan som verkar tuff.<br/><br/>Det kanske inte går så fort, och det kanske inte blir så bra, men vi är söta och glada. :)
</h4>
</div>	

</td>

</tr>
<?php require_once( 'bottomInclude.php' );?>
