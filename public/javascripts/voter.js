
/* jQuery event handlers */

function abstainPosition() {
	$(this).parents('tr').siblings().find(':checkbox').attr('disabled', this.checked);
}

function checkNumber() {
	if (this.disabled) {
		return;
	}

	var limit = $(this).parents('table').siblings('h2').text().split('(')[1].replace(')', '');
	var inputs = $(this).parents('tr').siblings().find(':checked');

	if (inputs.length >= limit) {
		this.checked = false;
		alert("Maximum selections already reached.");
	}
}

function modifyBallot() {
	window.location = "vote";
}

function printVotes() {
	window.open("print_votes");
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
	/* Restore the state of abstained positions */
	$(':checkbox.abstainPosition:checked').click().attr('checked', true);
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
});
