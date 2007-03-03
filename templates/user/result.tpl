{include_js src="domTT/domLib.js"}
{include_js src="domTT/domTT.js"}
{include_js src="domTT/domTT_drag.js"}

<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
{if $smarty.const.ELECTION_RESULT|lower eq "show" && $smarty.const.ELECTION_STATUS|lower neq "active"}
{foreach from=$positions item=position}
<div class="content">
<h2>{$position.position} ({$position.maximum})</h2>
{assign var=count value=0}
<table cellpadding="2" cellspacing="0" align="center" width="100%">
	{foreach from=$position.candidates item=candidate}
	<tr {if $count < $position.maximum} class="winner" {/if} >
		<td width="5%">
			{$candidate.votes}
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
			<a href="result" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.firstname|escape:javascript} {$candidate.lastname|escape:javascript}', 'content', '{$candidate.description|nl2br|escape:htmlall|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.firstname} {$candidate.lastname}</a>
		</td>
		<td width="30%">
			<a href="result" onclick="return makeFalse(domTT_activate(this, event, 'caption', '{$candidate.party|escape:javascript}', 'content', '{$candidate.partydesc|nl2br|escape:htmlall|escape:javascript}', 'type', 'sticky', 'closeLink', '[close]', 'draggable', true));">{$candidate.party}</a>
		</td>
	</tr>
	{assign var=count value=$count+1}
	{/foreach}
</table>
</div>
{/foreach}
<div class="content">
<p>go <a href="login">back</a></p>
</div>
{else}
<div class="content">
<p>No results yet.</p>
<p>&nbsp;</p>
<p>go <a href="login">back</a></p>
</div>
{/if}