
/* jQuery event handlers */
function changeElectionStatus() {
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

function confirmDelete() {
	var name = $(this).parent().siblings().eq(1).children().text();

	return confirm('Are you sure you want to delete ' + name + '?\nWarning: This action cannot be undone!');
}

function selectChosen() {
	$("#chosen").children().attr("selected", true);
}

function copySelected() {
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

function manipulateAllPositions() {
	var action = ($(this).text() == "expand all") ? "expand" : "collapse";
	var img = $("img.togglePosition");
	var src = img.attr("src");
	var alt = (action == "expand") ? "Collapse" : "Expand";

	if (action == "expand") {
		src = src.replace("plus", "minus");
		img.siblings("span").hide();
		$("table.table").show();
		$("div.content_right").show();
	} else {
		src = src.replace("minus", "plus");
		img.siblings("span").show();
		$("table.table").hide();
		$("div.content_right").hide();
	}
	img.attr("src", src).attr("alt", alt).attr("title", alt);

	return false;
}

function togglePosition() {
	var idx = $("img.togglePosition").index(this);
	var src = $(this).attr("src");
	var alt = $(this).attr("alt");

	src = (alt == "Collapse") ? src.replace("minus", "plus") : src.replace("plus", "minus");
	alt = (alt == "Collapse") ? "Expand" : "Collapse";
	$(this).attr("src", src).attr("alt", alt).attr("title", alt);
	$(this).siblings("span").toggle();
	$("table.table").eq(idx).toggle();
	$("div.content_right").eq(idx).toggle();

	return false;
}

$(document).ready(function() {
	/* Bind handlers to events */
	$("a.confirmDelete").click(confirmDelete);
	$("a.manipulateAllPositions").click(manipulateAllPositions);
	$("img.togglePosition").click(togglePosition);
	$(":radio.changeElectionStatus").click(changeElectionStatus);
	$(":button.copySelected").click(copySelected);
	$("form.selectChosen").submit(selectChosen);
	/* Disable Result radio buttons if election is already running */
	$(":radio.changeElectionStatus[value=1]:checked").click();
	/* Collapse all */
	$("a.manipulateAllPositions[text='collapse all']").click();
	/* Highlight menu item of active view */
	highlightMenuItem();
	animateFlashMessage();
});
