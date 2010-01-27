<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<div class="content_left">
	<h2><?php echo e('admin_positions_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right">
		<?php echo anchor('admin/positions/add', e('admin_positions_add')); ?>
		| View:
		<?php echo form_dropdown('election_id', array(''=>'Choose Election') + $elections, $election_id, 'class="changeElections" style="width: 130px;"'); ?>
	</p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5"><?php echo e('common_id'); ?></th>
		<th scope="col"><?php echo e('admin_positions_position'); ?></th>
		<th scope="col" class="w45"><?php echo e('admin_positions_description'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_actions'); ?></th>
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
			<?php echo $position['id']; ?>
		</td>
		<td>
			<?php echo anchor('admin/positions/edit/' . $position['id'], $position['position']); ?>
		</td>
		<td>
			<?php echo nl2br($position['description']); ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/positions/edit/' . $position['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/positions/delete/' . $position['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>