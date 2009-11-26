window.setInterval("jQuery.getJSON('/json/keepalive?'+Math.random())", 60 * 1000);
 
function trim(str, chars) {
	return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function overlay() {
	if($('#overlay').length < 1) {
		$('body').prepend('<div id="overlay"></div>');
	}
	return $('#overlay');
}

function modal() {
	if($('#modal').length < 1) {
		$('body').prepend('<div id="modal"></div>');
	}
	return $('#modal');
}

function resizeImage() {
	containerHeight = modal().height() - 100; // För att kunna visa en rad med text nedanför, line-height är 20px.
	imageHeight = $('#image').height();
	containerWidth = modal().width();
	imageWidth = $('#image').width();
	
	// if(imageHeight < containerHeight && imageWidth < containerWidth) {
	// 	leftMargin = (containerWidth - imageWidth) / 2;
	// 	topMargin = (containerHeight - imageHeight) / 2;
	// 	// $('#image').css({'margin-top':topMargin, 'margin-left':leftMargin});
	// } else {
		$('#image img').css('height', containerHeight);

		imageWidth = $('#image img').width();		
		leftMargin = (containerWidth - imageWidth) / 2 - 5;
		// $('#image-border').css({'margin-left':leftMargin, width:(imageWidth + 7)});
		$('#modal').css({'margin-left':leftMargin, width:(imageWidth + 20)});
	// }
}

$(document).ready(function() {
	(function($) {
		$.fn.hoverIntent = function(f,g) {
			// default configuration options
			var cfg = {
				sensitivity: 7,
				interval: 100,
				timeout: 0
			};
			// override configuration options with user supplied object
			cfg = $.extend(cfg, g ? { over: f, out: g } : f );

			// instantiate variables
			// cX, cY = current X and Y position of mouse, updated by mousemove event
			// pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
			var cX, cY, pX, pY;

			// A private function for getting mouse position
			var track = function(ev) {
				cX = ev.pageX;
				cY = ev.pageY;
			};

			// A private function for comparing current and previous mouse position
			var compare = function(ev,ob) {
				ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
				// compare mouse positions to see if they've crossed the threshold
				if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
					$(ob).unbind("mousemove",track);
					// set hoverIntent state to true (so mouseOut can be called)
					ob.hoverIntent_s = 1;
					return cfg.over.apply(ob,[ev]);
				} else {
					// set previous coordinates for next time
					pX = cX; pY = cY;
					// use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
					ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
				}
			};

			// A private function for delaying the mouseOut function
			var delay = function(ev,ob) {
				ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
				ob.hoverIntent_s = 0;
				return cfg.out.apply(ob,[ev]);
			};

			// A private function for handling mouse 'hovering'
			var handleHover = function(e) {
				// next three lines copied from jQuery.hover, ignore children onMouseOver/onMouseOut
				var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget;
				while ( p && p != this ) { try { p = p.parentNode; } catch(e) { p = this; } }
				if ( p == this ) { return false; }

				// copy objects to be passed into t (required for event object to be passed in IE)
				var ev = jQuery.extend({},e);
				var ob = this;

				// cancel hoverIntent timer if it exists
				if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

				// else e.type == "onmouseover"
				if (e.type == "mouseover") {
					// set "previous" X and Y position based on initial entry point
					pX = ev.pageX; pY = ev.pageY;
					// update "current" X and Y position based on mousemove
					$(ob).bind("mousemove",track);
					// start polling interval (self-calling timeout) to compare mouse coordinates over time
					if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

				// else e.type == "onmouseout"
				} else {
					// unbind expensive mousemove event
					$(ob).unbind("mousemove",track);
					// if hoverIntent state is true, then call the mouseOut function after the specified delay
					if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
				}
			};

			// bind the function to the two event listeners
			return this.mouseover(handleHover).mouseout(handleHover);
		};
	})(jQuery);
	
	jQuery.getScript('/beta/jquery-ui-1.7.2.custom.min.js', function() {
		$('#form-item-date-show').datepicker({
			altField: '#form-item-date',
			altFormat: '@'
		});
	});
	/*
		Returns an array of strings with the elements classes.
	*/
	jQuery.fn.getClasses = function() {
		return jQuery(this).attr('class').split(' ');
	};
	
	jQuery.fn.baloon = function() {
		if($('#baloon').length > 0) {
			$('#baloon').remove();
		}
		var baloon = '<div id="baloon"><div id="baloon-tip">&nbsp;</div><div id="baloon-content"></div></div>';
		$('body').append(baloon);
		
		$('#baloon').data('offset', $(this).offset());
		$('#baloon').data('parentWidth', $(this).width());
		$('#baloon').data('parentHeight', $(this).height());

		$('#baloon').bind('show', function() {
			var baloonWidth = $(this).width();
			var baloonHeight = $(this).height();
			var left = $(this).data('offset').left - (baloonWidth - $(this).data('parentWidth')) / 2;
			var top = $(this).data('offset').top + $(this).data('parentHeight') + 7;
			if($(window).height() - top < baloonHeight) {
				$(this).addClass('baloon-top');
				top = top - baloonHeight - 35 - $(this).data('parentHeight');
			}
			$(this).css({top:top, left:left}).fadeIn('slow');
		});
		
		$('#baloon').bind('hide', function() {
			$(this).fadeOut('slow');
		});
		
		return $('#baloon-content');
	};
	
	$("a.thumbnail, #gallery-random").click(function() {
		$('body').css('overflow', 'hidden');
		overlay().fadeIn('slow');
		modal().fadeIn('slow');
		modal().load($(this).attr('href') + ' #image', function() {
			image = $('#image img').get(0);
			if(image.complete || image.readyState == 'complete') {
				$('#image').fadeIn('slow');
				resizeImage();
			} else {
				$('#image img').bind('load readystatechange', function(e) {
					if (this.complete || (this.readyState == 'complete' && e.type == 'readystatechange')) {
						$('#image').fadeIn('slow');
						resizeImage();
					}
				});
			}
		});
		return false;
	});
	
	$('#overlay').live('click', function() {
		$('body').css('overflow', 'auto');
		overlay().fadeOut('fast', function() {
			$(this).html('');
		});
		modal().fadeOut('fast', function() {
			$(this).html('').css({width: 'auto', margin: 0});
		});
	});

	$('.inbox').hoverIntent({
		sensitivity: 10,
		interval: 250,
		timeout: 500,
		over: function() {
			$(this).baloon().load('/inbox #alerts', function() {
				$(this).trigger('show');
			});
		},
		out: function() {
			$('#baloon').bind('mouseleave', function() {
				$(this).trigger('hide');
			});
		}
	});
	
	$('a.confirm').click(function() {
		var action = trim($(this).text().toLowerCase());
		var formAction = $(this).attr('href');
		$(this)
			.baloon()
			.addClass('confirm')
			.html('<form method="post" action="'+formAction+'">Är du säker på att du vill '+action+'?<br/><input type="submit" class="confirm" value="Gjört Majvor!"/> <input type="submit" class="cancel" value="Näe, skit it."/></form>')
			.trigger('show');
		$('#baloon .cancel').bind('click', function() {
			$('#baloon').trigger('hide');
			return false;
		});
		return false;
	});
	
	$('a.user').live('mouseover', function() {
		if (!$(this).data('init')) {
		  $(this).data('init', true);
			$(this).hoverIntent({
				sensitivity: 10,
				interval: 250,
				timeout: 500,
				over: function() {
					var cls = (this.className.split(' ',3)[1]).substring(1);
					$(this).baloon().load("/xml/usermenu/"+cls, function() {
						$(this).trigger('show');
					})
				},
				out: function() {
					$('#baloon').bind('mouseleave', function() {
						$(this).trigger('hide');
					});
				}
			});
			$(this).trigger('mouseover');
		}		
	});
	
	$('.usermenu a.action-guestbook').live('click', function() {
		$('#baloon').unbind('mouseleave');
		var userid = $(this).closest('.usermenu').getClasses()[1].substring(1);
		$(this).closest('.usermenu').children('.usermenu-inject').load('/xml/guestbook/'+userid, function() {
			$('#baloon #form-item-cancel').live('click', function() {
				$('#baloon').trigger('hide');
				return false;
			});
			$('#baloon #form-item-save').live('click', function() {
				var formAction = $(this).closest('form').attr('action');
				var message = $(this).closest('form').children('#form-item-body').val();
				$('#baloon .usermenu-inject').load(formAction, {body: message}, function() {
					$('#baloon').bind('mouseleave', function() {
						$(this).trigger('hide');
					});
				});
				return false;
			});
		});
		return false;
	});
	
	$('.usermenu a.action-message').live('click', function() {
		$('#baloon').unbind('mouseleave');
		var userid = $(this).closest('.usermenu').getClasses()[1].substring(1);
		$(this).closest('.usermenu').children('.usermenu-inject').load('/xml/message/'+userid, function() {
			$('#baloon #form-item-cancel').live('click', function() {
				$('#baloon').trigger('hide');
				return false;
			});
			$('#baloon #form-item-save').live('click', function() {
				var formAction = $(this).closest('form').attr('action');
				var message = $(this).closest('form').children('#form-item-body').val();
				var subject = $(this).closest('form').children('#form-item-title').val();
				$('#baloon .usermenu-inject').load(formAction, {body: message, title: subject}, function() {
					$('#baloon').bind('mouseleave', function() {
						$(this).trigger('hide');
					});
				});
				return false;
			});
		});
		return false;
	});	
});







// Hejsan hoppsan hörru