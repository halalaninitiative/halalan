<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open('admin/elections/add'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open('admin/elections/edit/' . $election['id']); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_election_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_election_election') . ':', 'election'); ?>
		</td>
		<td>
			<?php echo form_input('election', set_value('election', $election['election']), 'id="election" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_election_parent') . ':', 'parent_id'); ?>
		</td>
		<td>
			<!-- form_dropdown and set_select don't work together :( -->
			<select name="parent_id" id="parent_id">
				<option value="0">No Parent</option>
				<?php foreach ($parents as $parent): ?>
				<?php
					if ($parent['id'] != $election['id'])
					{
						echo '<option value="' . $parent['id'] . '"';
						echo set_select('parent_id', $parent['id'], $election['parent_id'] == $parent['id'] ? TRUE : FALSE);
						echo '>' . $parent['election'] . '</option>';
					}
				?>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_election_notes'); ?>:
		</td>
		<td>
			Starting/stopping a parent election will also start/stop all its children election.<br />
			On the other hand, starting/stopping a child election will only start/stop itself.<br />
			As of now, only two-level (parent-child) elections are possible.
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/elections', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_election_submit')) ?>
</div>
<?php echo form_close(); ?>