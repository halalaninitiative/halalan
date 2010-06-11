<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<?php echo form_open('gate/voter_login', array('class'=>'hashPassword')); ?>
<div class="content_center">
	<h2><?php echo 'HALALAN ' . e('gate_voter_login_label'); ?></h2>
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
		<tr>
			<td colspan="2" align="center"><?php echo anchor('gate/results', 'results'); ?> | <?php echo anchor('gate/statistics', 'statistics'); ?></td>
		</tr>
	</table>
</div>
</form>
