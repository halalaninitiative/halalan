String.prototype.endsWith = function (suffix) {
	return (this.substr(this.length-suffix.length) == suffix);
}

String.prototype.startsWith = function (prefix) {
	return (this.substr(0, prefix.length) == prefix);
}

String.prototype.isExtension = function (extensions) {
	if (typeof(extensions) == 'string') {
		extensions = [extensions];
	}
	var len = extensions.length;
	filename = this.toLowerCase();
	for (var i = 0; i < len; i++) {
		if (filename.endsWith("." + extensions[i].toLowerCase())) {
			return true;
		}
	}
	return false;
}

String.prototype.replaceAll = function (search, replace) {
	return this.split(search).join(replace);
}
