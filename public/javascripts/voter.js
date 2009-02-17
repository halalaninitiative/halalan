
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

	var limit = $(this).parents('table').siblings('h2').text().split('(')[1].replace(')', '');
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
	window.open("print_votes");
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
	menu_map['vote'] = "VOTE";
	menu_map['verify'] = "VERIFY";
	menu_map['logout'] = "LOG OUT";
	menu_map['votes'] = "VOTES";

	/* Bind handlers to events */
	$('img.toggleDetails').click(toggleDetails);
	$(':checkbox.checkNumber').click(checkNumber);
	$(':checkbox.abstainPosition').click(abstainPosition);
	$(':button.modifyBallot').click(modifyBallot);
	$(':button.printVotes').click(printVotes);
	$('.confirmLogout').click(confirmLogout);
	/* Restore the state of abstained positions */
	$(':checkbox.abstainPosition:checked').click().attr('checked', true);
	$(':checked').parents('tr').addClass('selected');
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
});
