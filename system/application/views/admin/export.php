<?= form_open_multipart('admin/do_export'); ?>
<h2><?= e('admin_export_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td class="w45">
			<label for="password">
			<?= form_checkbox(array('id'=>'password', 'name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			<?= e('admin_export_password'); ?>
			</label>
		</td>
		<td>
			(<?= e('admin_export_password_description'); ?>)
		</td>
	</tr>
	<?php if ($settings['pin']): ?>
	<tr>
		<td class="w45">
			<label for="pin">
			<?= form_checkbox(array('id'=>'pin', 'name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			<?= e('admin_export_pin'); ?>
			</label>
		</td>
		<td>
			(<?= e('admin_export_pin_description'); ?>)
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td class="w45">
			<label for="votes">
			<?= form_checkbox(array('id'=>'votes', 'name'=>'votes', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			<?= e('admin_export_votes'); ?>
			</label>
		</td>
		<td>
			(<?= e('admin_export_votes_description'); ?>)
		</td>
	</tr>
	<tr>
		<td class="w45">
			<label for="status">
			<?= form_checkbox(array('id'=>'status', 'name'=>'status', 'value'=>TRUE, 'checked'=>FALSE)); ?>
			<?= e('admin_export_status'); ?>
			</label>
		</td>
		<td>
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