<div class="content">
<h2>Password Reset Tool</h2>
<div class="error">
{errors all='error'}
	{$error}<br />
{/errors}
</div>
<form action="forgotpassword.do">
<table>
	<tr>
		<td>Email:</td>
	</tr>
	<tr>
		<td><input type="text" name="email" /></td>
	</tr>
	<tr>
		<td>As an added security, please enter the letters below:</td>
	</tr>
	<tr>
		<td><img src="`$captcha`" alt="captcha" /></td>
	</tr>
	<tr>
		<td><input type="text" name="captcha" /></td>
	</tr>
	<tr>
		<td><input type="submit" value="Reset Password" /></td>
	</tr>
</table>
</form>
<p>back to <a href="javascript:back()">home</a></p>
</div>