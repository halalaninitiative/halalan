{include_js src="domTT/domLib.js"}
{include_js src="domTT/domTT.js"}
{include_js src="domTT/domTT_drag.js"}

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
<form action="confirmvote.do">
	{foreach from=$positions item=position}
	<div class="content">
	<h2>{$position.position} ({$position.maximum})</h2>
	<table cellpadding="2" cellspacing="2" align="center" width="100%">
		{foreach from=$position.candidates item=candidate}
		{if $candidate}
		<tr>
			<td width="5%">
				<input name="candidateids[]" value="`$candidate.candidateid`" type="hidden" />
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
				<a href="confirmvote" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.firstname|escape:javascript} {$candidate.lastname|escape:javascript}', 'content', '{$candidate.description|nl2br|escape:htmlall|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.firstname} {$candidate.lastname}</a>
			</td>
			<td width="30%">
				<a href="confirmvote" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.party|escape:javascript}', 'content', '{$candidate.partydesc|nl2br|escape:htmlall|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.party}</a>
			</td>
		</tr>
		{else}
		<tr>
			{if $smarty.const.ELECTION_PICTURE|lower eq "enable"}
				<td colspan="4" align="center">
			{else}
				<td colspan="3" align="center">
			{/if}
			ABSTAIN</td>
		</tr>
		{/if}
		{/foreach}
	</table>
	</div>
	{/foreach}
	<div class="content">
		<h2>Confirm Vote</h2>
		{if $smarty.const.ELECTION_CAPTCHA|lower eq "enable"}
		<p>
			Enter your election pin: <input type="text" name="pin" />
		</p>
		<br />
		<p>
			<strong>Copy the text from the image to the text field below</strong><br />
			<img src="`$captcha`" alt="captcha" /><br />
			Enter the image text: <input type="text" name="captcha" />
		</p>
		{/if}
		<p><input name="submit" value="Confirm Vote" type="submit" onclick="this.disabled=true;return true;" > <span class="highlight">You may still change your choices by going <a href="ballot">here</a></span>.</p>
	</div>
</form>