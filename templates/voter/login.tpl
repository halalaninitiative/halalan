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
<h2>&nbsp;</h2>
<p>No election is running at this time.</p>
{if $smarty.const.ELECTION_RESULT|lower eq "show"}
<p>&nbsp;</p>
<p>View result <a href="result">here</a>.</p>
{/if}
</div>
{/if}