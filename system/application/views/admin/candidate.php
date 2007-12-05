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
<?php if ($action == 'add'): ?>
<?= form_open_multipart('admin/do_add_candidate'); ?>
<?php elseif ($action == 'edit'): ?>
<?= form_open_multipart('admin/do_edit_candidate/' . $candidate['id']); ?>
<?php endif; ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"> <?= e('admin_' . $action . '_candidate_legend'); ?> </span></legend>
			<table>
				<tr>
					<td width="30%"><?= e('admin_' . $action . '_candidate_first_name'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'first_name', 'value'=>$candidate['first_name'], 'style'=>'width:250px;')); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_' . $action . '_candidate_last_name'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'last_name', 'value'=>$candidate['last_name'], 'style'=>'width:250px;')); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_' . $action . '_candidate_description'); ?></td>
					<td width="70%"><?= form_textarea(array('name'=>'description', 'value'=>$candidate['description'], 'style'=>'width:250px;height:125px;')); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_' . $action . '_candidate_party'); ?></td>
					<td width="70%"><?= form_dropdown('party_id', $parties, $candidate['party_id']); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_' . $action . '_candidate_position'); ?></td>
					<td width="70%"><?= form_dropdown('position_id', $positions, $candidate['position_id']); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_' . $action . '_candidate_picture'); ?></td>
					<td width="70%"><?= form_upload(array('name'=>'picture', 'size'=>30)); ?></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('admin/candidates', 'GO BACK'); ?>
		|
		<?= form_submit('submit', e('admin_' . $action . '_candidate_submit')) ?>
	</div>
	<div class="clear"></div>
</div>
<?= form_close(); ?>