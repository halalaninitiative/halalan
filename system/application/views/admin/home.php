<?php if (isset($messages) && !empty($messages)): ?>
<div class="positive">
	<ul>
		<?php foreach ($messages as $message): ?>
		<li><?= $message; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
<div class="content_left">
	<h2><?= e('admin_home_left_label'); ?></h2>
	<div class="notes">
		<h2>What do you want to do?</h2>
		<ul>
			<li><?= anchor('admin/candidates', 'Manage Candidates'); ?></li>
			<li><?= anchor('admin/parties', 'Manage Parties'); ?></li>
			<li><?= anchor('admin/positions', 'Manage Positions'); ?></li>
			<li><?= anchor('admin/voters', 'Manage Voters'); ?></li>
		</ul>
	</div>
</div>
<div class="content_right">
	<h2><?= e('admin_home_right_label'); ?></h2>
	<?= form_open('admin/do_edit_option/1'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right">
				Status:
			</td>
			<td>
				<?= form_radio(array('name'=>'status', 'value'=>TRUE, 'checked'=>(($option['status']) ? TRUE : FALSE))); ?> Running
			</td>
			<td>
				<?= form_radio(array('name'=>'status', 'value'=>FALSE, 'checked'=>(($option['status']) ? FALSE : TRUE))); ?> Not Running
			</td>
		</tr>
		<tr class="result">
			<td align="right">
				Result:
			</td>
			<td>
				<?= form_radio(array('name'=>'result', 'value'=>TRUE, 'checked'=>(($option['result']) ? TRUE : FALSE))); ?> Show
			</td>
			<td>
				<?= form_radio(array('name'=>'result', 'value'=>FALSE, 'checked'=>(($option['result']) ? FALSE : TRUE))); ?> Hide
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<?= form_submit(array('name'=>'submit', 'value'=>'Save')); ?>
			</td>
		</tr>
	</table>
	<?= form_close(); ?>
</div>
<div style="clear:both;"></div>