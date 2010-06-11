// För Google Analytics
_uacct = "UA-201570-2";
urchinTracker();

// Callback-funktion för datan från /json/keepalive
function handleKeepalive(data) {
	for(var i in data.alerts) {
		$('#alert-counter-'+i).text('('+data.alerts[i]+')');
	}
}

// Allmän jQuery-mayhem! \:D/
$(function() {
	// Keepalive-funktionen
	if(appData.isLoggedIn) {
		window.setInterval("jQuery.getJSON('/json/keepalive/'+Math.random(), function(data) { handleKeepalive(data); })", 5 * 60 * 1000);
	}
	
	// Gör så att datepickern döljs/visas beroende på om den behövs eller inte. Först när sidan laddas...
	if(!$('input[name=is_event]').is(':checked')) {
		$('.datepicker').hide();
	}
	// ...och sedan när checkboxen ändras.
	$('input[name=is_event]').change(function() {
		$('.datepicker').slideToggle('quick');
	});
});