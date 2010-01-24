<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php echo form_open_multipart('admin/voters/import', array('class'=>'selectChosen')); ?>
<h2><?php echo e('admin_import_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_import_elections'); ?>:
		</td>
		<td>
			<?php if (empty($elections)): ?>
			<em><?php echo e('admin_import_no_elections'); ?></em>
			<?php else: ?>
				<table>
					<tr>
						<td>
							<?php echo form_dropdown('possible_elections[]', (count($possible_elections)) ? $possible_elections : array(), '', 'id="possible_elections" multiple="multiple" size="8" style="width : 210px;"'); ?>
							<br />
							<?php echo form_label(e('admin_import_possible_elections'), 'possible_elections'); ?>
						</td>
						<td>
							<input type="button" class="copySelectedWithAjax" value="  &gt;&gt;  " />
							<br />
							<input type="button" class="copySelectedWithAjax" value="  &lt;&lt;  " />
						</td>
						<td>
							<?php echo form_dropdown('chosen_elections[]', (count($chosen_elections)) ? $chosen_elections : array(), '', 'id="chosen_elections" multiple="multiple" size="8" style="width : 210px;"'); ?>
							<br />
							<?php echo form_label(e('admin_import_chosen_elections'), 'chosen_elections'); ?>
						</td>
					</tr>
				</table>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_import_general_positions'); ?>:
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
			<?php echo e('admin_import_specific_positions'); ?>:
		</td>
		<td>
			<table>
				<tr>
					<td>
						<?php echo form_dropdown('possible_positions[]', (count($possible_positions)) ? $possible_positions : array(), '', 'id="possible" multiple="multiple" size="8" style="width : 210px;"'); ?>
						<br />
						<?php echo form_label(e('admin_import_possible_positions'), 'possible'); ?>
					</td>
					<td>
						<input type="button" class="copySelected" value="  &gt;&gt;  " />
						<br />
						<input type="button" class="copySelected" value="  &lt;&lt;  " />
					</td>
					<td>
						<?php echo form_dropdown('chosen_positions[]', (count($chosen_positions)) ? $chosen_positions : array(), '', 'id="chosen" multiple="multiple" size="8" style="width : 210px;"'); ?>
						<br />
						<?php echo form_label(e('admin_import_chosen_positions'), 'chosen'); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_import_csv') . ':', 'csv'); ?>
		</td>
		<td>
			<?php echo form_upload('csv', '', 'id="csv"'); ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_import_sample'); ?>:
		</td>
		<td>
			<?php if ($settings['password_pin_generation'] == 'web'): ?>
			Username,Last Name,First Name<br />
			user1,Suzumiya,Haruhi<br />
			user2,Izumi,Konata<br />
			user3,Etoh,Mei
			<?php elseif ($settings['password_pin_generation'] == 'email'): ?>
			Email,Last Name,First Name<br />
			user1@example.com,Suzumiya,Haruhi<br />
			user2@example.com,Izumi,Konata<br />
			user3@example.com,Etoh,Mei
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="w20" align="right">
			<?php echo e('admin_import_notes'); ?>:
		</td>
		<td>
			<?php if ($settings['password_pin_generation'] == 'web'): ?>
			Username
			<?php elseif ($settings['password_pin_generation'] == 'email'): ?>
			Email
			<?php endif; ?>
			must be unique.<br />
			Incomplete data will be disregarded.<br />
			Passwords <?php echo $settings['pin'] ? 'and pins ' : ''; ?>are not yet generated.<br />
			Use <?php echo anchor('admin/voters/export', 'Export Voters'); ?> to generate passwords<?php echo $settings['pin'] ? ' and pins' : ''; ?>.
		</td>
	</tr>
</table>
<div class="paging">
	<?php echo anchor('admin/voters', 'GO BACK'); ?>
	|
	<?php echo form_submit('submit', e('admin_import_submit')) ?>
</div>
<?php echo form_close(); ?>
