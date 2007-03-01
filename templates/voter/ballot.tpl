{include_js src="domTT/domLib.js"}
{include_js src="domTT/domTT.js"}
{include_js src="domTT/domTT_drag.js"}

{literal}
	<script>
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
		setCookie('halalancookie', checkboxes.toString(), 1);
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
		var checkboxes = getCookie('halalancookie');
		if(checkboxes != null && checkboxes != "")
			restoreState(checkboxes);
	}

	function setCookie(c_name,value,expiredays) {
		var exdate=new Date();
		exdate.setDate(exdate.getDate()+expiredays);
		document.cookie = c_name + "=" + escape(value) + ((expiredays==null) ? "" : ";expires=" + exdate.toGMTString());
	}

	function getCookie(c_name) {
		if(document.cookie.length > 0) {
			var c_start = document.cookie.indexOf(c_name + "=");
			if(c_start != -1) {
				c_start = c_start + c_name.length + 1;
				c_end = document.cookie.indexOf(";", c_start);
				if(c_end == -1)
					c_end = document.cookie.length;
				return unescape(document.cookie.substring(c_start,c_end));
			}
		}
		return "";
	}
	window.onload = checkCookie;
	</script>
{/literal}

<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
{errors}
<div class="content error">
<p>
{errors all='error'}
	{$error}<br />
{/errors}
</p>
</div>
{/errors}
<form action="ballot.do" onsubmit="saveState();">
	{foreach from=$positions item=position}
	<div class="content">
	<h2>{$position.position} ({$position.maximum})</h2>
	<table cellpadding="2" cellspacing="2" align="center" width="100%">
		{foreach from=$position.candidates item=candidate}
		<tr>
			<td width="5%">
				<input name="votes[`$candidate.positionid`][]" value="`$candidate.candidateid`" type="checkbox" onclick="checkNumber(this, 'votes[`$position.positionid`][]', this.form, `$candidate.maximum`);" />
			</td>
			{if $smarty.const.ELECTION_PICTURE|lower eq "enable"}
			<td width="20%">
				{if $candidate.picture}
				<img width="100px" height="100px" alt="pic" src="`$smarty.const.APP_URI`/files/`$candidate.picture`" absolute=true />
				{else}
				<img width="100px" height="100px" alt="pic" src="images/nophoto.jpg" />
				{/if}
			</td>
			<td width="45%">
			{else}
			<td width="65%">
			{/if}
				<a href="ballot" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.firstname|escape:javascript} {$candidate.lastname|escape:javascript}', 'content', '{$candidate.description|nl2br|escape:htmlall|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.firstname} {$candidate.lastname}</a>
			</td>
			<td width="30%">
				<a href="ballot" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.party|escape:javascript}', 'content', '{$candidate.partydesc|nl2br|escape:htmlall|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.party}</a>
			</td>
		</tr>
		{/foreach}
		{if $position.abstain == $smarty.const.YES}
		<tr>
			<td><input name="votes[`$position.positionid`][]" value="" type="checkbox" onclick="manipulateCheckBoxes(this, 'votes[`$position.positionid`][]', this.form);" /></td>
			{if $smarty.const.ELECTION_PICTURE|lower eq "enable"}
				<td colspan="3">
			{else}
				<td colspan="2">
			{/if}
			ABSTAIN</td>
		</tr>
		{/if}
	</table>
	</div>
	{/foreach}
	<div class="content">
		<input name="submit" value="Submit Ballot" type="submit" />
	</div>
</form>