DEVICE_WIDTH_BREAKPOINT = '768px';
HIDPI_BREAKPOINT = "(-webkit-min-device-pixel-ratio: 1.5),(min--moz-device-pixel-ratio: 1.5),(-o-min-device-pixel-ratio: 3/2),(min-device-pixel-ratio: 1.5),(min-resolution: 1.5dppx)";

$(document).ajaxSend(function(event, jqXHR, ajaxOptions) {
	var token = $('meta[name="csrf-token"]').attr("content");
	jqXHR.setRequestHeader("X-CSRF-Token", token);
});

// Disable links that simply trigger some JavaScript action.
$('a[href=#]').click(function(e) { e.preventDefault(); });

User = {
	loggedIn: function() {
		return $('body.logged-in').length > 0;
	},
	loggedOut: function() {
		return !this.loggedIn();
	},
	isPro: function() {
		return $('body.pro').length > 0;
	}
}

if (typeof(SHOTS) != 'undefined') {
	// Set and reveal teaser stats on shot lists
	var $works = $('#main ol.effecthubs>li');
	$(SHOTS).each(function(index, shot) {
		var shotLi = $('ol.effecthubs li#screenshot-' + shot.id);

		if (shot.rebounds_count > 0) {
			shotLi.find('.has-rebounds').html(shot.rebounds_count).closest('a').show();
		}
		else if (shot.is_rebound) {
			shotLi.find('.is-rebound').closest('a').show();
		}
		if (shot.attachments_count > 0) {
			shotLi.find('.attachments-mark').show();
		}
		if (shot.liked_by_html) { // Suggestions page only
			shotLi.find('.effecthub-img').
				append(shot.liked_by_html).	// Show liker suggesting shot
				find('em').hide();		// Hide timestamp in lieu of suggester
		}

		shotLi.find('li.views').html(shot.view_count);
		shotLi.find('li.cmnt').each(function() {
			var $commentLi = $(this);
			$commentLi.find('a').html(shot.comments_count);
			if (shot.commented_on) $commentLi.addClass('current-user-cmnt');
			if (shot.comments_since_last_view) {
				$commentLi.addClass('comments-since').find('a').attr('title', 'New comments since last viewed.');
			}
		});
		shotLi.find('li.fav').each(function() {
			var $likeLi = $(this);
			$likeLi.find('a').html(shot.likes_count);
			if (shot.liked) $likeLi.addClass('marked');
		});
		shotLi.find('.timestamp').html(shot.created_at);
	});
	$works.find('ul.tools').css({visibility: 'visible'});

	// Set shot url with params for prev/next when shot is clicked
	$works.find('.effecthub-img a').click(function() {
		this.href = this.href + SHOT_QUERY_STRING;
		if (typeof(PAGE_OFFSET) != 'undefined') {
			// Popular page additionally needs to send offset position in list
			var offset = PAGE_OFFSET + $works.index($(this).closest('li'));
			this.href = this.href + '&offset=' + offset;
		}
	});
}

initRecentActivity();

// Enable placholder attribute for all browsers

$(function(){
  $('[placeholder]').focus(function() {
  var input = $(this);
  if (input.val() == input.attr('placeholder')) {
    input.val('');
    input.removeClass('placeholder');
  }
}).blur(function() {
  var input = $(this);
  if (input.val() == '' || input.val() == input.attr('placeholder')) {
    input.addClass('placeholder');
    input.val(input.attr('placeholder'));
  }
}).blur();

$('[placeholder]').parents('form').submit(function() {
  $(this).find('[placeholder]').each(function() {
    var input = $(this);
    if (input.val() == input.attr('placeholder')) {
      input.val('');
    }
  })
});
});

/* toggle main nav in small screens */
$('#toggle-nav').click(
	function() { $('#nav li:not(#t-activity,#t-upld)').toggleClass('nav-show');
	return false;
});

/*
 * jQuery extensions
 */

// Shows the current element(s) and hides the element(s) passed or specified by selector.
jQuery.fn.showAndHide = function(elemToHide) {
	$(elemToHide).hide();
	return this.show();
}

// Returns model id parsed from element id w/ format "prefix-<id>"
jQuery.fn.modelId = function() {
	var id = $(this).attr('id');
	if (id == null) return null; // Just in case; browsers tested return empty string for missing id.

	var idParts = id.split(/[-_]/g); // Split on hyphens and underscores
	return (idParts.length > 1) ? idParts[idParts.length-1] : null;
}

/*
 * Custom libs
 */

Notify = {
	success: function(message) {
		Notify.notify('success', message);
	}, 
	warning: function(message) {
		Notify.notify('warning', message);
	},
	error: function(message) {
		Notify.notify('error', message);
	},
	alert: function(message) {
		var $alert = $('.notice-alert');
		$alert
			.find('h3')
				.html(message)
			.end()
			.find('a.close')
				.click(function() { $alert.hide(); })
			.end()
			.show();
	},
	clear: function() {
		// Also clears case where there's a redirect-style flash message
		$('.notice').hide().find('h2').text('');
	},
	notify: function(typeOfNoticeClass, message) {
		Notify.clear();
		$('.ajax.notice')
			.find('h2').text(message)
		.end()
			.find('a.close')
				.click(Notify.clear)
		.end()
			.addClass(typeOfNoticeClass)
			.show();
	}
}

