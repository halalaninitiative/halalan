{literal}
	<script>
	function confirmDelete(name, id) {
                var ans = confirm("Are you sure you want to delete " + name + "? \n Warning: This action cannot be undone!");
                if(ans){
                        document.location = "deletecandidate.do/"+id;
                }
        }
	</script>
{/literal}
<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
{messages}
<div class="content message">
	{messages all='message'}
		{$message}<br />
	{/messages}
</div>
{/messages}
{foreach item=position from=$positions}
<div class="content">
	<h2>{$position.position}</h2>
	<table width="100%">
		{foreach item=candidate from=$position.candidates}
		<tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
			<td width="75%"><a href="viewcandidate/{$candidate.candidateid}">{$candidate.lastname|escape:"htmlall"}, {$candidate.firstname|escape:"htmlall"}</a></td>
			<td width="25%"><a href="editcandidate/{$candidate.candidateid}">edit</a> | <a href="javascript:void(0);" onclick="confirmDelete('{$candidate.lastname|escape:javascript}, {$candidate.firstname|escape:javascript}', {$candidate.candidateid})">delete</a></td>
		</tr>
		{foreachelse}
		<tr>
			<td>No records found</td>
		</tr>
		{/foreach}
	</table>
</div>
{foreachelse}
<div class="content">
No records found
</div>
{/foreach}
<div class="content"><a href="addcandidate">Add Candidate</a></div>