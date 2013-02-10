<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open('admin/positions/add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open('admin/positions/edit/' . $position['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_position_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_election') . ':' , 'election_id'); ?>
		</td>
		<td>
			<?php echo form_dropdown('election_id', for_dropdown($elections, 'id', 'election'), set_value('election_id', $position['election_id']), 'id="election_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_position') . ':', 'position'); ?>
		</td>
		<td>
			<?php echo form_input('position', set_value('position', $position['position']), 'id="position" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_description') . ':', 'description'); ?>
		</td>
		<td>
			<?php echo form_textarea('description', set_value('description', $position['description']), 'id="description"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_maximum') . ':', 'maximum'); ?>
		</td>
		<td>
			<?php echo form_input('maximum', set_value('maximum', $position['maximum']), 'id="maximum" class="short"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_ordinality') . ':', 'ordinality'); ?>
		</td>
		<td>
			<?php echo form_input('ordinality', set_value('ordinality', $position['ordinality']), 'id="ordinality" class="short"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_position_abstain'); ?>:
		</td>
		<td>
			<?php echo form_radio('abstain', '1', set_value('abstain', $position['abstain']) == 1 ? TRUE : FALSE, 'id="yes"'); ?>
			<?php echo form_label('Yes', 'yes'); ?>
			<?php echo form_radio('abstain', '0', set_value('abstain', $position['abstain']) == 0 ? TRUE : FALSE, 'id="no"'); ?>
			<?php echo form_label('No', 'no'); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/positions', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_position_submit')) ?>
</div>
<?php echo form_close(); ?>