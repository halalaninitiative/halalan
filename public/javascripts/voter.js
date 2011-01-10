
/* jQuery event handlers */

function abstainPosition() {
	var tr = $(this).parents('tr');

	tr.siblings().find('input:checkbox').attr('disabled', this.checked);
	tr.toggleClass('selected', this.checked);
	tr.siblings().has('input:checked').toggleClass('selected', !this.checked);
}

function checkNumber() {
	if (this.disabled) {
		return;
	}

	var l = $(this).parents('table').siblings('h2').text().split('(');
	var limit = l[l.length - 1].replace(')', '');
	var inputs = $(this).parents('tr').siblings().find('input:checked');

	if (inputs.length >= limit) {
		this.checked = false;
		alert("You have already selected the maximum\nnumber of candidates for this position.");
	} else {
		$(this).parents('tr').toggleClass('selected', this.checked);
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

function triggerCheckbox(e) {
	/* Trigger for all TDs except for the one containing the toggle image */
	if (e.target.nodeName == 'TD' && !$(e.target).children('img').length) {
		var cb = $(this).find('input:checkbox');
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
	$('img.toggleDetails').click(toggleDetails);
	$('input:checkbox.checkNumber').click(checkNumber);
	$('input:checkbox.abstainPosition').click(abstainPosition);
	$('input:button.modifyBallot').click(modifyBallot);
	$('input:button.printVotes').click(printVotes);
	$('input:button.downloadVotes').click(downloadVotes);
	$('a.confirmLogout').click(confirmLogout);
	$('tr.triggerCheckbox').click(triggerCheckbox);
	/* Restore the state of abstained positions */
	$('input:checked.abstainPosition').click().attr('checked', true);
	$('input:checked').parents('tr').addClass('selected');
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
});
