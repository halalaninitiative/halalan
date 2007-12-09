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
<?php if ($action == 'add'): ?>
<?= form_open_multipart('admin/do_add_position'); ?>
<?php elseif ($action == 'edit'): ?>
<?= form_open_multipart('admin/do_edit_position/' . $position['id']); ?>
<?php endif; ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"> <?= e('admin_' . $action . '_position_label'); ?> </span></legend>
			<table>
				<tr>
					<td width="30%"><?= e('admin_position_position'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'position', 'value'=>$position['position'], 'style'=>'width:250px;')); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_position_description'); ?></td>
					<td width="70%"><?= form_textarea(array('name'=>'description', 'value'=>$position['description'], 'style'=>'width:250px;height:125px;')); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_position_maximum'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'maximum', 'value'=>$position['maximum'], 'style'=>'width:25px;')); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_position_ordinality'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'ordinality', 'value'=>$position['ordinality'], 'style'=>'width:25px;')); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_position_abstain'); ?></td>
					<td width="70%"><?= form_radio(array('name'=>'abstain', 'value'=>TRUE, 'checked'=>(($position['abstain']) ? TRUE : FALSE))); ?> Yes <?= form_radio(array('name'=>'abstain', 'value'=>FALSE, 'checked'=>(($position['abstain']) ? FALSE : TRUE))); ?> No</td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_position_unit'); ?></td>
					<td width="70%"><?= form_radio(array('name'=>'unit', 'value'=>FALSE, 'checked'=>(($position['unit']) ? FALSE : TRUE))); ?> General <?= form_radio(array('name'=>'unit', 'value'=>TRUE, 'checked'=>(($position['unit']) ? TRUE : FALSE))); ?> Specific</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('admin/positions', 'GO BACK'); ?>
		|
		<?= form_submit('submit', e('admin_' . $action . '_position_submit')) ?>
	</div>
	<div class="clear"></div>
</div>
<?= form_close(); ?>