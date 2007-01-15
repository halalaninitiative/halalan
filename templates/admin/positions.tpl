{literal}
	<script>
	function confirmDelete(name, id) {
                var ans = confirm("Are you sure you want to delete " + name + "? \n Warning: This action cannot be undone!");
                if(ans){
                        document.location = "deleteposition.do/"+id;
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
<h2>Positions</h2>
<table width="100%">
{foreach item=position from=$positions}
	<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
		<td width="75%"><a href="viewposition/{$position.positionid}">{$position.position|escape:"htmlall"}</a></td>
		<td width="25%"><a href="editposition/{$position.positionid}">edit</a> | <a href="javascript:void(0);" onclick="confirmDelete('{$position.position|escape:javascript}', {$position.positionid})">delete</a></td>
	</tr>
{foreachelse}
	<tr>
		<td>No records found</td>
	</tr>
{/foreach}
</table>
</div>
<div class="content"><a href="addposition">Add Position</a></div>