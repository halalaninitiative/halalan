<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open_multipart('admin/candidates/add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open_multipart('admin/candidates/edit/' . $candidate['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_candidate_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_election') . ':' , 'election_id'); ?>
		</td>
		<td>
			<?php echo form_dropdown('election_id', for_dropdown($elections, 'id', 'election'), set_value('election_id', $candidate['election_id']), 'id="election_id" class="fillPositionsAndParties"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_position') . ':' , 'position_id'); ?>
		</td>
		<td>
			<?php echo form_dropdown('position_id', for_dropdown($positions, 'id', 'position'), set_value('position_id', $candidate['position_id']), 'id="position_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_party') . ':' , 'party_id'); ?>
		</td>
		<td>
			<?php echo form_dropdown('party_id', for_dropdown($parties, 'id', 'party'), set_value('party_id', $candidate['party_id']), 'id="party_id"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_first_name') . ':', 'first_name'); ?>
		</td>
		<td>
			<?php echo form_input('first_name', set_value('first_name', $candidate['first_name']), 'id="first_name" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_alias') . ':', 'alias'); ?>
		</td>
		<td>
			<?php echo form_input('alias', set_value('alias', $candidate['alias']), 'id="alias" maxlength="15" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_last_name') . ':', 'last_name'); ?>
		</td>
		<td>
			<?php echo form_input('last_name', set_value('last_name', $candidate['last_name']), 'id="last_name" maxlength="31" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_description') . ':', 'description'); ?>
		</td>
		<td>
			<?php echo form_textarea('description', set_value('description', $candidate['description']), 'id="description"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_candidate_picture') . ':', 'picture'); ?>
		</td>
		<td>
			<?php echo form_upload('picture', '', 'id="picture"'); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/candidates', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_candidate_submit')) ?>
</div>
<?php echo form_close(); ?>