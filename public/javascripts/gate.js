function hashPassword() {
	if ($('#password').attr('value').length > 0) {
		$('#password').attr('maxlength', '40');
		$('#password').attr('value', hex_sha1($('#password').attr('value')));
	}
}

function toggleOptions() {
	if ($(this).text() == "[hide options]") {
		$(this).text("[show options]");
		$('form').fadeOut();
	} else {
		$(this).text("[hide options]");
		$('form').fadeIn();
	}
	return false;
}

function toggleAllElections() {
	var cboxes = $('form').find('input:checkbox');
	cboxes.attr('checked', ($(this).text() === "select all"));
	return false;
}

/* DOM is ready */
$(document).ready(function () {
	var menu_map = {};
	menu_map['results'] = "RESULTS";
	menu_map['statistics'] = "STATISTICS";

	/* Bind handlers to events */
	$('img.toggleDetails').click(toggleDetails);
	$('a.toggleOptions').click(toggleOptions);
	$('a.toggleAllElections').click(toggleAllElections);
	$('form.hashPassword').submit(hashPassword);
	/* Trigger events on load */
	$('a.toggleOptions').click();
	/* Code that aren't bound to events */
	animateFlashMessage();
	highlightMenuItem(menu_map);
});
