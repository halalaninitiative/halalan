<?= format_messages($messages, $message_type); ?>
<?php if ($action == 'add'): ?>
	<?= form_open_multipart('admin/do_add/candidate'); ?>
<?php elseif ($action == 'edit'): ?>
	<?= form_open_multipart('admin/do_edit/candidate/' . $candidate['id']); ?>
<?php endif; ?>
<h2><?= e('admin_' . $action . '_candidate_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w30" align="right">
			<label for="last_name"><?= e('admin_candidate_last_name'); ?>:</label>
		</td>
		<td>
			<?= form_input(array('id'=>'last_name', 'name'=>'last_name', 'value'=>$candidate['last_name'], 'maxlength'=>31, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="first_name"><?= e('admin_candidate_first_name'); ?>:</label>
		</td>
		<td>
			<?= form_input(array('id'=>'first_name', 'name'=>'first_name', 'value'=>$candidate['first_name'], 'maxlength'=>63, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="alias"><?= e('admin_candidate_alias'); ?>:</label>
		</td>
		<td>
			<?= form_input(array('id'=>'alias', 'name'=>'alias', 'value'=>$candidate['alias'], 'maxlength'=>15, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="description"><?= e('admin_candidate_description'); ?>:</label>
		</td>
		<td>
			<?= form_textarea(array('id'=>'description', 'name'=>'description', 'value'=>$candidate['description'])); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="party_id"><?= e('admin_candidate_party'); ?>:</label>
		</td>
		<td>
			<?= form_dropdown('party_id', $parties, $candidate['party_id'], 'id="party_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="position_id"><?= e('admin_candidate_position'); ?>:</label>
		</td>
		<td>
			<?= form_dropdown('position_id', $positions, $candidate['position_id'], 'id="position_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?= e('admin_candidate_picture'); ?>:
		</td>
		<td>
			<?= form_upload(array('name'=>'picture')); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?= anchor('admin/candidates', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_' . $action . '_candidate_submit')) ?>
</div>
<?= form_close(); ?>