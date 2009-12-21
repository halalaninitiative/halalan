<?php echo format_messages($messages, $message_type); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open_multipart('admin/parties/do_add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open_multipart('admin/parties/do_edit/' . $party['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_party_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w30" align="right">
			<label for="party"><?php echo e('admin_party_party'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'party', 'name'=>'party', 'value'=>$party['party'], 'maxlength'=>63, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="alias"><?php echo e('admin_party_alias'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'alias', 'name'=>'alias', 'value'=>$party['alias'], 'maxlength'=>15, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="description"><?php echo e('admin_party_description'); ?>:</label>
		</td>
		<td>
			<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value'=>$party['description'])); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?php echo e('admin_party_logo'); ?>:
		</td>
		<td>
			<?php echo form_upload(array('name'=>'logo')); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/parties', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_party_submit')) ?>
</div>
<?php echo form_close(); ?>