$.fn.clank = function(message) {
	if (message == null) return;

	var $form = $(this).closest('form');
	$form.find('.errorExplanation').remove();
	$form.find('fieldset').removeClass('fieldWithErrors');

	message = '<div class="errorExplanation" id="errorExplanation"><h2>Clank!</h2><ul><li>' + message + '</li></ul></div>'
	$form.prepend(message);
	$form.find('fieldset').addClass('fieldWithErrors');
}

ShowAndHideControl = function(options) {
	var elemToShowAndHide = $(options['target']);
	var showTriggers = $(options['showControl']);
	var hideTriggers = $(options['hideControl']);

	showTriggers.
		click(function() {
			elemToShowAndHide.showAndHide(showTriggers);
			return false;
		});

	hideTriggers.
		click(function() {
			elemToShowAndHide.hide();
			showTriggers.show();
			return false;
		});
}

$.fn.fadeable = function(options){
	var settings = {
		target: this,
		duration: 'fast'
	};
	$.extend(settings, options)

	$(this).live('hover', function(event) {
		switch(event.type){
			case 'mouseenter':
				$(this).find(settings.target).stop().fadeTo(settings.duration, 0.8);
				break;
			case 'mouseleave':
				$(this).find(settings.target).stop().fadeTo(settings.duration, 0);
				break;
		}
	});
}

// Plugin turns a select box into a menu.
// On change, browser navigates to url specified by value of selected option.
$.fn.selectMenu = function() {
	$(this).change(function(event) {
		location.href = $(this).find(':selected').val();
		event.preventDefault();
	});
}

// Used with a results pane that displays a wait indicator during processing.
// paneContainerSelector specifies an element containing both a
// 'results-pane' and '.processing' elements to show results and status.
ResultsPane = function(paneContainerSelector) {
	$paneContainer = $(paneContainerSelector || '#main');
	var $resultsPane = $paneContainer.find('.results-pane');
	var $waitDiv = $paneContainer.find('div.processing');

	return {
		waiting: function() {
			$waitDiv.show();
			$resultsPane.css('opacity', .2);
		},
		finished: function() {
			$waitDiv.hide();
			$resultsPane.css('opacity', 1);
		},
		noResults: function(message) {
			message = message || 'None'
			$resultsPane.html('<div class="null-message"><h2>' + message + '</h2></div>');
		}
	}
}

// show screenshot info on hover
$('ol.effecthubs li div.effecthub-img').fadeable({target: 'a.effecthub-over'});

// show prev/next arrows on hover
$('ol.prevnext li a').fadeable({target: 'strong'});

// show zoom icon on thumbnail hover
$('ol.activity li div.act-shot').fadeable({target: 'strong'});
$('div.the-rebound div.effecthub-img').fadeable({target: 'a.effecthub-over'});

// show zoom icon on multi thumb hover
$('ol.multi-grid li a').fadeable({target: 'strong'});

function attachPlayerTooltipsToGroupShots() {
	$('ol.multi-grid li a.zoom').each(function() {
		var link = $(this);
		link.tipsy({
			gravity: 'n',
			html: true,
			title: function() { return link.closest('li').find('div.tipsy-player').html(); }
		});
	});
}

var Overlay = {
	init: function() {
		var $overlay = $('#overlay'); // Overlay container
		$overlay.find('button.close').live('click', Overlay.hide);
		$overlay.find('form .cancel').live('click', Overlay.hide);
		// So click away from overlay closes it
		$overlay.live('click', function(event) {
			if ($(event.target).is('#overlay'))
				Overlay.hide();
		});
	},
	show: function() {
		var $overlay = $('#overlay');
		$overlay.css('height', document.body.clientHeight+'px');
		$overlay.fadeIn();

		return false;
	},
	hide: function() {
		var $overlay = $('#overlay');
		$overlay.fadeOut(function() {
			// Load from scratch next time displayed
			$overlay.find('.display').html('<div class="processing">Loading ...</div>');
		});
		return false;
	}
}

function showOverlay(selector) {
	$(selector)
		.css("height", document.body.clientHeight)
		.fadeIn();

	return false;
}

// show/hide pixel useage help
$('#pixels-help-a').click(function() {
	$('#pixels-help').slideToggle("normal");
	return false;
})

// show/hide search in adaptive small screen mode
$('#t-search').click(function() {
	$('#dashboard').slideToggle("normal");
	return false;
})

$('[rel=tipsy]').tipsy({fade: true, gravity: 's'});

	$('a[data-hover]').hover(
	function() {
		var $link = $(this);
		$link.
			attr('data-hover-out', $link.text()).
			text($link.attr('data-hover'));
	},
	function() {
		var $link = $(this);
		$link.text($link.attr('data-hover-out'));
		$link.removeAttr('data-hover-out');
	}
);

/* Handles menu display of incoming activity and logging for views of it. */
function initRecentActivity() {
	$('#t-activity')
		.hover(function() {
			$('img.new-activity:visible').fadeOut('slow', function() {
				var url = $('#t-activity a:first-child').attr('href');
				$.post(url, {_method: 'PUT'})
			});
		})
		.find('.activity-mini a.close')
			.click(function() {
				$('#nav li ul.tabs').hide();
			});
}