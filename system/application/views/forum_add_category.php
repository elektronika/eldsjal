<?php region('content'); ?>
<form method="post">
<?php
echo input('text', 'title', 'Kategorinamn').submit();
?>
</form>
<?php end_region(); ?>

<?php require('layout.php'); ?>