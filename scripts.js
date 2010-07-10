// För Google Analytics
_uacct = "UA-201570-2";
urchinTracker();

// Callback-funktion för datan från /json/keepalive
function handleKeepalive(data) {
	for(var counterName in data.alerts) {
		setAlertCounter(counterName, data.alerts[counterName]);
	}
}

function setAlertCounter(counter, value) {
	$('#alert-counter-'+counter).text('('+value+')');
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
	
	if($('.autocomplete.tags').size() > 0) {
		var a = [];
		var options = { 
			serviceUrl:'/json/tagsearch/', 
			delimiter:','
		};
		jQuery.getScript('/jquery.autocomplete-min.js', function(data) {
			$('.autocomplete.tags').each(function(i, input) {
				a[i] = $(input).autocomplete(options);
			});
		});
	}
});