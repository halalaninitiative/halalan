<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open_multipart('admin/positions/add', array('class'=>'selectChosen')); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open_multipart('admin/positions/edit/' . $position['id'], array('class'=>'selectChosen')); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_position_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_position') . ':', 'position'); ?>
		</td>
		<td>
			<?php echo form_input('position', set_value('position', $position['position']), 'id="position" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_description') . ':', 'description'); ?>
		</td>
		<td>
			<?php echo form_textarea('description', set_value('description', $position['description']), 'id="description"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_maximum') . ':', 'maximum'); ?>
		</td>
		<td>
			<?php echo form_input('maximum', set_value('maximum', $position['maximum']), 'id="maximum" class="short"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_position_ordinality') . ':', 'ordinality'); ?>
		</td>
		<td>
			<?php echo form_input('ordinality', set_value('ordinality', $position['ordinality']), 'id="ordinality" class="short"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_position_abstain'); ?>:
		</td>
		<td>
			<?php echo form_radio('abstain', '1', $position['abstain'] ? TRUE : FALSE, 'id="yes"'); ?>
			<?php echo form_label('Yes', 'yes'); ?>
			<?php echo form_radio('abstain', '0', $position['abstain'] ? FALSE : TRUE, 'id="no"'); ?>
			<?php echo form_label('No', 'no'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_position_unit'); ?>:
		</td>
		<td>
			<?php echo form_radio('unit', '0', $position['unit'] ? FALSE : TRUE, 'id="general"'); ?>
			<?php echo form_label('General', 'general'); ?>
			<?php echo form_radio('unit', '1', $position['unit'] ? TRUE : FALSE, 'id="specific"'); ?>
			<?php echo form_label('Specific', 'specific'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php //echo e('admin_voter_specific_positions'); ?>Elections:
		</td>
		<td>
			<?php if (empty($elections)): ?>
			<em><?php //echo e('admin_voter_no_specific_positions'); ?>No elections found.</em>
			<?php else: ?>
				<table>
					<tr>
						<td>
							<?php echo form_dropdown('possible[]', (count($possible)) ? $possible : array(), '', 'id="possible" multiple="multiple" size="7" style="width : 170px;"'); ?>
							<br />
							<?php echo form_label(e('admin_position_possible_elections'), 'possible'); ?>
						</td>
						<td>
							<input type="button" class="copySelected" value="  &gt;&gt;  " />
							<br />
							<input type="button" class="copySelected" value="  &lt;&lt;  " />
						</td>
						<td>
							<?php echo form_dropdown('chosen[]', (count($chosen)) ? $chosen : array(), '', 'id="chosen" multiple="multiple" size="7" style="width : 170px;"'); ?>
							<br />
							<?php echo form_label(e('admin_position_chosen_elections'), 'chosen'); ?>
						</td>
					</tr>
				</table>
			<?php endif; ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/positions', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_position_submit')) ?>
</div>
<?php echo form_close(); ?>