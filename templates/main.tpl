<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html>
<!--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">-->
<head>
	<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
	<meta content="free template, css, xhtml, web, design, cesardesign01" name="keywords" />
	<meta name="description" content="A free template. Valid XHTML and CSS. Design by Cesar." />
	<base href="{$smarty.const.APP_URI}/" />
	<link rel="stylesheet" type="text/css" href="includes/styles.css" />
	<link rel="stylesheet" type="text/css" href="includes/local.css" />
	<title>{$PARAMS.title} - Halalan</title>
</head>
<body>
<div class="container">
	<div class="header"><!-- put something here if there is no logo--><h1></h1><p></p></div>
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
			<h2>About Halalan</h2>
			<p>Halalan is an open-source web and mobile voting system.</p>
		</div>
		<div class="leftcontent leftlinks">
			<h2>Links</h2>
			<p><a href="http://freew.bhxhost.com/">FreeW</a></p>
			<p><a href="http://www.sxc.hu/">stock.xchng</a></p>
			<p><a href="http://www.google.com/">Google</a></p>
		</div>
	</div>
	{include file=$PARAMS.body}
	<div class="footer">
		<p><!--<a href="#">Home</a> | <a href="#">Sitemap</a><br />-->
		Halalan &copy; 2006 UP Linux Users' Group<br />
		Design by <a href="http://freew.bhxhost.com/">Cesar</a> | <a href="http://validator.w3.org/check/referer">XHTML 1.0 Strict</a></p>
	</div>
</div>
</body>
</html>