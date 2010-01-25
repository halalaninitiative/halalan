<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open_multipart('admin/parties/add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open_multipart('admin/parties/edit/' . $party['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_party_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_party_party') . ':', 'party'); ?>
		</td>
		<td>
			<?php echo form_input('party', set_value('party', $party['party']), 'id="party" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_party_alias') . ':', 'alias'); ?>
		</td>
		<td>
			<?php echo form_input('alias', set_value('alias', $party['alias']), 'id="alias" maxlength="15" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_party_description') . ':', 'description'); ?>
		</td>
		<td>
			<?php echo form_textarea('description', set_value('description', $party['description']), 'id="description"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_party_logo') . ':', 'logo'); ?>
		</td>
		<td>
			<?php echo form_upload('logo', '', 'id="logo"'); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/parties', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_party_submit')) ?>
</div>
<?php echo form_close(); ?>