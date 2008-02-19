
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
	var name = $(this).parent().siblings().eq(1).children().text();

	return confirm('Are you sure you want to delete ' + name + '?\nWarning: This action cannot be undone!');
}

function select_chosen() {
	$("#chosen").children().attr("selected", true);
}

function copy_selected() {
	var val = $(this).val();
	var from = (val == "  >>  ") ? $("#possible") : $("#chosen");
	var to = (val == "  >>  ") ? $("#chosen") : $("#possible");
	var selected = from.children(":selected");

	if (!selected.length) {
		alert("You haven't selected any options!");
	} else {
		to.append(selected);
		selected.attr("selected", false);
	}
}

function manipulate_all_positions() {
	var action = ($(this).text() == "expand all") ? "expand" : "collapse";
	var img = $("img.toggle_position");
	var src = img.attr("src");
	var alt = (action == "expand") ? "Collapse" : "Expand";

	if (action == "expand") {
		src = src.replace("plus.png", "minus.png");
		$("table.table").show();
		$("div.content_right").show();
	} else {
		src = src.replace("minus.png", "plus.png");
		$("table.table").hide();
		$("div.content_right").hide();
	}
	img.attr("src", src).attr("alt", alt);

	return false;
}

function toggle_position() {
	var idx = $("img.toggle_position").index(this);
	var src = $(this).attr("src");
	var alt = $(this).attr("alt");

	src = (alt == "Collapse") ? src.replace("minus.png", "plus.png") : src.replace("plus.png", "minus.png");
	alt = (alt == "Collapse") ? "Expand" : "Collapse";
	$(this).attr("src", src).attr("alt", alt);
	$("table.table").eq(idx).toggle();
	$("div.content_right").eq(idx).toggle();

	return false;
}

$(document).ready(function() {
	/* Bind handlers to events */
	$("a.confirm_delete").click(confirm_delete);
	$("a.manipulate_all_positions").click(manipulate_all_positions);
	$("img.toggle_position").click(toggle_position);
	$("input.change_election_status").click(change_election_status);
	$("input.copy_selected").click(copy_selected);
	$("form.select_chosen").submit(select_chosen);
	/* Init */
	if ($(":radio[name=status][value=1]").attr("checked")) {
		$(":radio[name=status][value=1]").click();
	}
	/* Collapse all */
	$("a.manipulate_all_positions[text='collapse all']").click();
	var url = window.location.href.replace("import", "voters").replace("export", "voters");
	/* Highlight menu item of active view */
	$("#menu ul li a[href=" + url + "]").css("background", "#4179F3");
});
