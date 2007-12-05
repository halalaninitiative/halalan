<?php if (isset($messages) && !empty($messages)): ?>
<div class="message">
	<div class="message_header"><?= e('message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $message; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>
<?= form_open('gate/voter_login'); ?>
<div class="body">
	<div class="center_body" style="text-align : center;">
		<fieldset style="width : 350px; margin : 0 auto;">
			<legend class="position"><?= e('gate_voter_login_label'); ?></legend>
			<?php if ($option['status']): ?>
			<table cellspacing="2" cellpadding="2" align="center">
				<tr>
					<td><?= e('gate_voter_username'); ?></td>
					<td><?= form_input(array('name'=>'username', 'maxlength'=>'63')); ?></td>
				</tr>
				<tr>
					<td><?= e('gate_voter_password'); ?></td>
					<td><?= form_password(array('name'=>'password')); ?></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><?= form_submit(array('value'=>e('gate_voter_login_button'))); ?></td>
				</tr>
			</table>
			<?php else: ?>
			<table cellspacing="2" cellpadding="2" align="center">
				<tr>
					<td><img src="<?= base_url(); ?>public/images/no.png" alt="Not Running" /></td>
					<td>The election is not running. Please wait for the election administrator to activate the election.</td>
				</tr>
				<?php if ($option['result']): ?>
				<tr>
					<td><img src="<?= base_url(); ?>public/images/show.png" alt="Show" /></td>
					<td>The result is now available! View it <?= anchor('', 'here'); ?>.</td>
				</tr>
				<?php endif; ?>
			</table>
			<?php endif; ?>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
</form>