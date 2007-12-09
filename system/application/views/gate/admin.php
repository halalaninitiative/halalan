<?php if (isset($messages) && !empty($messages)): ?>
<div class="message">
	<div class="message_header"><?= e('common_message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $message; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>
<?= form_open('gate/admin_login'); ?>
<div class="body">
	<div class="center_body" style="text-align : center;">
		<fieldset style="width : 350px; margin : 0 auto;">
			<legend class="position"><?= e('gate_admin_login_label'); ?></legend>
			<table cellspacing="2" cellpadding="2" align="center">
				<tr>
					<td><?= e('gate_admin_username'); ?></td>
					<td><?= form_input(array('name'=>'username', 'maxlength'=>'63')); ?></td>
				</tr>
				<tr>
					<td><?= e('gate_admin_password'); ?></td>
					<td><?= form_password(array('name'=>'password')); ?></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><?= form_submit(array('value'=>e('gate_admin_login_button'))); ?></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
</form>