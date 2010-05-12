// Keepalive-funktionen
window.setInterval("jQuery.get('/json/keepalive/'+Math.random())", 5 * 60 * 1000);

$(function() {
	// Gör så att datepickern döljs/visas beroende på om den behövs eller inte. Först när sidan laddas...
	if(!$('input[name=is_event]').is(':checked')) {
		$('.datepicker').hide();
	}
	// ...och sedan när checkboxen ändras.
	$('input[name=is_event]').change(function() {
		$('.datepicker').slideToggle('quick');
	});
});