
/* jQuery event handlers */

function abstainPosition() {
	var tr = $(this).parents('tr');

	tr.siblings().find(':checkbox').attr('disabled', this.checked);
	tr.toggleClass('selected', this.checked);
	tr.siblings().find(':checked').parents('tr').toggleClass('selected', !this.checked);
}

function checkNumber() {
	if (this.disabled) {
		return;
	}

	var l = $(this).parents('table').siblings('h2').text().split('(');
	var limit = l[l.length-1].replace(')', '');
	var inputs = $(this).parents('tr').siblings().find(':checked');

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

/* DOM is ready */
$(document).ready(function () {
	var menu_map = {};
	menu_map['verify'] = "VERIFY";
	menu_map['logout'] = "LOG OUT";
	/* always last since this can match with anything since the url has a 'vote' string */
	menu_map['vote'] = "VOTE";

	/* Bind handlers to events */
	$('img.toggleDetails').click(toggleDetails);
	$(':checkbox.checkNumber').click(checkNumber);
	$(':checkbox.abstainPosition').click(abstainPosition);
	$(':button.modifyBallot').click(modifyBallot);
	$(':button.printVotes').click(printVotes);
	$(':button.downloadVotes').click(downloadVotes);
	$('.confirmLogout').click(confirmLogout);
	/* Restore the state of abstained positions */
	$(':checkbox.abstainPosition:checked').click().attr('checked', true);
	$(':checked').parents('tr').addClass('selected');
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
});
