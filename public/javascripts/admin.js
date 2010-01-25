
/* jQuery event handlers */

function changeElectionStatus() {
	var result = $('tr.results');
	var checkbox = $('tr.results :checkbox');

	if ($(this).val() === "1") {
		result.fadeTo(250, 0.5);
		checkbox.attr('disabled', true);
	} else {
		result.fadeTo(250, 1.0);
		checkbox.removeAttr('disabled');
	}
}

function confirmDelete() {
	var name = $(this).parent().siblings().eq(1).children().text();

	return confirm("Are you sure you want to delete " + name + "?\nWarning: This action cannot be undone!");
}

function selectChosen() {
	$('#chosen').children().attr('selected', true);
	$('#chosen_elections').children().attr('selected', true);
	$('#general_positions').attr('disabled', false);
	$('#general_positions').children().attr('selected', true);
}

function copySelectedWithAjax() {
	var from;
	var to;
	var selected;
	var array = new Array();
	var direction = $(this).val();
	
	if (direction === "  >>  ") {
		from = $('#possible_elections');
		to = $('#chosen_elections');
	} else {
		from = $('#chosen_elections');
		to = $('#possible_elections');
	}
	
	selected = from.children(':selected');

	if (!selected.length) {
		alert("No items selected.");
	} else {
		to.append(selected);
		selected.removeAttr('selected');
		selected.each(function(i){ array[i] = this.value; });
		$.ajax({
			type: "POST",
			url: window.location.href,
			data: "election_ids=" + JSON.stringify(array),
			success: function(msg){
				var msg = JSON.parse(msg);
				var general_values = msg[0];
				var general_texts = msg[1];
				var specific_values = msg[2];
				var specific_texts = msg[3];
				$('#notice').hide();
				for (i = 0; i < general_texts.length; i++) {
					if (direction === "  >>  ") {
						var general = new Option();
						general.value = general_values[i];
						general.text = general_texts[i];
						$('#general_positions').append(general);
					} else {
						$('option[value=' + general_values[i] + ']').remove();
					}
				}
				for (i = 0; i < specific_texts.length; i++) {
					if (direction === "  >>  ") {
						var specific = new Option();
						specific.value = specific_values[i];
						specific.text = specific_texts[i];
						$('#possible').append(specific);
					} else {
						$('option[value=' + specific_values[i] + ']').remove();
					}
				}
			}
		});
	}
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
		alert("No items selected.");
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

function fillPositions() {
	$.ajax({
		type: "POST",
		url: window.location.href,
		data: $(this).serialize(),
		success: function(msg){
			var msg = JSON.parse(msg);
			var option = new Option();
			$('#position_id').children().remove();
			option.value = '';
			option.text = 'Select Position';
			$('#position_id').append(option);
			for (i = 0; i < msg.length; i++) {
				option = new Option();
				option.value = msg[i].position_id;
				option.text = msg[i].position;
				$('#position_id').append(option);
			}
		}
	});
}

/* DOM is ready */
$(document).ready(function () {
	var menu_map = {};
	menu_map['home'] = "HOME";
	menu_map['candidates'] = "CANDIDATES";
	menu_map['elections'] = "ELECTIONS";
	menu_map['parties'] = "PARTIES";
	menu_map['positions'] = "POSITIONS";
	menu_map['voters'] = "VOTERS";

	/* Bind handlers to events */
	$('a.confirmDelete').click(confirmDelete);
	$('a.manipulateAllPositions').click(manipulateAllPositions);
	$('img.togglePosition').click(togglePosition);
	$(':radio.changeElectionStatus').click(changeElectionStatus);
	$(':button.copySelectedWithAjax').click(copySelectedWithAjax);
	$(':button.copySelected').click(copySelected);
	$('form.selectChosen').submit(selectChosen);
	/* used in add/edit candidates */
	$('select.fillPositions').change(fillPositions);
	/* Disable Result radio buttons if election is already running */
	$(':radio.changeElectionStatus[value=1]:checked').click();
	/* Collapse all */
	$('a.manipulateAllPositions[text="collapse all"]').click();
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
});
