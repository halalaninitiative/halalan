{literal}
	<script>
	function confirmDelete(name, id) {
                var ans = confirm("Are you sure you want to delete " + name + "? \n Warning: This action cannot be undone!");
                if(ans){
                        document.location = "deleteparty.do/"+id;
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
<h2>Parties</h2>
<table width="100%">
{foreach item=party from=$parties}
	<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
		<td width="75%"><a href="viewparty/{$party.partyid}">{$party.party|escape:"htmlall"}</a></td>
		<td width="25%"><a href="editparty/{$party.partyid}">edit</a> | <a href="javascript:void(0);" onclick="confirmDelete('{$party.party|escape:javascript}', {$party.partyid})">delete</a></td>
	</tr>
{foreachelse}
	<tr>
		<td>No records found</td>
	</tr>
{/foreach}
</table>
</div>
<div class="content"><a href="addparty">Add Party</a></div>