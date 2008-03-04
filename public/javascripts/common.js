
function highlightMenuItem(map) {
	var number = new RegExp('[0-9]+');
	var url = window.location.href.split('/');
	var activeView = url.pop();
	var li;

	while (number.test(activeView)) {
		activeView = url.pop();
	}

	li = $('#menu li').filter(function () {return $(this).text() === map[activeView];});
	li.children().andSelf().css('background-color', "#4983ff");
}

function animateFlashMessage() {
	var message = $('div.positive, div.negative');
	var color = message.css('background-color');

	message.css('background-color', '#fdff46').animate({backgroundColor: color}, 2000);
}

/* jQuery event handlers */

function toggleDetails() {
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
	$(this).parents('tr').next().find('div.details').slideToggle("normal");
}
