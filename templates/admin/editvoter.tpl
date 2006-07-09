<div class="content">
<h2>Edit Voter</h2>
<div class="error">
{errors all='error'}
	{$error}<br />
{/errors}
</div>
<form action="editvoter.do/$PARAMS[0]">
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
		<td>Email: <span style="color:red;">*</span></td>
		<td><input type="text" name="email" /></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="password" />Password</td>
		<td><input type="checkbox" name="pin" />Pin</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Edit Candidate" /></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">* -required fields</span></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">note: check password and pin to regenerate them</span></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">they will be automatically emailed to the voter</span></td>
	</tr>
</table>
</form>
<p>back to <a href="voters">voters</a></p>
</div>