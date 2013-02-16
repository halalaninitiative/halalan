<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open('admin/voters/add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open('admin/voters/edit/' . $voter['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_voter_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_voter_block') . ':' , 'block_id'); ?>
		</td>
		<td>
			<?php echo form_dropdown('block_id', for_dropdown($blocks, 'id', 'block'), set_value('block_id', $voter['block_id']), 'id="block_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(($settings['password_pin_generation'] == 'email') ? e('admin_voter_email') : e('admin_voter_username') . ':', 'username'); ?>
		</td>
		<td>
			<?php echo form_input('username', set_value('username', $voter['username']), 'id="username" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_voter_last_name') . ':', 'last_name'); ?>
		</td>
		<td>
			<?php echo form_input('last_name', set_value('last_name', $voter['last_name']), 'id="last_name" maxlength="31" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_voter_first_name') . ':', 'first_name'); ?>
		</td>
		<td>
			<?php echo form_input('first_name', set_value('first_name', $voter['first_name']), 'id="first_name" maxlength="63" class="text"'); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/voters', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_voter_submit')) ?>
</div>
<?php echo form_close(); ?>
