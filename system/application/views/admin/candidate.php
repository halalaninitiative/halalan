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
	<?= form_open_multipart('admin/do_add_candidate'); ?>
<?php elseif ($action == 'edit'): ?>
	<?= form_open_multipart('admin/do_edit_candidate/' . $candidate['id']); ?>
<?php endif; ?>
<h2><?= e('admin_' . $action . '_candidate_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td width="30%" align="right">
			<?= e('admin_candidate_first_name'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'first_name', 'value'=>$candidate['first_name'], 'style'=>'width:250px;')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_candidate_last_name'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'last_name', 'value'=>$candidate['last_name'], 'style'=>'width:250px;')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_candidate_description'); ?>:
		</td>
		<td width="70%">
			<?= form_textarea(array('name'=>'description', 'value'=>$candidate['description'], 'style'=>'width:250px;height:125px;')); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_candidate_party'); ?>:
		</td>
		<td width="70%">
			<?= form_dropdown('party_id', $parties, $candidate['party_id']); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_candidate_position'); ?>:
		</td>
		<td width="70%">
			<?= form_dropdown('position_id', $positions, $candidate['position_id']); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_candidate_picture'); ?>:
		</td>
		<td width="70%">
			<?= form_upload(array('name'=>'picture', 'size'=>30)); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?= anchor('admin/candidates', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_' . $action . '_candidate_submit')) ?>
</div>
<?= form_close(); ?>