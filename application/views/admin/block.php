<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open('admin/blocks/add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open('admin/blocks/edit/' . $block['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_block_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_block_block') . ':', 'block'); ?>
		</td>
		<td>
			<?php echo form_input('block', set_value('block', $block['block']), 'id="block" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_block_elections_positions'); ?>:
		</td>
		<td>
			<?php echo form_multiselect('elections_positions[]', $elections_positions, $selected, 'id="elections_positions" size="16" style="width : 420px;"'); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/blocks', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_block_submit')) ?>
</div>
<?php echo form_close(); ?>
