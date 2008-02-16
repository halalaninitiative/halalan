
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

$(document).ready(function() {
	/* Bind handlers to events */
	$("a.confirm_delete").click(confirm_delete);
	$("input.change_election_status").click(change_election_status);
	$("input.copy_selected").click(copy_selected);
	$("form.select_chosen").submit(select_chosen);
	/* Init */
	if ($(":radio[name=status][value=1]").attr("checked")) {
		$(":radio[name=status][value=1]").click();
	}
});
