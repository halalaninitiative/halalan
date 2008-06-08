<?php echo format_messages($messages, $message_type); ?>
<div class="content_left">
	<h2><?php echo e('admin_positions_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?php echo anchor('admin/add/position', e('admin_positions_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5">#</th>
		<th scope="col"><?php echo e('admin_positions_position'); ?></th>
		<th scope="col" class="w45"><?php echo e('admin_positions_description'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_action'); ?></th>
	</tr>
	<?php if (empty($positions)): ?>
	<tr>
		<td colspan="4" align="center"><em><?php echo e('admin_positions_no_positions'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($positions as $position): ?>
	<tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?php echo ($i+1); ?>
		</td>
		<td>
			<?php echo anchor('admin/edit/position/' . $position['id'], $position['position']); ?>
		</td>
		<td>
			<?php echo nl2br($position['description']); ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/edit/position/' . $position['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/delete/position/' . $position['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>