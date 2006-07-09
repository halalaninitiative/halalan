<div class="content">
<h2>Add Candidate</h2>
<div class="error">
{errors all='error'}
	{$error}<br />
{/errors}
</div>
<form action="addcandidate.do">
<table>
	<tr>
		<td>First Name: <span style="color:red;">*</span></td>
		<td><input type="text" name="firstname" /></td>
	</tr>
	<tr>
		<td>Last Name: <span style="color:red;">*</span></td>
		<td><input type="text" name="lastname" /></td>
	</tr>
	<tr>
		<td>Party: <span style="color:red;">*</span></td>
		<td><select name="partyid">{options options=$parties}</select>
		</td>
	</tr>
	<tr>
		<td>Position: <span style="color:red;">*</span></td>
		<td><select name="positionid">{options options=$positions}</select></td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><textarea name="description"></textarea></td>
	</tr>
	<tr>
		<td>Picture:</td>
		<td><input type="file" name="picture" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Add Candidate" /></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">* -required fields</span></td>
	</tr>
</table>
</form>
<p>back to <a href="candidates">candidates</a></p>
</div>