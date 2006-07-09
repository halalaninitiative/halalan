<div class="content">
<h2>{$candidate.firstname} {$candidate.lastname}</h2>
{if $candidate.picture}
<p><img width="100px" height="100px" alt="pic" src="`$smarty.const.APP_URI`/files/`$candidate.picture`" absolute=true /></p>
{else}
<p><img width="100px" height="100px" alt="pic" src="images/nophoto.jpg" /></p>
{/if}
<p>Name: {$candidate.firstname} {$candidate.lastname}</p>
<p>Party: <a href="viewparty/{$candidate.partyid}">{$candidate.party}</a></p>
<p>Position: {$candidate.position}</p>
<p>Description: {$candidate.description|nl2br}</p>
<p>&nbsp;</p>
<p>back to <a href="candidates">candidates</a></p>
</div>