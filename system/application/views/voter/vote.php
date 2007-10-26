<div class="menu">
	<div id="left_menu">
		<ul>
			<li class="active"><img src="<?= base_url(); ?>public/images/user.png" alt="voter" /> VOTE</li>
			<li><img src="<?= base_url(); ?>public/images/forward.png" alt="next" /> CONFIRM VOTE</li>
			<li><img src="<?= base_url(); ?>public/images/forward.png" alt="next" /> REVIEW VOTE</li>
		</ul>
	</div>
	<div id="right_menu">
		<p>LOGGED IN AS <?= $username; ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
	</div>
	<div class="clear"></div>
</div>
<form action="confirmvote.html" method="post">
<div class="body">
	<div class="left_body">
		<fieldset>
			<legend><span class="position">Chairperson</span> (1)</legend>
			<table cellspacing="2" cellpadding="2">
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number1</td>
					<td>Party1</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number2</td>
					<td>Party2</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number3</td>
					<td>Party3</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="right_body">
		<fieldset>
			<legend><span class="position">Vice Chairperson</span> (1)</legend>
			<table cellspacing="2" cellpadding="2">
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number1</td>
					<td>Party1</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number2</td>
					<td>Party2</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="body">
	<div class="left_body">
		<fieldset>
			<legend><span class="position">Councilors</span> (6)</legend>
			<table cellspacing="2" cellpadding="2">
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number1</td>
					<td>Party1</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number2</td>
					<td>Party2</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number3</td>
					<td>Party3</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number1</td>
					<td>Party1</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number2</td>
					<td>Party2</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number3</td>
					<td>Party3</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="right_body">
		<fieldset>
			<legend><span class="position">Department Representatives</span> (4)</legend>
			<table cellspacing="2" cellpadding="2">
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number1</td>
					<td>Party1</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number2</td>
					<td>Party2</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number3</td>
					<td>Party3</td>
				</tr>
				<tr>
					<td><input type="checkbox" /></td>
					<td>Chairperson Number3</td>
					<td>Party3</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<input type="reset" value="CLEAR" />
		|
		<input type="submit" value="SUBMIT" />
	</div>
</div>
</form>