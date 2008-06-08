<?php echo format_messages($messages, $message_type); ?>
<?php echo form_open('gate/voter_login', array('class'=>'hashPassword')); ?>
<div class="content_center">
	<h2><?php echo strtoupper($settings['name']) . ' ' . e('gate_voter_login_label'); ?></h2>
	<?php if ($option['status']): ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right"><label for="username"><?php echo e('gate_voter_username'); ?>:</label></td>
			<td><?php echo form_input(array('id'=>'username', 'name'=>'username', 'maxlength'=>63, 'class'=>'text')); ?></td>
		</tr>
		<tr>
			<td align="right"><label for="password"><?php echo e('gate_voter_password'); ?>:</label></td>
			<td><?php echo form_password(array('id'=>'password', 'name'=>'password', 'maxlength'=>$settings['password_length'], 'class'=>'text')); ?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?php echo form_submit(array('value'=>e('gate_voter_login_button'))); ?></td>
		</tr>
	</table>
	<?php else: ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<?php if ($option['result']): ?>
		<tr>
			<td align="right"><?php echo img(array('src'=>'public/images/show.png', 'alt'=>'Show')); ?></td>
			<td><?php echo e('gate_voter_result'); ?></td>
		</tr>
		<?php else: ?>
		<tr>
			<td align="right"><?php echo img(array('src'=>'public/images/no.png', 'alt'=>'Not Running')); ?></td>
			<td><?php echo e('gate_voter_not_running'); ?></td>
		</tr>
		<?php endif; ?>
	</table>
	<?php endif; ?>
</div>
</form>
