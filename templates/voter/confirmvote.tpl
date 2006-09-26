<div class="content">
<h2>{$smarty.const.ELECTION_NAME}</h2>
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
		<tr>
			<td>
				<input name="candidateids[]" value="`$candidate.candidateid`" type="hidden" />
			</td>
			<td>
				{if $candidate.picture}
				<img width="100px" height="100px" alt="pic" src="`$smarty.const.APP_URI`/files/`$candidate.picture`" absolute=true />
				{else}
				<img width="100px" height="100px" alt="pic" src="images/nophoto.jpg" />
				{/if}
			</td>
			<td>
				<a href="candidateinfo/{$candidate.candidateid}">{$candidate.firstname} {$candidate.lastname}</a>
			</td>
			<td>
				<a href="partyinfo/{$candidate.partyid}">{$candidate.party}</a>
			</td>
		</tr>
		{/foreach}
	</table>
	</div>
	{/foreach}
	<div class="content">
		<h2>Confirm Vote</h2>
		<br />
		<p><span class="highlight">You may still change your choices</span> by going <a href="ballot">here</a>.</p>
		<p>&nbsp;</p>
		<p>
			Enter your election pin: <input type="text" name="pin" />
		</p>
		<br />
		<p>
			<strong>Copy the text from the image to the text field below</strong><br />
			<img src="`$captcha`" alt="captcha" /><br />
			<input type="text" name="captcha" />
		</p>
		<p><input name="submit" value="Confirm Vote" type="submit" onclick="this.disabled=true;return true;" ></p>
	</div>
</form>