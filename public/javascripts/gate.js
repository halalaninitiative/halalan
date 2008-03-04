
/* DOM is ready */
$(document).ready(function () {
	var menu_map = {};
	menu_map['results'] = "RESULTS";
	menu_map['statistics'] = "STATISTICS";

	/* Bind handlers to events */
	$('img.toggleDetails').click(toggleDetails);
	/* Code that aren't bound to events */
	animateFlashMessage();
	highlightMenuItem(menu_map);
});
