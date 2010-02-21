<?php region('content'); ?>
<?php 
$iWidth = $frontimage->width + 50;
$iHeight = $frontimage->height + 300;
?>
<a href="javascript:openImage('viewPicture.php?imageid=<?php echo $frontimage->imageid; ?>','<?php echo $iWidth; ?>','<?php echo $iHeight; ?>','firstpage');">
	<img src="/uploads/galleryImages/<?php echo $frontimage->imageid.'.'.$frontimage->filetype; ?>" width="450" alt="<?php echo $frontimage->imagename; ?>">
</a>
<h2>V&auml;lkommen till eldsj&auml;l - alternativkonstens organisation!</h2>
<p>Eldsj&auml;l &auml;r en organisation f&ouml;r de med intresse av alternativkonst, vare sig det &auml;r eldkonst, trummor, eller dans, enda kriteriet &auml;r att sj&auml;len st&aring;r i harmoni med m&auml;nniskan n&auml;r det ut&ouml;vas. Under v&aring;rt tak samlas allt fr&aring;n glada amat&ouml;rer till professionella ut&ouml;vare och alla f&aring;r lika stort utrymme. &Auml;ven om konsten &auml;r vad som f&ouml;r oss samman, &auml;r det n&auml;rheten och umg&auml;nget som &auml;r v&aring;r livskraft.</p>

<p>Du beh&ouml;ver inte vara medlem f&ouml;r att ta del av den information som finns p&aring; sidan, den &auml;r fri att njuta av. F&ouml;r att ansluta sig till v&aring;r v&auml;xande familj kan du g&ouml;ra en ans&ouml;kan h&auml;r p&aring; communityn eller bes&ouml;ka en av v&aring;ra sammankomster.</p>

<p>Som communitymedlem f&aring;r du en egen sida, m&ouml;jlighet att ladda upp dina bilder, ta del av diskussioner samt m&ouml;jlighet att knyta kontakter landet runt. Som f&ouml;reningsmedlem st&ouml;djer du aktivt v&aring;r tillv&auml;xt har fri tillg&aring;ng till alla Eldsj&auml;ls aktiviteter, hj&auml;lper till att forma hur organisationen skall fungera, f&aring;r medlemspriser hos de st&ouml;rsta butikerna f&ouml;r alternativkonst samt blir f&ouml;rs&auml;krad vid aktiviter r&ouml;rande Eldsj&auml;l.</p>

<p>Mycket n&ouml;je! // Eldsj&auml;l crew</p>

<?php echo widget::run('news'); ?>
<?php echo widget::run('latestforum'); ?>

<?php end_region(); ?>

<?php require('layout.php'); ?>