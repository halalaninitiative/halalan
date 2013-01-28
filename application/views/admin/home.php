<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<div class="content_left">
	<h2><?php echo e('admin_home_left_label'); ?></h2>
	<div class="notes">
		<h2><?php echo e('admin_home_manage_question'); ?></h2>
		<ul>
			<li><?php echo anchor('admin/elections', e('admin_home_manage_elections')); ?></li>
			<li><?php echo anchor('admin/positions', e('admin_home_manage_positions')); ?></li>
			<li><?php echo anchor('admin/parties', e('admin_home_manage_parties')); ?></li>
			<li><?php echo anchor('admin/candidates', e('admin_home_manage_candidates')); ?></li>
			<li><?php echo anchor('admin/blocks', e('admin_home_manage_blocks')); ?></li>
			<li><?php echo anchor('admin/voters', e('admin_home_manage_voters')); ?></li>
		</ul>
	</div>
</div>
<div class="content_right">
	<h2><?php echo e('admin_home_right_label'); ?></h2>
	<?php echo form_open('admin/home/do_regenerate'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right">
				<?php echo form_label($settings['password_pin_generation'] == 'email' ? e('admin_home_email') : e('admin_home_username'), 'username'); ?>
			</td>
			<td>
				<?php echo form_input('username', '', 'id="username" maxlength="63" class="text"'); ?>
			</td>
		</tr>
		<?php if ($settings['pin']): ?>
		<tr>
			<td align="right">
			</td>
			<td>
				<?php echo form_checkbox('pin', TRUE, FALSE, 'id="pin"'); ?>
				<?php echo form_label(e('admin_home_pin'), 'pin'); ?>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td align="right">
			</td>
			<td>
				<?php echo form_checkbox('login', TRUE, FALSE, 'id="login"'); ?>
				<?php echo form_label(e('admin_home_login'), 'login'); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<?php echo form_submit('submit', e('admin_home_submit')); ?>
			</td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</div>
<div style="clear:both;"></div>
