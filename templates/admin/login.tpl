<div class="content">
<h2>Admin Login</h2>
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
<form action="adminlogin.do">
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
<p>back to <a href="login">home</a></p>
</div>