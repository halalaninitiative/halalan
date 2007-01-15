<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html>
<!--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="{$smarty.const.APP_URI}/" />
	<link rel="stylesheet" type="text/css" href="includes/styles.css" />
	<title>{$PARAMS.title} - Halalan</title>
</head>
<body>
<div class="container">
	<a href="login">
	<div class="header">
		<!-- put something here if there is no logo
		<h1></h1><p></p> -->
	</div>
	</a>
	<div class="left">
		{if $smarty.session.usertype == $smarty.const.USER_VOTER}
		<div class="leftcontent">
			{include file="voter/steps.tpl"}
		</div>
		<div class="leftcontent">
			<h2>Menu</h2>
			<p><a href="logout.do">Logout</a></p>
		</div>
		{elseif $smarty.session.usertype == $smarty.const.USER_ADMIN}
		<div class="leftcontent">
			{include file="admin/menu.tpl"}
		</div>
		{/if}
		<div class="leftcontent">
			<h2>Instructions</h2>
			<ul>
				<li>In order to vote, you have to login with your <span class="highlight">email and password</span>. </li>
				<li>The password will be given to you in the <span class="highlight">pre-registration</span> booth.</li>
				<li><span class="highlight">Don't forget your election pin</span> which will be used to validate your ballot. </li>
				<li><span class="highlight">In case you lost your pin</span>, please ask the election administrator for a new one.</li>
			</ul>
		</div>
		<div class="leftcontent">
			<h2>Links</h2>
			{if $smarty.session.usertype != $smarty.const.USER_ADMIN}
			<a href="adminlogin">Admin Login</a><br />
			<br />
			{/if}
			<a href="http://halalan.sourceforge.net/">Halalan Home Page</a><br />
			<a href="http://uplug.org/">UP Linux Users' Group</a><br />
		</div>
	</div>
	{include file=$PARAMS.body}
	<div class="footer">
		<p>
		<a href="http://halalan.sourceforge.net/">Halalan</a> &copy; 2006 <br />
		<a href="http://uplug.org/">University of the Philippines Linux Users' Group</a><br />
		</p>
	</div>
</div>
</body>
</html>