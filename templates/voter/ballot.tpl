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
<form action="ballot.do">
	{foreach from=$positions item=position}
	<div class="content">
	<h2>{$position.position} ({$position.maximum})</h2>
	<table cellpadding="2" cellspacing="2" align="center" width="100%">
		{foreach from=$position.candidates item=candidate}
		<tr>
			{if $candidate.maximum > 1}
			<td width="5%">
				<input name="votes[`$candidate.positionid`][]" value="`$candidate.candidateid`" type="checkbox" />
			</td>
			{else}
			<td>
				<input name="votes[`$candidate.positionid`][]" value="`$candidate.candidateid`" type="radio" />
			</td>
			{/if}
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
		<input name="submit" value="Submit Ballot" type="submit" />
	</div>
</form>