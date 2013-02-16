<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php echo form_open_multipart('admin/voters/export'); ?>
<h2><?php echo e('admin_export_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w20">
			<?php echo form_label(e('admin_export_block') . ':' , 'block_id'); ?>
		</td>
		<td>
			<?php echo form_dropdown('block_id', for_dropdown($blocks, 'id', 'block'), set_value('block_id', get_cookie('selected_block')), 'id="block_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w45">
			<label for="status">
			<?php echo form_checkbox(array('id' => 'status', 'name' => 'status', 'value' => TRUE, 'checked' => FALSE)); ?>
			<?php echo e('admin_export_status'); ?>
			</label>
		</td>
		<td>
			(<?php echo e('admin_export_status_description'); ?>)
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/voters', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_export_submit')) ?>
</div>
<?php echo form_close(); ?>