<div class="content">
<h2>Edit Position</h2>
<div class="error">
{errors all='error'}
	{$error}<br />
{/errors}
</div>
<form action="editposition.do/$PARAMS[0]">
<table>
	<tr>
		<td>Position: <span style="color:red;">*</span></td>
		<td><input type="text" name="position" /></td>
	</tr>
	<tr>
		<td>Maximum: <span style="color:red;">*</span></td>
		<td><input type="text" name="maximum" /></td>
	</tr>
	<tr>
		<td>Ordinality: <span style="color:red;">*</span></td>
		<td><input type="text" name="ordinality" /></td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><textarea name="description"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Edit Position" /></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">* -required fields</span></td>
	</tr>
</table>
</form>
<p>back to <a href="positions">positions</a></p>
</div>