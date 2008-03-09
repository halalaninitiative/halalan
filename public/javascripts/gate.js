function hashPassword() {
	$('#password').attr('maxlength', '40');
	$('#password').attr('value', hex_sha1($('#password').attr('value')));
}

/* DOM is ready */
$(document).ready(function () {
	var menu_map = {};
	menu_map['results'] = "RESULTS";
	menu_map['statistics'] = "STATISTICS";

	/* Bind handlers to events */
	$('img.toggleDetails').click(toggleDetails);
	$('form.hashPassword').submit(hashPassword);
	/* Code that aren't bound to events */
	animateFlashMessage();
	highlightMenuItem(menu_map);
});
