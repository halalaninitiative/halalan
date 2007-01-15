<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
<div class="content">
<h2>{$party.party}</h2>
{if $party.logo}
<p><img width="100px" height="100px" alt="pic" src="`$smarty.const.APP_URI`/files/`$party.logo`" absolute=true /></p>
{else}
<p><img width="100px" height="100px" alt="pic" src="images/nophoto.jpg" /></p>
{/if}
<p>Party: {$party.party}</p>
<p>Description: {$party.description|nl2br}</p>
<p>&nbsp;</p>
<p>back to <a href="parties">parties</a></p>
</div>