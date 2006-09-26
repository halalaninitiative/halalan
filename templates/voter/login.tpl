{if $smarty.const.ELECTION_STATUS|lower eq "active"}
<div class="content">
<h2>Login</h2>
<div class="error">
{errors all='error'}
	{$error}
{/errors}
</div>
<div class="message">
{messages all='message'}
	{$message}
{/messages}
</div>
<form action="login.do">
<table>
	<tr>
		<td>Email:</td>
	</tr>
	<tr>
		<td><input type="text" name="email" /></td>
	</tr>
	<tr>
		<td>Password:</td>
	</tr>
	<tr>
		<td><input type="password" name="password" /></td>
	</tr>
	<tr>
		<td><a href="forgotpassword">I forgot my password</a></td>
	</tr>
	<tr>
		<td><input type="submit" value="Login" /></td>
	</tr>
</table>
</form>
</div>
{else}
<div class="content">

<span class="banner">{$smarty.const.ELECTION_NAME}</span>
	<table border="0" cellspacing="5" cellpadding="5" align="left">
		<tr>
			<td>
				<img src="images/geticon.gif" border="0">
			</td>
			<td>
				The election is not running. Please wait for the election administrator to activate the election.
			</td>
		</tr>
		{if $smarty.const.ELECTION_RESULT|lower eq "show"}
		<tr>
			<td>
				<img src="images/viewicon.gif" border="0">
			</td>
			<td>
				Results are now available! View result <a href="result">here</a>.
			</td>
		</tr>
		{/if}
	</table>
</div>
{/if}