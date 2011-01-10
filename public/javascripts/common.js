
function highlightMenuItem(map) {
	var regex = new RegExp();
	var url = window.location.href;
	var li;
	for (var property in map) {
		regex.compile(property);
		if (regex.test(url)) {
			li = $('#menu li').filter(function () {return $(this).text() === map[property];});
			li.children().andSelf().css('background-color', "#4983ff");
			break;
		}
	}
}

function animateFlashMessage() {
	var message = $('div.positive, div.negative');
	var color = message.css('background-color');

	message.css('background-color', '#fdff46').animate({backgroundColor: color}, 2000);
}

/* jQuery event handlers */

function toggleDetails(target) {
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
	$(target).parents('tr').next().find('div.details').slideToggle("normal");
}
