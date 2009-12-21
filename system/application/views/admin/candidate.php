<?php echo format_messages($messages, $message_type); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open_multipart('admin/candidates/do_add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open_multipart('admin/candidates/do_edit/' . $candidate['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_candidate_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w30" align="right">
			<label for="last_name"><?php echo e('admin_candidate_last_name'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'last_name', 'name'=>'last_name', 'value'=>$candidate['last_name'], 'maxlength'=>31, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="first_name"><?php echo e('admin_candidate_first_name'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'first_name', 'name'=>'first_name', 'value'=>$candidate['first_name'], 'maxlength'=>63, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="alias"><?php echo e('admin_candidate_alias'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'alias', 'name'=>'alias', 'value'=>$candidate['alias'], 'maxlength'=>15, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="description"><?php echo e('admin_candidate_description'); ?>:</label>
		</td>
		<td>
			<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value'=>$candidate['description'])); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="party_id"><?php echo e('admin_candidate_party'); ?>:</label>
		</td>
		<td>
			<?php echo form_dropdown('party_id', $parties, $candidate['party_id'], 'id="party_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="position_id"><?php echo e('admin_candidate_position'); ?>:</label>
		</td>
		<td>
			<?php echo form_dropdown('position_id', $positions, $candidate['position_id'], 'id="position_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?php echo e('admin_candidate_picture'); ?>:
		</td>
		<td>
			<?php echo form_upload(array('name'=>'picture')); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/candidates', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_candidate_submit')) ?>
</div>
<?php echo form_close(); ?>