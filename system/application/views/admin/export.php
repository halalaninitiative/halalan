<?php echo form_open_multipart('admin/voters/do_export'); ?>
<h2><?php echo e('admin_export_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w45">
			<label for="password">
			<?php echo form_checkbox(array('id'=>'password', 'name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			<?php echo e('admin_export_password'); ?>
			</label>
		</td>
		<td>
			(<?php echo e('admin_export_password_description'); ?>)
		</td>
	</tr>
	<?php if ($settings['pin']): ?>
	<tr>
		<td class="w45">
			<label for="pin">
			<?php echo form_checkbox(array('id'=>'pin', 'name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			<?php echo e('admin_export_pin'); ?>
			</label>
		</td>
		<td>
			(<?php echo e('admin_export_pin_description'); ?>)
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td class="w45">
			<label for="votes">
			<?php echo form_checkbox(array('id'=>'votes', 'name'=>'votes', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			<?php echo e('admin_export_votes'); ?>
			</label>
		</td>
		<td>
			(<?php echo e('admin_export_votes_description'); ?>)
		</td>
	</tr>
	<tr>
		<td class="w45">
			<label for="status">
			<?php echo form_checkbox(array('id'=>'status', 'name'=>'status', 'value'=>TRUE, 'checked'=>FALSE)); ?>
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