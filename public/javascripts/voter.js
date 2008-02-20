
function inArray(needle, haystack) {
	for (var i = 0; i < haystack.length; i++) {
		if (haystack[i] == needle)
			return true;
	}
	return false;
}

function restoreState(checkboxes) {
	checkboxes = checkboxes.split(",");
	$(":checkbox").filter(function(idx) {return inArray(idx, checkboxes)}).attr("disabled", true);
}

function checkCookie() {
	var checkboxes = $.cookie('halalan_cookie');
	if (checkboxes != null && checkboxes != "")
		restoreState(checkboxes);
}

/* jQuery event handlers */
function abstainPosition() {
	$(this).parents("tr").siblings().find(":checkbox").attr("disabled", this.checked);
}

function saveState() {
	var inputs = $(":checkbox");
	var checkboxes = new Array();
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].disabled == true)
			checkboxes.push(i);
	}
	$.cookie('halalan_cookie', checkboxes.toString(), {expires: 1, path: '/'});
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
	$("input.checkNumber").click(checkNumber);
	$("input.abstainPosition").click(abstainPosition);
	$("form.saveState").submit(saveState);
	/* Highlight menu item of active view */
	highlightMenuItem();
});
