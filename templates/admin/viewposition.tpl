<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
<div class="content">
<h2>{$position.position}</h2>
<p>Position: {$position.position}</p>
<p>Maximum: {$position.maximum}</p>
<p>Ordinality: {$position.ordinality}</p>
<p>Description: {$position.description|nl2br}</p>
<p>Abstain: {if $position.abstain == $smarty.const.YES}enable{else}disable{/if}</p>
<p>&nbsp;</p>
<p>back to <a href="positions">positions</a></p>
</div>