<?php if (isset($messages) && !empty($messages)): ?>
<div class="positive">
	<ul>
		<?php foreach ($messages as $message): ?>
		<li><?= $message; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
<?php if ($action == 'add'): ?>
	<?= form_open_multipart('admin/do_add_position'); ?>
<?php elseif ($action == 'edit'): ?>
	<?= form_open_multipart('admin/do_edit_position/' . $position['id']); ?>
<?php endif; ?>
<h2><?= e('admin_' . $action . '_position_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_position'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'position', 'value'=>$position['position'], 'style'=>'width:250px;')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_description'); ?>:
		</td>
		<td width="70%">
			<?= form_textarea(array('name'=>'description', 'value'=>$position['description'], 'style'=>'width:250px;height:125px;')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_maximum'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'maximum', 'value'=>$position['maximum'], 'style'=>'width:25px;')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_ordinality'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'ordinality', 'value'=>$position['ordinality'], 'style'=>'width:25px;')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_abstain'); ?>:
		</td>
		<td width="70%">
			<?= form_radio(array('name'=>'abstain', 'value'=>TRUE, 'checked'=>(($position['abstain']) ? TRUE : FALSE))); ?> Yes
			<?= form_radio(array('name'=>'abstain', 'value'=>FALSE, 'checked'=>(($position['abstain']) ? FALSE : TRUE))); ?> No
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_position_unit'); ?>:
		</td>
		<td width="70%">
			<?= form_radio(array('name'=>'unit', 'value'=>FALSE, 'checked'=>(($position['unit']) ? FALSE : TRUE))); ?> General
			<?= form_radio(array('name'=>'unit', 'value'=>TRUE, 'checked'=>(($position['unit']) ? TRUE : FALSE))); ?> Specific
		</td>
	</tr>
</table>
<div class="paging">
	<?= anchor('admin/positions', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_' . $action . '_position_submit')) ?>
</div>
<?= form_close(); ?>