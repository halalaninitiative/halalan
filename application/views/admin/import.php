<?php echo display_messages(validation_errors('<li>', '</li>'), $this->session->flashdata('messages')); ?>
<?php echo form_open_multipart('admin/voters/import', array('class'=>'selectChosen')); ?>
<h2><?php echo e('admin_import_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table" width="100%">
	<tr>
		<td class="w20" align="right">
			<?php echo form_label(e('admin_import_block') . ':' , 'block_id'); ?>
		</td>
		<td>
			<!-- form_dropdown and set_select don't work together :( -->
			<select name="block_id" id="block_id">
				<option value="">Select Block</option>
				<?php foreach ($blocks as $block): ?>
				<?php
					echo '<option value="' . $block['id'] . '"';
					echo set_select('block_id', $block['id']);
					echo '>' . $block['block'] . '</option>';
				?>
				<?php endforeach; ?>
			</select>
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
