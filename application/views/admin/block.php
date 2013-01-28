<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open('admin/blocks/add', 'class="selectChosen"'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open('admin/blocks/edit/' . $block['id'], 'class="selectChosen"'); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_block_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_block_block') . ':', 'block'); ?>
		</td>
		<td>
			<?php echo form_input('block', set_value('block', $block['block']), 'id="block" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_block_elections'); ?>:
		</td>
		<td>
			<?php if (empty($elections)): ?>
			<em><?php echo e('admin_block_no_elections'); ?></em>
			<?php else: ?>
				<table>
					<tr>
						<td>
							<?php echo form_dropdown('possible_elections[]', (count($possible_elections)) ? $possible_elections : array(), '', 'id="possible_elections" multiple="multiple" size="8" style="width : 210px;"'); ?>
							<br />
							<?php echo form_label(e('admin_block_possible_elections'), 'possible_elections'); ?>
						</td>
						<td>
							<input type="button" class="copySelectedWithAjax" value="  &gt;&gt;  " />
							<br />
							<input type="button" class="copySelectedWithAjax" value="  &lt;&lt;  " />
						</td>
						<td>
							<?php echo form_dropdown('chosen_elections[]', (count($chosen_elections)) ? $chosen_elections : array(), '', 'id="chosen_elections" multiple="multiple" size="8" style="width : 210px;"'); ?>
							<br />
							<?php echo form_label(e('admin_block_chosen_elections'), 'chosen_elections'); ?>
						</td>
					</tr>
				</table>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_block_general_positions'); ?>:
		</td>
		<td>
			<table>
				<tr>
					<td>
						<?php echo form_dropdown('general_positions[]', (count($general_positions)) ? $general_positions : array(), '', 'id="general_positions" multiple="multiple" size="8" style="width : 210px;" disabled="disabled"'); ?>
					</td>
					<td valign="top">
						Notes:<br />
						The number inside the () is an election ID.<br />
						Positions are related to elections via the election ID.
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_block_specific_positions'); ?>:
		</td>
		<td>
			<table>
				<tr>
					<td>
						<?php echo form_dropdown('possible_positions[]', (count($possible_positions)) ? $possible_positions : array(), '', 'id="possible" multiple="multiple" size="8" style="width : 210px;"'); ?>
						<br />
						<?php echo form_label(e('admin_block_possible_positions'), 'possible'); ?>
					</td>
					<td>
						<input type="button" class="copySelected" value="  &gt;&gt;  " />
						<br />
						<input type="button" class="copySelected" value="  &lt;&lt;  " />
					</td>
					<td>
						<?php echo form_dropdown('chosen_positions[]', (count($chosen_positions)) ? $chosen_positions : array(), '', 'id="chosen" multiple="multiple" size="8" style="width : 210px;"'); ?>
						<br />
						<?php echo form_label(e('admin_block_chosen_positions'), 'chosen'); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/blocks', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_block_submit')) ?>
</div>
<?php echo form_close(); ?>
