<div class="content">
<h1>{$smarty.const.ELECTION_NAME}</h1>
</div>
<div class="content">
<h2>Add Party</h2>
<div class="error">
{errors all='error'}
	{$error}<br />
{/errors}
</div>
<form action="addparty.do">
<table>
	<tr>
		<td>Party: <span style="color:red;">*</span></td>
		<td><input type="text" name="party" /></td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><textarea name="description"></textarea></td>
	</tr>
	{if $smarty.const.ELECTION_PICTURE|lower eq "enable"}
	<tr>
		<td>Logo:</td>
		<td><input type="file" name="logo" /></td>
	</tr>
	{/if}
	<tr>
		<td></td>
		<td><input type="submit" value="Add Party" /></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">* -required fields</span></td>
	</tr>
</table>
</form>
<p>back to <a href="parties">parties</a></p>
</div>