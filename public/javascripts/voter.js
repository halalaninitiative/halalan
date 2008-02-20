
/* jQuery event handlers */
function abstainPosition() {
	$(this).parents("tr").siblings().find(":checkbox").attr("disabled", this.checked);
}

function checkNumber() {
	if (this.disabled)
		return;
	var limit = $(this).parents("table").siblings("h2").text().split('(')[1].replace(')', '');
	var inputs = $(this).parents("tr").siblings().find(":checked");

	if (inputs.length >= limit) {
		this.checked = false;
		alert("You are over the allowed limit");
	}
}

$(document).ready(function() {
	/* Bind handlers to events */
	$("a.toggleDetails").click(toggleDetails);
	$(":checkbox.checkNumber").click(checkNumber);
	$(":checkbox.abstainPosition").click(abstainPosition);
	/* Restore the state of abstained positions */
	$(":checkbox.abstainPosition:checked").click().attr("checked", true);
	/* Highlight menu item of active view */
	highlightMenuItem();
});
