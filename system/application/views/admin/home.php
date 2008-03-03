<?= format_messages($messages, $message_type); ?>
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
				<label><?= form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>TRUE, 'checked'=>(($option['status']) ? TRUE : FALSE))); ?> Running</label>
			</td>
			<td>
				<label><?= form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>FALSE, 'checked'=>(($option['status']) ? FALSE : TRUE))); ?> Not Running</label>
			</td>
		</tr>
		<tr class="results">
			<td align="right">
				Results:
			</td>
			<td>
				<label><?= form_checkbox(array('name'=>'result', 'value'=>TRUE, 'checked'=>(($option['result']) ? TRUE : FALSE))); ?> Publish results?</label>
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
