<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<?php echo form_open('gate/admin_login', 'class="hashPassword"'); ?>
<div class="content_center">
	<h2><?php echo 'HALALAN ' . e('gate_admin_login_label'); ?></h2>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right"><?php echo form_label(e('gate_admin_username'), 'username'); ?>:</td>
			<td><?php echo form_input('username', '', 'id="username" maxlength="63" class="text"'); ?></td>
		</tr>
		<tr>
			<td align="right"><?php echo form_label(e('gate_admin_password'), 'password'); ?>:</label></td>
			<td><?php echo form_password('password', '', 'id="password" class="text"'); ?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?php echo form_submit('submit', e('gate_admin_login_button')); ?></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				view:
				<?php echo anchor('gate/results', 'results'); ?> |
				<?php echo anchor('gate/statistics', 'statistics'); ?> |
				<?php echo anchor('gate/ballots', 'ballots'); ?>
			</td>
		</tr>
	</table>
</div>
</form>
