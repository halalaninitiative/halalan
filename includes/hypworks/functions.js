
function repaintVisibility (id) {
	var element = document.getElementById(id);
	if (element.style.display == 'none') {
		element.style.display = '';
		element.style.display = 'none';
	} else {
		var x = element.style.display;
		element.style.display = 'none';
		element.style.display = x;
	}
}

