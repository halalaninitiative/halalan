{literal}
	<script>
	function confirmDelete(name, id) {
                var ans = confirm("Are you sure you want to delete " + name + "? \n Warning: This action cannot be undone!");
                if(ans){
                        document.location = "deletevoter.do/"+id;
                }
        }
	</script>
{/literal}
<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
{errors}
<div class="content error">
	{errors all='error'}
		{$error}<br />
	{/errors}
</div>
{/errors}
{messages}
<div class="content message">
	{messages all='message'}
		{$message}<br />
	{/messages}
</div>
{/messages}
<div class="content">
<div style="text-align:left;">
{if $page > 1}
	<a href="{$url.first}"><<- First</a>
	<a href="{$url.prev}"><- Prev</a>
{/if}
Page {$page} of {$last}
{if $page < $last}
	<a href="{$url.next}">Next -></a>
	<a href="{$url.last}">Last ->></a>
{/if}
</div>
<div style="text-align:right;">Display per Page: <form style="display:inline;"><select name="display" selected=$selecteddisplay onchange="window.location=this.value;">{options options=$url.displays}</select></form></div>
</div>
<div class="content">
<h2>Voters</h2>
<table width="100%">
{foreach item=voter from=$voters}
	<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
		<td width="75%"><a href="viewvoter/{$voter.voterid}">{$voter.lastname|escape:"htmlall"}, {$voter.firstname|escape:"htmlall"}</a></td>
		<td width="25%"><a href="editvoter/{$voter.voterid}">edit</a> | <a href="javascript:void(0);" onclick="confirmDelete('{$voter.lastname|escape:javascript}, {$voter.firstname|escape:javascript}', {$voter.voterid})">delete</a></td>
	</tr>
{foreachelse}
	<tr>
		<td>No records found</td>
	</tr>
{/foreach}
</table>
</div>
<div class="content"><a href="addvoter">Add Voter</a></div>