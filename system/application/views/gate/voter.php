<?= format_messages($messages, $message_type); ?>
<?= form_open('gate/voter_login'); ?>
<div class="content_center">
	<h2><?= strtoupper($settings['name']) . ' ' . e('gate_voter_login_label'); ?></h2>
	<?php if ($option['status']): ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right"><label for="username"><?= e('gate_voter_username'); ?>:</label></td>
			<td><?= form_input(array('id'=>'username', 'name'=>'username', 'class'=>'text')); ?></td>
		</tr>
		<tr>
			<td align="right"><label for="password"><?= e('gate_voter_password'); ?>:</label></td>
			<td><?= form_password(array('id'=>'password', 'name'=>'password', 'class'=>'text')); ?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?= form_submit(array('value'=>e('gate_voter_login_button'))); ?></td>
		</tr>
	</table>
	<?php else: ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<?php if ($option['result']): ?>
		<tr>
			<td align="right"><?= img(array('src'=>'public/images/show.png', 'alt'=>'Show')); ?></td>
			<td><?= e('gate_voter_result'); ?></td>
		</tr>
		<?php else: ?>
		<tr>
			<td align="right"><?= img(array('src'=>'public/images/no.png', 'alt'=>'Not Running')); ?></td>
			<td><?= e('gate_voter_not_running'); ?></td>
		</tr>
		<?php endif; ?>
	</table>
	<?php endif; ?>
</div>
</form>
