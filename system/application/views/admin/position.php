<?php echo format_messages($messages, $message_type); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open_multipart('admin/do_add/position'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open_multipart('admin/do_edit/position/' . $position['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_position_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w30" align="right">
			<label for="position"><?php echo e('admin_position_position'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'position', 'name'=>'position', 'value'=>$position['position'], 'maxlength'=>63, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="description"><?php echo e('admin_position_description'); ?>:</label>
		</td>
		<td>
			<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value'=>$position['description'])); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="maximum"><?php echo e('admin_position_maximum'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'maximum', 'name'=>'maximum', 'value'=>$position['maximum'], 'class'=>'short')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="ordinality"><?php echo e('admin_position_ordinality'); ?>:</label>
		</td>
		<td>
			<?php echo form_input(array('id'=>'ordinality', 'name'=>'ordinality', 'value'=>$position['ordinality'], 'class'=>'short')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?php echo e('admin_position_abstain'); ?>:
		</td>
		<td>
			<label for="yes"><?php echo form_radio(array('id'=>'yes', 'name'=>'abstain', 'value'=>1, 'checked'=>(($position['abstain']) ? TRUE : FALSE))); ?> Yes</label>
			<label for="no"><?php echo form_radio(array('id'=>'no', 'name'=>'abstain', 'value'=>0, 'checked'=>(($position['abstain']) ? FALSE : TRUE))); ?> No</label>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?php echo e('admin_position_unit'); ?>:
		</td>
		<td>
			<label for="general"><?php echo form_radio(array('id'=>'general', 'name'=>'unit', 'value'=>0, 'checked'=>(($position['unit']) ? FALSE : TRUE))); ?> General</label>
			<label for="specific"><?php echo form_radio(array('id'=>'specific', 'name'=>'unit', 'value'=>1, 'checked'=>(($position['unit']) ? TRUE : FALSE))); ?> Specific</label>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/positions', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_position_submit')) ?>
</div>
<?php echo form_close(); ?>