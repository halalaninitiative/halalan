<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
<div class="content">
<h2>{$voter.firstname} {$voter.lastname}</h2>
<p>Name: {$voter.firstname} {$voter.lastname}</p>
<p>Email: {$voter.email}</p>
{if $smarty.const.ELECTION_UNIT|lower eq "enable"}
<p>Specific Unit: {$position.position}</p>
{/if}
<p>&nbsp;</p>
<p>back to <a href="voters">voters</a></p>
</div>