<?= format_messages($messages, $message_type); ?>
<?= form_open_multipart('admin/do_import', array('class'=>'selectChosen')); ?>
<h2><?= e('admin_import_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w30" align="right">
			<?= e('admin_import_general_positions'); ?>:
		</td>
		<td>
			<?php if (empty($general)): ?>
				<em><?= e('admin_import_no_general_positions'); ?></em>
			<?php else: ?>
				<?php foreach ($general as $g): ?>
					<?= $g['position']; ?><br />
				<?php endforeach; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?= e('admin_import_specific_positions'); ?>:
		</td>
		<td>
			<?php if (empty($specific)): ?>
			<em><?= e('admin_import_no_specific_positions'); ?></em>
			<?php else: ?>
				<table>
					<tr>
						<td><?= form_dropdown('possible[]', (count($possible)) ? $possible : array(''=>''), '', 'id="possible" multiple="multiple" size="5" style="width : 150px;"'); ?><br /><label for="possible"><?= e('admin_voter_possible_positions'); ?></label></td>
						<td><input type="button" class="copySelected" value="  &gt;&gt;  " /><br /><input type="button" class="copySelected" value="  &lt;&lt;  " /></td>
						<td><?= form_dropdown('chosen[]', (count($chosen)) ? $chosen : array(''=>''), '', 'id="chosen" multiple="multiple" size="5" style="width : 150px;"'); ?><br /><label for="chosen"><?= e('admin_voter_chosen_positions'); ?></label></td>
					</tr>
				</table>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?= e('admin_import_csv'); ?>:
		</td>
		<td>
			<?= form_upload(array('name'=>'csv', 'size'=>30)); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?= e('admin_import_sample'); ?>:
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
		<td class="w30" align="right">
			<?= e('admin_import_notes'); ?>:
		</td>
		<td>
			<?php if ($settings['password_pin_generation'] == 'web'): ?>
			Username
			<?php elseif ($settings['password_pin_generation'] == 'email'): ?>
			Email
			<?php endif; ?>
			must be unique.<br />
			Incomplete data will be disregarded.
		</td>
	</tr>
</table>
<div class="paging">
	<?= anchor('admin/voters', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_import_submit')) ?>
</div>
<?= form_close(); ?>
