
/* jQuery event handlers */

function abstainPosition(target, clicked) {
	var tr = $(target).parents('tr');

	tr.siblings().find('input:checkbox').attr('disabled', target.checked).toggle(!target.checked);
	tr.toggleClass('selected', target.checked);
	tr.siblings().has('input:checked').toggleClass('selected', !target.checked);

	var ids = new Array();
	/* Get the checkbox ID and remove 'cb_' and '_abstain' to shorten it. */
	var id = $(target).attr('id').slice(3, -8);
	var alerts = $.cookie('halalan_alerts');
	if (alerts != null) {
		ids = alerts.split(',');
	}

	if (target.checked && clicked && $.inArray(id, ids) < 0) {
		alert('By selecting abstain, you\'re not voting for any candidate in this position.  If that\'s not the case, then do not select abstain.');
		ids.push(id);
		$.cookie('halalan_alerts', ids.join(','), {'path':'/'});
	}
}

function checkNumber(target) {
	if (target.disabled) {
		return;
	}

	var tr = $(target).parents('tr');
	// Get the limit for this position
	var s = tr.parents('table').siblings('h2').text().split('(');
	var limit = s[s.length - 1].replace(')', '');
	// Count the selected candidates
	var selected = tr.siblings().find('input:checked').length;

	if (selected >= limit) {
		target.checked = false;
		alert("You have already selected the maximum\nnumber of candidates for this position.");
	} else {
		tr.toggleClass('selected', target.checked);
	}
}

function modifyBallot() {
	window.location = "vote";
}

function printVotes() {
	var url = SITE_URL;
	if (url.length - 1 != url.lastIndexOf('/')) {
		url += '/';
	}
	url += 'voter/votes/print/' + $('#election_id').val();
	window.open(url);
}

function downloadVotes() {
	var url = SITE_URL;
	if (url.length - 1 != url.lastIndexOf('/')) {
		url += '/';
	}
	url += 'voter/votes/download/' + $('#election_id').val();
	window.location = url;
}

function confirmLogout() {
	var page = window.location.href.split('/').pop();
	if ('vote' == page || 'verify' == page) {
		return confirm("Your ballot has NOT been recorded yet.\nAre you sure you want to logout?");
	}
}

function triggerCheckbox(target) {
	/* Trigger for all TDs except for the one containing the toggle image */
	if (target.nodeName == 'TD' && !$(target).children('img').length) {
		var cb = $(target).siblings().find('input:checkbox');
		/*
		 * Looks hackish but this is the "only" way as of now because "clicking"
		 * a checkbox by triggering its 'click' event first executes the bound
		 * handler, i.e. checkNumber(), before toggling the 'checked' state.
		 * In the case of clicking a checkbox directly, its 'checked' state is
		 * toggled first before checkNumber() is called.
		 */
		cb.attr('checked', !cb.attr('checked'));
		cb.click();
		cb.attr('checked', !cb.attr('checked'));
	}
}

function scrollToBottom() {
	var scroll = document.body.clientHeight - window.innerHeight;
	$('html, body').animate({scrollTop: scroll}, 'normal');
	return false;
}

/* DOM is ready */
$(document).ready(function () {
	var menu_map = {};
	menu_map['verify'] = "VERIFY";
	menu_map['logout'] = "LOG OUT";
	/* always last since this can match with anything since the url has a 'vote' string */
	menu_map['vote'] = "VOTE";

	/* Bind handlers to events */
	$('table.delegateEvents').click(function(e) {
		switch (e.target.nodeName)
		{
		case 'INPUT':
			if (!$(e.target).hasClass('abstainPosition'))
				checkNumber(e.target);
			else
				abstainPosition(e.target, true);
			break;
		case 'TD':
			triggerCheckbox(e.target);
			break;
		case 'IMG':
			toggleDetails(e.target);
		}
	});
	$('a.scrollToBottom').click(scrollToBottom);
	$('input:button.modifyBallot').click(modifyBallot);
	$('input:button.printVotes').click(printVotes);
	$('input:button.downloadVotes').click(downloadVotes);
	$('a.confirmLogout').click(confirmLogout);
	/* Restore the state of abstained positions */
	$('input:checked.abstainPosition').each(function () {
		abstainPosition(this, false);
	});
	$('input:checked').parents('tr').addClass('selected');
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
});
