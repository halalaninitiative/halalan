
<div class="admin_menu">
	<div id="left_menu">
		<ul>
			<li class="active"> <?= anchor('admin', 'Home'); ?> </li> |
			<li> <?= anchor('admin/voters', 'Voters'); ?> </li> |
			<li> <?= anchor('admin/units', 'Units'); ?> </li> |
			<li> <?= anchor('admin/parties', 'Parties'); ?> </li> |
			<li> <?= anchor('admin/positions', 'Positions'); ?> </li> |
			<li> <?= anchor('admin/candidates', 'Candidates'); ?> </li>
		</ul>
	</div>
	<div id="right_menu">
		<p>LOGGED IN AS <?= $username ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
	</div>
	<div class="clear"></div>
</div>

<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header">Home</span></legend>
			<p>What do you want to do?</p>
			<ul>
				<li><?= anchor('admin/voters', 'Manage Voters'); ?></li>
				<li><?= anchor('admin/candidates', 'Manage Candidates'); ?></li>
				<li><?= anchor('admin/parties', 'Manage Parties'); ?></li>
			</ul>
		
		</fieldset>
	</div>
	<div class="clear"></div>
</div>

