
<div class="admin_menu">
	<div id="left_menu">
		<ul>
			<li><?= anchor('admin', 'Home'); ?> | </li>
			<li><?= anchor('admin/voters', 'Voters'); ?> |  </li>
			<li><?= anchor('admin/parties', 'Parties'); ?> | </li>
			<li><?= anchor('admin/positions', 'Positions'); ?> | </li>
			<li><?= anchor('admin/candidates', 'Candidates'); ?></li>
		</ul>
	</div>
	<div id="right_menu">
		<p>LOGGED IN AS <?= strtoupper($username); ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
	</div>
	<div class="clear"></div>
</div>
<?php if (isset($messages) && !empty($messages)): ?>
<div class="message">
	<div class="message_header"><?= e('common_message_box'); ?></div>
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
	<div class="left_body">
		<fieldset>
			<legend><span class="header"><?= e('admin_home_left_label'); ?></span></legend>
			<p>What do you want to do?</p>
			<ul>
				<li><?= anchor('admin/voters', 'Manage Voters'); ?></li>
				<li><?= anchor('admin/parties', 'Manage Parties'); ?></li>
				<li><?= anchor('admin/positions', 'Manage Positions'); ?></li>
				<li><?= anchor('admin/candidates', 'Manage Candidates'); ?></li>
			</ul>
		</fieldset>
	</div>
	<div class="right_body">
		<fieldset>
			<legend><span class="header"><?= e('admin_home_right_label'); ?></span></legend>
			<?= form_open('admin/do_edit_option/1'); ?>
			<table cellpadding="2" cellspacing="2" width="100%">
				<tr>
					<td>Status</td>
					<td><?= form_radio(array('name'=>'status', 'value'=>TRUE, 'checked'=>(($option['status']) ? TRUE : FALSE))); ?> Running</td>
					<td><?= form_radio(array('name'=>'status', 'value'=>FALSE, 'checked'=>(($option['status']) ? FALSE : TRUE))); ?> Not Running</td>
				</tr>
				<tr>
					<td>Result</td>
					<td><?= form_radio(array('name'=>'result', 'value'=>TRUE, 'checked'=>(($option['result']) ? TRUE : FALSE))); ?> Show</td>
					<td><?= form_radio(array('name'=>'result', 'value'=>FALSE, 'checked'=>(($option['result']) ? FALSE : TRUE))); ?> Hide</td>
				</tr>
				<tr>
					<td colspan="3" align="center"><?= form_submit(array('name'=>'submit', 'value'=>'Save')); ?></td>
				</tr>
			</table>
			<?= form_close(); ?>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		ADMINISTRATION PAGE
	</div>
	<div class="clear"></div>
</div>
