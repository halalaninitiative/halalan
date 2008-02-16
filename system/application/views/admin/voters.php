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
	<h2><?= e('admin_voters_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?= anchor('admin/add/voter', e('admin_voters_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0" class="table">
	<tr>
		<th width="5%" align="center">#</th>
		<th width="75%" align="center"><?= e('admin_voters_name'); ?></th>
		<th width="5%" align="center"><?= e('admin_voters_voted'); ?></th>
		<th width="15%" align="center"><?= e('common_action'); ?></th>
	</tr>
	<?php if (empty($voters)): ?>
	<tr>
		<td colspan="4" align="center"><em><?= e('admin_voters_no_voters'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php $j = $offset; ?>
	<?php foreach ($voters as $voter): ?>
	<tr class="<?= ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td width="5%" align="center"><?= ($j+1); ?></td>
		<td width="75%"><?= anchor('admin/edit/voter/' . $voter['id'], $voter['last_name'] . ', ' . $voter['first_name']); ?></td>
		<td width="5%" align="center">
			<?php if ($voter['voted'] == TRUE): ?>
			<img src="<?= base_url(); ?>public/images/ok.png" />
			<?php else: ?>
			<img src="<?= base_url(); ?>public/images/x.png" />
			<?php endif; ?>
		</td>
		<td width="15%" align="center"><?= anchor('admin/edit/voter/' . $voter['id'], '<img src="' . base_url() . 'public/images/edit.png" alt="' . e('common_edit') . '" />', 'title="' . e('common_edit') . '"'); ?> | <?= anchor('admin/delete/voter/' . $voter['id'], '<img src="' . base_url() . 'public/images/x.png" alt="' . e('common_delete') . '" />', 'title="' . e('common_delete') . '"'); ?></a></td>
	</tr>
	<?php $j++; ?>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>
<?php if (!empty($links)): ?>
<div class="paging">
	<?= $links; ?><br />
	Results <?= ($offset+1); ?> -
	<?php if (($offset+$limit) > $total_rows): ?>
		<?= $total_rows; ?>
	<?php else: ?>
		<?= ($offset+$limit); ?>
	<?php endif; ?>
	of <?= $total_rows; ?>.
</div>
<?php endif; ?>
<div class="notes">
	<h2>Advanced Options</h2>
	<ul>
		<li><?= anchor('admin/import', 'Import Voters'); ?></li>
		<li><?= anchor('admin/export', 'Export Voters'); ?></li>
	</ul>
</div>