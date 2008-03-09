<?= format_messages($messages, $message_type); ?>
<div class="content_left">
	<?php if ($option['status']): ?>
	<h2><?= e('admin_home_left_label_too'); ?></h2>
	<?= form_open('admin/do_regenerate'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right">
				<label for="username"><?= ($settings['password_pin_generation'] == 'email') ? e('admin_home_email') : e('admin_home_username'); ?>:</label>
			</td>
			<td>
				<?= form_input(array('id'=>'username', 'name'=>'username', 'value'=>'', 'class'=>'text')); ?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?= e('admin_home_regenerate'); ?>:
			</td>
			<td>
				<label for="password"><?= form_checkbox(array('id'=>'password', 'name'=>'password', 'value'=>1, 'checked'=>FALSE)); ?> <?= e('admin_home_password'); ?></label>
				<?php if ($settings['pin']): ?>
					<label for="pin"><?= form_checkbox(array('id'=>'pin', 'name'=>'pin', 'value'=>1, 'checked'=>FALSE)); ?> <?= e('admin_home_pin'); ?></label>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<?= form_submit(array('name'=>'submit', 'value'=>e('admin_home_submit_too'))); ?>
			</td>
		</tr>
	</table>
	<?= form_close(); ?>
	<?php else: ?>
	<h2><?= e('admin_home_left_label'); ?></h2>
	<div class="notes">
		<h2><?= e('admin_home_manage_question'); ?></h2>
		<ul>
			<li><?= anchor('admin/candidates', e('admin_home_manage_candidates')); ?></li>
			<li><?= anchor('admin/parties', e('admin_home_manage_parties')); ?></li>
			<li><?= anchor('admin/positions', e('admin_home_manage_positions')); ?></li>
			<li><?= anchor('admin/voters', e('admin_home_manage_voters')); ?></li>
		</ul>
	</div>
	<?php endif; ?>
</div>
<div class="content_right">
	<h2><?= e('admin_home_right_label'); ?></h2>
	<?= form_open('admin/do_edit_option/1'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right">
				<?= e('admin_home_status'); ?>:
			</td>
			<td>
				<label><?= form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>1, 'checked'=>(($option['status']) ? TRUE : FALSE))); ?> <?= e('admin_home_running'); ?></label>
			</td>
			<td>
				<label><?= form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>0, 'checked'=>(($option['status']) ? FALSE : TRUE))); ?> <?= e('admin_home_not_running'); ?></label>
			</td>
		</tr>
		<tr class="results">
			<td align="right">
				<?= e('admin_home_results'); ?>:
			</td>
			<td>
				<label><?= form_checkbox(array('name'=>'result', 'value'=>1, 'checked'=>(($option['result']) ? TRUE : FALSE))); ?> <?= e('admin_home_publish'); ?></label>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<?= form_submit(array('name'=>'submit', 'value'=>e('admin_home_submit'))); ?>
			</td>
		</tr>
	</table>
	<?= form_close(); ?>
</div>
<div style="clear:both;"></div>
