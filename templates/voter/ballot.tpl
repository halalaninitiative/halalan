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
<form action="ballot.do">
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
				<a href="ballot" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.firstname|escape:javascript} {$candidate.lastname|escape:javascript}', 'content', '{$candidate.description|nl2br|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.firstname} {$candidate.lastname}</a>
			</td>
			<td width="30%">
				<a href="ballot" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.party|escape:javascript}', 'content', '{$candidate.partydesc|nl2br|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.party}</a>
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