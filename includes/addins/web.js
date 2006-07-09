
/**
 * Assigns/changes a GET parameter.
 *
 */
function assignGet (key, value) {
	var regex = new RegExp(key + "=[^&]+");
	if (location.search.match(regex)) {
		location.search = location.search.replace(regex, key + "=" + value);
	} else if (location.search) {
		location.search += "&" + key + "=" + value;
	} else {
		location.search = key + "=" + value;
	}
}
