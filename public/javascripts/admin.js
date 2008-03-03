
/* jQuery event handlers */

function changeElectionStatus() {
	var result = $('tr.result');
	var buttons = $(':radio[name=result]');

	if ($(this).val() === "1") {
		result.fadeTo(250, 0.5);
		buttons.attr('disabled', true);
	} else {
		result.fadeTo(250, 1.0);
		buttons.removeAttr('disabled');
	}
}

function confirmDelete() {
	var name = $(this).parent().siblings().eq(1).children().text();

	return confirm("Are you sure you want to delete " + name + "?\nWarning: This action cannot be undone!");
}

function selectChosen() {
	$('#chosen').children().attr('selected', true);
}

function copySelected() {
	var from;
	var to;
	var selected;
	
	if ($(this).val() === "  >>  ") {
		from = $('#possible');
		to = $('#chosen');
	} else {
		from = $('#chosen');
		to = $('#possible');
	}
	
	selected = from.children(':selected');

	if (!selected.length) {
		alert("No positions selected.");
	} else {
		to.append(selected);
		selected.removeAttr('selected');
	}
}

function manipulateAllPositions() {
	var img = $('img.togglePosition');
	var src = img.attr('src');
	var alt;

	if ($(this).text() === "expand all") {
		alt = "Collapse";
		src = src.replace("plus", "minus");
		img.siblings('span').hide();
		$('table.table').show();
		$('div.content_right').show();
	} else {
		alt = "Expand";
		src = src.replace("minus", "plus");
		img.siblings('span').show();
		$('table.table').hide();
		$('div.content_right').hide();
	}

	img.attr('src', src).attr('alt', alt).attr('title', alt);

	return false;
}

function togglePosition() {
	var idx = $('img.togglePosition').index(this);
	var src = $(this).attr('src');
	var alt = $(this).attr('alt');

	if (alt === "Expand") {
		alt = "Collapse";
		src = src.replace("plus", "minus");
	} else {
		alt = "Expand";
		src = src.replace("minus", "plus");
	}

	$(this).siblings('span').toggle();
	$('table.table').eq(idx).toggle();
	$('div.content_right').eq(idx).toggle();
	$(this).attr('src', src).attr('alt', alt).attr('title', alt);

	return false;
}

/* DOM is ready */
$(document).ready(function () {
	/* Bind handlers to events */
	$('a.confirmDelete').click(confirmDelete);
	$('a.manipulateAllPositions').click(manipulateAllPositions);
	$('img.togglePosition').click(togglePosition);
	$(':radio.changeElectionStatus').click(changeElectionStatus);
	$(':button.copySelected').click(copySelected);
	$('form.selectChosen').submit(selectChosen);
	/* Disable Result radio buttons if election is already running */
	$(':radio.changeElectionStatus[value=1]:checked').click();
	/* Collapse all */
	$('a.manipulateAllPositions[text="collapse all"]').click();
	/* Code that aren't bound to events */
	highlightMenuItem();
	animateFlashMessage();
	/* Remove blank select option */
	$('#possible, #chosen').children('[value=""]').remove();
});
