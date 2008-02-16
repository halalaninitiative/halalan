
function restore_state(checkboxes) {
	checkboxes = checkboxes.split(",");
	$(":checkbox").filter(function(idx) {return in_array(idx, checkboxes)}).attr("disabled", true);
}

function in_array(needle, haystack) {
	for(var i = 0; i < haystack.length; i++) {
		if(haystack[i] == needle)
			return true;
	}
	return false;
}

function check_cookie() {
	var checkboxes = $.cookie('halalan_cookie');
	if (checkboxes != null && checkboxes != "")
		restore_state(checkboxes);
}

/* jQuery event handlers */
function change_election_status() {
	var result = $("tr.result");
	var buttons = $(":radio[name=result]");

	if ($(this).val() == "1") {
		result.fadeTo(250, 0.5)
		buttons.attr("disabled", true);
	} else {
		result.fadeTo(250, 1.0);
		buttons.attr("disabled", false);
	}
}

function confirm_delete() {
	var edit_url = $(this).attr("href").replace('delete', 'edit');
	var name = $("a[href='" + edit_url + "'][title!=Edit]").text();
	return confirm('Are you sure you want to delete ' + name + '?\nWarning: This action cannot be undone!');
}

function abstain_position() {
	var name = $(this).attr("name");
	$(":checkbox[name='" + name + "'][value!='']").attr("disabled", this.checked);
}

function save_state() {
	var inputs = $(":checkbox")
	var checkboxes = new Array();
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].disabled == true)
			checkboxes.push(i);
	}
	$.cookie('halalan_cookie', checkboxes.toString(), {expires: 1, path: '/'});
}

function check_number() {
	var name = $(this).attr("name");
	var limit = $(":hidden[name='max_" + name + "']").val();
	var inputs = $(":checkbox:checked[name='" + name + "']");

	if(inputs.length > limit) {
		this.checked = false;
		alert("You are over the allowed limit");
	}
}

function select_chosen() {
	$("#chosen").children().attr("selected", true);
}

function copy_selected() {
	var from = ($(this).val() == "  >>  ") ? $("#possible") : $("#chosen");
	var to = ($(this).val() == "  >>  ") ? $("#chosen") : $("#possible");
	var selected = from.children(":selected");

	if (!selected.length)
		alert ('You haven\'t selected any options!');

	to.append(selected);
	selected.attr("selected", false);
}

function toggle_details() {
	/*
		<tr> parent
		<td> parent
		<img /> this
		</td>
		</tr>
		<tr> next
		<td> children(0)
		<div></div> children(0)
		</td>
		</tr>
	*/
	$(this).parent().parent().next().children(0).children(0).slideToggle('slow');
}

$(document).ready(function() {
	/* Bind handlers to events */
	$("a.confirm_delete").click(confirm_delete);
	$("input.change_election_status").click(change_election_status);
	$("input.check_number").click(check_number);
	$("input.abstain_position").click(abstain_position);
	$("input.copy_selected").click(copy_selected);
	$("form.save_state").submit(save_state);
	$("form.select_chosen").submit(select_chosen);
	$("img.toggle_details").click(toggle_details);
	/* Init */
	if ($("input[type=radio][name=status][value=1]").attr("checked")) {
		$("input[type=radio][name=status][value=1]").click();
	}
});
