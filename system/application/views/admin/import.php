<?php if (isset($messages) && !empty($messages)): ?>
<div class="positive">
	<ul>
		<?php foreach ($messages as $message): ?>
		<li><?= $message; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
<?= form_open_multipart('admin/do_import', array('onsubmit'=>'allSelect();')); ?>
<h2><?= e('admin_import_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td width="30%" align="right">
			<?= e('admin_import_general_positions'); ?>:
		</td>
		<td width="70%">
			<?php if (empty($general)): ?>
				<em><?= e('admin_import_no_general_positions'); ?></em>
			<?php else: ?>
				<?php foreach ($general as $g): ?>
					<?= $g['position']; ?><br />
				<?php endforeach; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_import_specific_positions'); ?>:
		</td>
		<td width="70%">
			<?php if (empty($specific)): ?>
			<em><?= e('admin_import_no_specific_positions'); ?></em>
			<?php else: ?>
				<table>
					<tr>
						<td><?= form_dropdown('possible[]', $possible, '', 'id="possible" multiple="true" size="5" style="width : 150px;"'); ?><br /><?= e('admin_import_possible_positions'); ?></td>
						<td><input type="button" onclick="copyToList('possible','chosen');" value="  &gt;&gt;  " /><br /><input type="button" onclick="copyToList('chosen','possible');" value="  &lt;&lt;  " /></td>
						<td><?= form_dropdown('chosen[]', $chosen, '', 'id="chosen" multiple="true" size="5" style="width : 150px;"'); ?><br /><?= e('admin_import_chosen_positions'); ?></td>
					</tr>
				</table>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right">
			<?= e('admin_import_csv'); ?>:
		</td>
		<td width="70%">
			<?= form_upload(array('name'=>'csv', 'size'=>30)); ?>
		</td>
	</tr>
</table>
<div class="paging">
	<?= anchor('admin/voters', 'GO BACK'); ?>
	|
	<?= form_submit('submit', e('admin_import_submit')) ?>
</div>
<?= form_close(); ?>