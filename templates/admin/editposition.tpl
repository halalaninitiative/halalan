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
<div class="content">
<h2>Edit Position</h2>
<form action="editposition.do/$PARAMS[0]">
<table>
	<tr>
		<td>Position: <span style="color:red;">*</span></td>
		<td><input type="text" name="position" /></td>
	</tr>
	<tr>
		<td>
			Maximum: <span style="color:red;">*</span>
			<br />
			<span class="grayed">
			(maximum no. of candidates that can be accepted for this position, e.g. you can accept only 3 possible councilors out of 12 candidates)
			</span>
		</td>
		<td><input type="text" name="maximum" /></td>
	</tr>
	<tr>
		<td>
			Order<span style="color:red;">*</span>
			<br />
			<span class="grayed">
			(refers to the how the positions will be displayed, e.g. President can have an order of 1, Vice-President has an order of 2, etc)
			</span>
		</td>
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