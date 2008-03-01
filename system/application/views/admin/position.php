<?= format_messages($messages, $message_type); ?>
<?php if ($action == 'add'): ?>
	<?= form_open_multipart('admin/do_add_position'); ?>
<?php elseif ($action == 'edit'): ?>
	<?= form_open_multipart('admin/do_edit_position/' . $position['id']); ?>
<?php endif; ?>
<h2><?= e('admin_' . $action . '_position_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td width="30%" align="right">
			<label for="position"><?= e('admin_position_position'); ?>:</label>
		</td>
		<td width="70%">
			<?= form_input(array('id'=>'position', 'name'=>'position', 'value'=>$position['position'], 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<label for="description"><?= e('admin_position_description'); ?>:</label>
		</td>
		<td width="70%">
			<?= form_textarea(array('id'=>'description', 'name'=>'description', 'value'=>$position['description'])); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<label for="maximum"><?= e('admin_position_maximum'); ?>:</label>
		</td>
		<td width="70%">
			<?= form_input(array('id'=>'maximum', 'name'=>'maximum', 'value'=>$position['maximum'], 'class'=>'short')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<label for="ordinality"><?= e('admin_position_ordinality'); ?>:</label>
		</td>
		<td width="70%">
			<?= form_input(array('id'=>'ordinality', 'name'=>'ordinality', 'value'=>$position['ordinality'], 'class'=>'short')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_abstain'); ?>:
		</td>
		<td width="70%">
			<label for="yes"><?= form_radio(array('id'=>'yes', 'name'=>'abstain', 'value'=>TRUE, 'checked'=>(($position['abstain']) ? TRUE : FALSE))); ?> Yes</label>
			<label for="no"><?= form_radio(array('id'=>'no', 'name'=>'abstain', 'value'=>FALSE, 'checked'=>(($position['abstain']) ? FALSE : TRUE))); ?> No</label>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_unit'); ?>:
		</td>
		<td width="70%">
			<label for="general"><?= form_radio(array('id'=>'general', 'name'=>'unit', 'value'=>FALSE, 'checked'=>(($position['unit']) ? FALSE : TRUE))); ?> General</label>
			<label for="specific"><?= form_radio(array('id'=>'specific', 'name'=>'unit', 'value'=>TRUE, 'checked'=>(($position['unit']) ? TRUE : FALSE))); ?> Specific</label>
		</td>
	</tr>
</table>
<div class="paging">
	<?= anchor('admin/positions', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_' . $action . '_position_submit')) ?>
</div>
<?= form_close(); ?>