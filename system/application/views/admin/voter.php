<?php if (isset($messages) && !empty($messages)): ?>
<div class="positive">
	<ul>
		<?php foreach ($messages as $message): ?>
		<li><?= $message; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
<?php if ($action == 'add'): ?>
	<?= form_open('admin/do_add_voter', array('onsubmit'=>'allSelect();')); ?>
<?php elseif ($action == 'edit'): ?>
	<?= form_open('admin/do_edit_voter/' . $voter['id'], array('onsubmit'=>'allSelect();')); ?>
<?php endif; ?>
<h2><?= e('admin_' . $action . '_voter_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td width="30%" align="right">
			<?= ($settings['password_pin_generation'] == 'email') ? e('admin_voter_email') : e('admin_voter_username'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'username', 'value'=>$voter['username'])); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_voter_first_name'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'first_name', 'value'=>$voter['first_name'])); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_voter_last_name'); ?>:
		</td>
		<td width="70%">
			<?= form_input(array('name'=>'last_name', 'value'=>$voter['last_name'])); ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_voter_general_positions'); ?>:
		</td>
		<td width="70%">
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
		<td width="30%" align="right">
			<?= e('admin_voter_specific_positions'); ?>:
		</td>
		<td width="70%">
			<?php if (empty($specific)): ?>
			<em><?= e('admin_voter_no_specific_positions'); ?></em>
			<?php else: ?>
				<table>
					<tr>
						<td><?= form_dropdown('possible[]', $possible, '', 'id="possible" multiple="true" size="5" style="width : 150px;"'); ?><br /><?= e('admin_voter_possible_positions'); ?></td>
						<td><input type="button" onclick="copyToList('possible','chosen');" value="  &gt;&gt;  " /><br /><input type="button" onclick="copyToList('chosen','possible');" value="  &lt;&lt;  " /></td>
						<td><?= form_dropdown('chosen[]', $chosen, '', 'id="chosen" multiple="true" size="5" style="width : 150px;"'); ?><br /><?= e('admin_voter_chosen_positions'); ?></td>
					</tr>
				</table>
			<?php endif; ?>
		</td>
	</tr>
	<?php if ($action == 'edit'): ?>
	<tr>
		<td width="30%">
			<?= e('admin_voter_regenerate'); ?>:
		</td>
		<td width="70%">
			<?= form_checkbox(array('name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?= e('admin_voter_password'); ?>
			<?php if ($settings['pin']): ?>
				<?= form_checkbox(array('name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?= e('admin_voter_pin'); ?>
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