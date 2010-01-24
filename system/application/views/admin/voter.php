<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php if ($action == 'add'): ?>
	<?php echo form_open('admin/voters/add', 'class="selectChosen"'); ?>
<?php elseif ($action == 'edit'): ?>
	<?php echo form_open('admin/voters/edit/' . $voter['id'], 'class="selectChosen"'); ?>
<?php endif; ?>
<h2><?php echo e('admin_' . $action . '_voter_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(($settings['password_pin_generation'] == 'email') ? e('admin_voter_email') : e('admin_voter_username') . ':', 'username'); ?>
		</td>
		<td>
			<?php echo form_input('username', set_value('username', $voter['username']), 'id="username" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_voter_last_name') . ':', 'last_name'); ?>
		</td>
		<td>
			<?php echo form_input('last_name', set_value('last_name', $voter['last_name']), 'id="last_name" maxlength="31" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_voter_first_name') . ':', 'first_name'); ?>
		</td>
		<td>
			<?php echo form_input('first_name', set_value('first_name', $voter['first_name']), 'id="first_name" maxlength="63" class="text"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_voter_elections'); ?>:
		</td>
		<td>
			<?php if (empty($elections)): ?>
			<em><?php echo e('admin_voter_no_elections'); ?></em>
			<?php else: ?>
				<table>
					<tr>
						<td>
							<?php echo form_dropdown('possible_elections[]', (count($possible_elections)) ? $possible_elections : array(), '', 'id="possible_elections" multiple="multiple" size="8" style="width : 210px;"'); ?>
							<br />
							<?php echo form_label(e('admin_voter_possible_elections'), 'possible_elections'); ?>
						</td>
						<td>
							<input type="button" class="copySelectedWithAjax" value="  &gt;&gt;  " />
							<br />
							<input type="button" class="copySelectedWithAjax" value="  &lt;&lt;  " />
						</td>
						<td>
							<?php echo form_dropdown('chosen_elections[]', (count($chosen_elections)) ? $chosen_elections : array(), '', 'id="chosen_elections" multiple="multiple" size="8" style="width : 210px;"'); ?>
							<br />
							<?php echo form_label(e('admin_voter_chosen_elections'), 'chosen_elections'); ?>
						</td>
					</tr>
				</table>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_voter_general_positions'); ?>:
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
			<?php echo e('admin_voter_specific_positions'); ?>:
		</td>
		<td>
			<table>
				<tr>
					<td>
						<?php echo form_dropdown('possible_positions[]', (count($possible_positions)) ? $possible_positions : array(), '', 'id="possible" multiple="multiple" size="8" style="width : 210px;"'); ?>
						<br />
						<?php echo form_label(e('admin_voter_possible_positions'), 'possible'); ?>
					</td>
					<td>
						<input type="button" class="copySelected" value="  &gt;&gt;  " />
						<br />
						<input type="button" class="copySelected" value="  &lt;&lt;  " />
					</td>
					<td>
						<?php echo form_dropdown('chosen_positions[]', (count($chosen_positions)) ? $chosen_positions : array(), '', 'id="chosen" multiple="multiple" size="8" style="width : 210px;"'); ?>
						<br />
						<?php echo form_label(e('admin_voter_chosen_positions'), 'chosen'); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php if ($action == 'edit'): ?>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_voter_regenerate'); ?>:
		</td>
		<td>
			<label for="password"><?php echo form_checkbox(array('id'=>'password', 'name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?php echo e('admin_voter_password'); ?></label>
			<?php if ($settings['pin']): ?>
				<label for="pin"><?php echo form_checkbox(array('id'=>'pin', 'name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?php echo e('admin_voter_pin'); ?></label>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
</table>
<div class="paging">
	<?php echo anchor('admin/voters', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_' . $action . '_voter_submit')) ?>
</div>
<?php echo form_close(); ?>
