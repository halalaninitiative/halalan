
<div class="admin_menu">
	<div id="left_menu">
		<ul>
			<li> <?= anchor('admin', 'Home'); ?> </li> |
			<li class="active"> <?= anchor('admin/voters', 'Voters'); ?> </li> |
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

<?php if (isset($messages) && !empty($messages)): ?>
<div class="message">
	<div class="message_header"><?= e('message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $message; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>

<div class="body">
	<div class="center_body">
		
		<?= form_open('admin/confirm_add_voter'); ?>		
		
		<fieldset>
			<legend><span class="header"> <?= e('add_voter_details'); ?> </span></legend>
			<div class="add_voter">				
				<table>
					<tr>
						<td width="30%">Username</td>
						<td width="70%"><?= form_input('username'); ?></td>
					</tr>
					<tr>
						<td width="30%">First Name</td>
						<td width="70%"><?= form_input('first_name'); ?></td>
					</tr>
					<tr>
						<td width="30%">Last Name</td>
						<td width="70%"><?= form_input('last_name'); ?></td>
					</tr>
				</table>
			</div>
			
		</fieldset>		
		
		<br />
		
		<fieldset class="add_voter_submit">
			<center><?= form_submit('add_submit', e('add_voter_submit')) ?></center>
		</fieldset>
		
		<?= form_close(); ?>
	
	</div>
	<div class="clear"></div>
</div>