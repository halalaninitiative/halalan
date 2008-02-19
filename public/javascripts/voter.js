
function in_array(needle, haystack) {
	for (var i = 0; i < haystack.length; i++) {
		if (haystack[i] == needle)
			return true;
	}
	return false;
}

function restore_state(checkboxes) {
	checkboxes = checkboxes.split(",");
	$(":checkbox").filter(function(idx) {return in_array(idx, checkboxes)}).attr("disabled", true);
}

function check_cookie() {
	var checkboxes = $.cookie('halalan_cookie');
	if (checkboxes != null && checkboxes != "")
		restore_state(checkboxes);
}

/* jQuery event handlers */
function abstain_position() {
	$(this).parents("tr").siblings().find(":checkbox").attr("disabled", this.checked);
}

function save_state() {
	var inputs = $(":checkbox");
	var checkboxes = new Array();
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].disabled == true)
			checkboxes.push(i);
	}
	$.cookie('halalan_cookie', checkboxes.toString(), {expires: 1, path: '/'});
}

function check_number() {
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
	$("a.toggle_details").click(toggle_details);
	$("input.check_number").click(check_number);
	$("input.abstain_position").click(abstain_position);
	$("form.save_state").submit(save_state);
	/* Highlight menu item of active view */
	var title = $("title").text().split('-')[2].replace(' ', '').toUpperCase().replace(' ', '');
	$("li").filter(function () {return $(this).text().replace(' ', '') == title;}).css("background", "#4179F3");
});
