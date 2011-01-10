
/* jQuery event handlers */

function abstainPosition(target) {
	var tr = $(target).parents('tr');

	tr.siblings().find('input:checkbox').attr('disabled', target.checked);
	tr.toggleClass('selected', target.checked);
	tr.siblings().has('input:checked').toggleClass('selected', !target.checked);
}

function checkNumber(target) {
	if (target.disabled) {
		return;
	}

	var l = $(target).parents('table').siblings('h2').text().split('(');
	var limit = l[l.length - 1].replace(')', '');
	var inputs = $(target).parents('tr').siblings().find('input:checked');

	if (inputs.length >= limit) {
		target.checked = false;
		alert("You have already selected the maximum\nnumber of candidates for this position.");
	} else {
		$(target).parents('tr').toggleClass('selected', target.checked);
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
				abstainPosition(e.target);
			break;
		case 'TD':
			triggerCheckbox(e.target);
			break;
		case 'IMG':
			toggleDetails(e.target);
		}
	});
	$('input:button.modifyBallot').click(modifyBallot);
	$('input:button.printVotes').click(printVotes);
	$('input:button.downloadVotes').click(downloadVotes);
	$('a.confirmLogout').click(confirmLogout);
	/* Restore the state of abstained positions */
	$('input:checked.abstainPosition').click().attr('checked', true);
	$('input:checked').parents('tr').addClass('selected');
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
});
