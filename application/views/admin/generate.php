<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php echo form_open_multipart('admin/voters/generate'); ?>
<h2><?php echo e('admin_generate_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_generate_block') . ':' , 'block_id'); ?>
		</td>
		<td>
			<?php echo form_dropdown('block_id', for_dropdown($blocks, 'id', 'block'), set_value('block_id'), 'id="block_id"'); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/voters', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_generate_submit')) ?>
</div>
<?php echo form_close(); ?>