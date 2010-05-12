<?php region('content'); ?>
<p>Kul att du vill vara med! :) För att det inte ska sluta med gråt så är det väldigt viktigt att du vet om vad du ger dig in i. Eldsjäl är inte en klassisk förening med träningar osv, vi är en hög med människor som gillar att göra saker ihop. Ingen kommer att ta ansvar för dig, så du måste kunna ta hand om dig själv om du ska hänga på. Medelåldern hos oss är 20-25 år.</p>

<p>Det här skriver vi inte för att avskräcka dig, utan för att se till så att du inte hamnar i situationer du inte kan hantera. Om du känner dig tveksam till om du är tillräckligt mogen så är du troligtvis inte det.</p>
	
<p>För att bli medlem måste du ha en fungerande emailadress, så därför börjar vi med den. Efter du har skickat formuläret nedan så kommer du att få ett mail med instruktioner om hur du fortsätter.</p>
<?php 
echo form_open('/register')
.input('text', 'email', 'Din emailadress')
.submit('Kom igen!')
.form_close();
?>
<?php end_region(); ?>

<?php require('layout.php'); ?>