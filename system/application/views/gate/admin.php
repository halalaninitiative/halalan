<?= format_messages($messages, $message_type); ?>
<?= form_open('gate/admin_login'); ?>
<div class="content_center">
	<h2><?= strtoupper($settings['name']) . ' ' . e('gate_admin_login_label'); ?></h2>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right"><label for="username"><?= e('gate_admin_username'); ?>:</label></td>
			<td><?= form_input(array('id'=>'username', 'name'=>'username', 'maxlength'=>63, 'class'=>'text')); ?></td>
		</tr>
		<tr>
			<td align="right"><label for="password"><?= e('gate_admin_password'); ?>:</label></td>
			<td><?= form_password(array('id'=>'password', 'name'=>'password', 'maxlength'=>$settings['password_length'], 'class'=>'text')); ?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?= form_submit(array('value'=>e('gate_admin_login_button'))); ?></td>
		</tr>
	</table>
</div>
</form>
