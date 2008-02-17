<?= format_messages($messages, $message_type); ?>
<?= form_open_multipart('admin/do_export'); ?>
<h2><?= e('admin_export_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td width="30%" align="right">
			<?= e('admin_export_password'); ?>
		</td>
		<td width="70%">
			<?= form_checkbox(array('name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			(<?= e('admin_export_password_description'); ?>)
		</td>
	</tr>
	<?php if ($settings['pin']): ?>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_export_pin'); ?>
		</td>
		<td width="70%">
			<?= form_checkbox(array('name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			(<?= e('admin_export_pin_description'); ?>)
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_export_votes'); ?>
		</td>
		<td width="70%">
			<?= form_checkbox(array('name'=>'votes', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			(<?= e('admin_export_votes_description'); ?>)
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_export_status'); ?>
		</td>
		<td width="70%">
			<?= form_checkbox(array('name'=>'status', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			(<?= e('admin_export_status_description'); ?>)
		</td>
	</tr>
</table>
<div class="paging">
	<?= anchor('admin/voters', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_export_submit')) ?>
</div>
<?= form_close(); ?>