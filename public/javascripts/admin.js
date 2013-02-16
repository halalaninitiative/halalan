
/* jQuery event handlers */

function confirmDelete() {
	var name = $(this).parent().siblings().eq(1).children().text();

	return confirm("Are you sure you want to delete " + name + "?\nWarning: This action cannot be undone!");
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
	} else {
		alt = "Expand";
		src = src.replace("minus", "plus");
		img.siblings('span').show();
		$('table.table').hide();
	}

	img.attr({
		'src': src,
		'alt': alt,
		'title': alt
	});

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
	$(this).attr({
		'src': src,
		'alt': alt,
		'title': alt
	});

	return false;
}

function fillPositionsAndParties() {
	$.ajax({
		type: "POST",
		url: window.location.href,
		data: $(this).serialize() + '&halalan_csrf_token=' + $('input[name="halalan_csrf_token"]').val(),
		dataType: 'json',
		success: function(msg){
			var positions = msg[0];
			var parties = msg[1];
			var option = new Option();
			$('#position_id').children().remove();
			option.value = '';
			option.text = 'Choose Position';
			$('#position_id').append(option);
			for (i = 0; i < positions.length; i++) {
				option = new Option();
				option.value = positions[i].id;
				option.text = positions[i].position;
				$('#position_id').append(option);
			}
			var option = new Option();
			$('#party_id').children().remove();
			option.value = '';
			option.text = 'Choose Party';
			$('#party_id').append(option);
			for (i = 0; i < parties.length; i++) {
				option = new Option();
				option.value = parties[i].id;
				option.text = parties[i].party;
				$('#party_id').append(option);
			}
		}
	});
}

function changeElections() {
	var url = window.location.href;
	$.cookie('selected_election', $(this).val(), {path: '/'});
	$.cookie('selected_position', '', {path: '/'});
	window.location.href = url;
}

function changePositions() {
	var url = window.location.href;
	$.cookie('selected_position', $(this).val(), {path: '/'});
	window.location.href = url;
}

function changeBlocks() {
	var url = window.location.href;
	$.cookie('selected_block', $(this).val(), {path: '/'});
	window.location.href = url;
}

/* DOM is ready */
$(document).ready(function () {
	var menu_map = {};
	menu_map['home'] = "HOME";
	menu_map['elections'] = "ELECTIONS";
	menu_map['positions'] = "POSITIONS";
	menu_map['parties'] = "PARTIES";
	menu_map['candidates'] = "CANDIDATES";
	menu_map['blocks'] = "BLOCKS";
	menu_map['voters'] = "VOTERS";

	/* Bind handlers to events */
	$('a.confirmDelete').click(confirmDelete);
	$('a.manipulateAllPositions').click(manipulateAllPositions);
	$('img.togglePosition').click(togglePosition);
	$('select.fillPositionsAndParties').change(fillPositionsAndParties);
	$('select.changeElections').change(changeElections);
	$('select.changePositions').change(changePositions);
	$('select.changeBlocks').change(changeBlocks);
	/* Code that aren't bound to events */
	highlightMenuItem(menu_map);
	animateFlashMessage();
	$('input[type="text"]:eq(0)').focus();
});
