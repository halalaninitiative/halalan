
/* jQuery event handlers */

function abstainPosition() {
	var tr = $(this).parents('tr');

	tr.siblings().find(':checkbox').attr('disabled', this.checked);
	tr.toggleClass('selected', this.checked);
	tr.siblings().find(':checked').parents('tr').toggleClass('selected', !this.checked);
}

/* Some very inelegant code here. Should be changed. */
function abstainPos1() {

	$(".pos1").parents('tr').find(':checkbox').attr('disabled', this.checked);
	$(".pos1").parents('tr').find(':checked').parents('tr').toggleClass('selected', !this.checked);
	$(".pos1").parents('tr').find(':checked').parents('tr').toggleClass('disabled');
	$(this).parents('tr').toggleClass('selected', this.checked);

}

function abstainPos2() {

	$(".pos2").parents('tr').find(':checkbox').attr('disabled', this.checked);
	$(".pos2").parents('tr').find(':checked').parents('tr').toggleClass('selected', !this.checked);
	$(this).parents('tr').toggleClass('selected', this.checked);

}

function abstainPos3() {

	$(".pos3").parents('tr').find(':checkbox').attr('disabled', this.checked);
	$(".pos3").parents('tr').find(':checked').parents('tr').toggleClass('selected', !this.checked);
	$(this).parents('tr').toggleClass('selected', this.checked);

}

function checkNumber_pos1() {
	if (this.disabled) {
		return;
	}
	
	var l = $(this).parents('table').siblings('h2').text().split('(');
	var limit = l[l.length-1].replace(')', '');
	var inputs = $(".pos1").parents('td').find(':checked');

	if (inputs.length > limit) {
		this.checked = false;
		alert("You have already selected the maximum\nnumber of candidates for this position.");
	} else {
		$(this).parents('tr').toggleClass('selected', this.checked);
	}
}

function checkNumber_pos2(){
	if (this.disabled) {
		return;
	}
	
	var l = $(this).parents('table').siblings('h2').text().split('(');
	var limit = l[l.length-1].replace(')', '');
	var inputs = $(".pos2").parents('td').find(':checked');

	if (inputs.length > limit) {
		this.checked = false;
		alert("You have already selected the maximum\nnumber of candidates for this position.");
	} else {
		$(this).parents('tr').toggleClass('selected', this.checked);
	}
}

function checkNumber_pos3(){
	if (this.disabled) {
		return;
	}
	
	var l = $(this).parents('table').siblings('h2').text().split('(');
	var limit = l[l.length-1].replace(')', '');
	var inputs = $(".pos3").parents('td').find(':checked');

	if (inputs.length > limit) {
		this.checked = false;
		alert("You have already selected the maximum\nnumber of candidates for this position.");
	} else {
		$(this).parents('tr').toggleClass('selected', this.checked);
	}
}
/* End inelegant code. */


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

	/* Very inelegant code */
	$(':checkbox.pos1').click(checkNumber_pos1);
	$(':checkbox.pos2').click(checkNumber_pos2);
	$(':checkbox.pos3').click(checkNumber_pos3);
	$(':checkbox.abs_pos1').click(abstainPos1);
	$(':checkbox.abs_pos2').click(abstainPos2);
	$(':checkbox.abs_pos3').click(abstainPos3);
	/* End Very inelegant code */	
		
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
