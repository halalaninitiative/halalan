<?= format_messages($messages, $message_type); ?>
<?php if ($action == 'add'): ?>
	<?= form_open('admin/do_add_voter', array('class'=>'selectChosen')); ?>
<?php elseif ($action == 'edit'): ?>
	<?= form_open('admin/do_edit_voter/' . $voter['id'], array('class'=>'selectChosen')); ?>
<?php endif; ?>
<h2><?= e('admin_' . $action . '_voter_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w30" align="right">
			<label for="username"><?= ($settings['password_pin_generation'] == 'email') ? e('admin_voter_email') : e('admin_voter_username'); ?>:</label>
		</td>
		<td>
			<?= form_input(array('id'=>'username', 'name'=>'username', 'value'=>$voter['username'], 'maxlength'=>63, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="last_name"><?= e('admin_voter_last_name'); ?>:</label>
		</td>
		<td>
			<?= form_input(array('id'=>'last_name', 'name'=>'last_name', 'value'=>$voter['last_name'], 'maxlength'=>31, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<label for="first_name"><?= e('admin_voter_first_name'); ?>:</label>
		</td>
		<td>
			<?= form_input(array('id'=>'first_name', 'name'=>'first_name', 'value'=>$voter['first_name'], 'maxlength'=>63, 'class'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?= e('admin_voter_general_positions'); ?>:
		</td>
		<td>
			<?php if (empty($general)): ?>
				<em><?= e('admin_voter_no_general_positions'); ?></em>
			<?php else: ?>
				<?php foreach ($general as $g): ?>
					<?= $g['position']; ?><br />
				<?php endforeach; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="w30" align="right">
			<?= e('admin_voter_specific_positions'); ?>:
		</td>
		<td>
			<?php if (empty($specific)): ?>
			<em><?= e('admin_voter_no_specific_positions'); ?></em>
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
	<?php if ($action == 'edit'): ?>
	<tr>
		<td class="w30" align="right">
			<?= e('admin_voter_regenerate'); ?>:
		</td>
		<td>
			<label for="password"><?= form_checkbox(array('id'=>'password', 'name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?= e('admin_voter_password'); ?></label>
			<?php if ($settings['pin']): ?>
				<label for="pin"><?= form_checkbox(array('id'=>'pin', 'name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?= e('admin_voter_pin'); ?></label>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
</table>
<div class="paging">
	<?= anchor('admin/voters', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_' . $action . '_voter_submit')) ?>
</div>
<?= form_close(); ?>
