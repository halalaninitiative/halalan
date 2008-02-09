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
	<h2><?= e('admin_positions_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?= anchor('admin/add/position', e('admin_positions_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0" class="table">
	<tr>
		<th width="30%"><?= e('admin_positions_position'); ?></th>
		<th width="55%"><?= e('admin_positions_description'); ?></th>
		<th width="15%"><?= e('common_action'); ?></th>
	</tr>
	<?php if (empty($positions)): ?>
	<tr>
		<td colspan="3" align="center"><em><?= e('admin_positions_no_positions'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($positions as $position): ?>
	<tr class="<?= ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td width="30%">
			<?= anchor('admin/edit/position/' . $position['id'], $position['position']); ?>
		</td>
		<td width="55%">
			<?= nl2br($position['description']); ?>
		</td>
		<td width="15%" align="center"><?= anchor('admin/edit/position/' . $position['id'], '<img src="' . base_url() . 'public/images/edit.png" alt="' . e('common_edit') . '" />', 'title="' . e('common_edit') . '"'); ?> | <?= anchor('admin/delete/position/' . $position['id'], '<img src="' . base_url() . 'public/images/x.png" alt="' . e('common_delete') . '" />', 'title="' . e('common_delete') . '" onclick="confirmDelete(\'' . $position['position'] . '\', \'' . site_url('admin/delete/position/' . $position['id']) . '\');return false;"'); ?></a></td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>