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
<h2>Edit Voter</h2>
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
	{if $smarty.const.ELECTION_UNIT|lower eq "enable"}
	<tr>
		<td>Specific Unit: <span style="color:red;">*</span></td>
		<td><select name="unitid">{options options=$units}</select></td>
	</tr>
	{/if}
	<tr>
		<td><input type="checkbox" name="password" />Password</td>
		<td><input type="checkbox" name="pin" />Pin</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Edit Voter" /></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">* -required fields</span></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">note: check password and pin to regenerate them</span></td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:red;">{if $smarty.const.ELECTION_PIN_PASSWORD_GENERATION|lower eq "email"}they will be automatically emailed to the voter{elseif $smarty.const.ELECTION_PIN_PASSWORD_GENERATION|lower}they will be displayed on the next page{/if}</span></td>
	</tr>
</table>
</form>
<p>back to <a href="voters">voters</a></p>
</div>