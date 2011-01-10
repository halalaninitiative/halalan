function hashPassword() {
	var passwd = $('#password');
	if (passwd.attr('value').length > 0) {
		passwd.attr({
			'maxlength': '40',
			'value': hex_sha1(passwd.attr('value'))
		});
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
	$('table.delegateEvents').click(function(e) {
		if (e.target.nodeName == 'IMG')
			toggleDetails(e.target);
	});
	$('a.toggleOptions').click(toggleOptions);
	$('a.toggleAllElections').click(toggleAllElections);
	$('form.hashPassword').submit(hashPassword);
	/* Trigger events on load */
	$('a.toggleOptions').click();
	/* Code that aren't bound to events */
	animateFlashMessage();
	highlightMenuItem(menu_map);
});
