
/* DOM is ready */
$(document).ready(function () {
	/* Bind handlers to events */
	$('img.toggleDetails').click(toggleDetails);
	/* Code that aren't bound to events */
	animateFlashMessage();
	highlightMenuItem();
});
