function confirmDelete(name, url)
{
	var answer = confirm('Are you sure you want to delete ' + name + '?\nWarning: This action cannot be undone!');
	if (answer)
		document.location.href = url;
}

function copyToList(from,to)
{
  fromList = document.getElementById(from);
  toList = document.getElementById(to);
  var sel = false;
  for (i=0;i<fromList.options.length;i++)
  {
    var current = fromList.options[i];
    if (current.selected)
    {
      sel = true;
      txt = current.text;
      val = current.value;
      toList.options[toList.length] = new Option(txt,val);
      fromList.options[i] = null;
      i--;
    }
  }
  if (!sel) alert ('You haven\'t selected any options!');
}

function allSelect()
{
  List = document.getElementById('chosen');
  for (i=0;i<List.length;i++)
  {
     List.options[i].selected = true;
  }
}

function setContent(id, name, picture, description, party, logo, url) {
	var ret = "";
	ret += "<div style=\"width: 300px;\">";
	ret += "<div style=\"float: left;\">";
	if (picture == '')
	ret += "<img src=\"" + url + "images/default.png\" alt=\"picture\" />";
	else
	ret += "<img src=\"" + url + "uploads/" + id + "/" + picture + "\" alt=\"picture\" />";
	ret += "</div>";
	ret += "<div style=\"float: left;\">";
	ret += "Name: " + name;
	ret += "<br />Party: " + party;
	ret += "</div>";
	ret += "</div>";
	ret += "<div style=\"clear: both;\"></div>";
	ret += "<div style=\"width: 300px;\">" + description + "</div>";
	return ret;
}

function checkNumber(field, name, form, limit) {
	var cntr = 0;
	var group = form.elements[name];
	for(var i = 0; i < group.length; i++)
		if(group[i].checked)
			cntr++;
	if(cntr > limit) {
		field.checked = false;
		alert("You are over the allowed limit");
	}
}
function manipulateCheckBoxes(field, name, form) {
	var group = form.elements[name];
	for(var i = 0; i < group.length; i++) {
		if(field.checked)
			group[i].disabled = true;
		else
			group[i].disabled = false;
	}
	field.disabled = false;
}
function saveState() {
	var inputs = document.getElementsByTagName("input");
	var checkboxes = new Array();
	for(var i = 0; i < inputs.length; i++) {
		if(inputs[i].type == "checkbox") {
			if(inputs[i].disabled == true)
				checkboxes.push(i);
		}
	}
	$.cookie('halalan_cookie', checkboxes.toString(), {expires: 1, path: '/'});
}
function restoreState(checkboxes) {
	checkboxes = checkboxes.split(",");
	var inputs = document.getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++) {
		if(in_array(i, checkboxes))
			inputs[i].disabled = true;
	}
}
function in_array(needle, haystack) {
	for(var i = 0; i < haystack.length; i++) {
		if(haystack[i] == needle)
			return true;
	}
	return false;
}
function checkCookie() {
	var checkboxes = $.cookie('halalan_cookie');
	if(checkboxes != null && checkboxes != "")
		restoreState(checkboxes);
}

/* jQuery code */
function on_status_button_clicked() {
	var result = $("tr.result");
	var buttons = $("input[type=radio][name=result]");

	if ($(this).val() == "1") {
		result.fadeTo(250, 0.5)
		buttons.attr("disabled", true);
	} else {
		result.fadeTo(250, 1.0);
		buttons.attr("disabled", false);
	}
}

$(document).ready(function() {
	/* Bind events */
	$("input[type=radio][name=status]").click(on_status_button_clicked);

	/* Init */
	if ($("input[type=radio][name=status][value=1]").attr("checked")) {
		$("input[type=radio][name=status][value=1]").trigger("click");
	}
});
