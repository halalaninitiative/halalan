<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<div class="content_left">
	<h2><?php echo e('admin_parties_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?php echo anchor('admin/parties/add', e('admin_parties_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5"><?php echo e('common_id'); ?></th>
		<th scope="col"><?php echo e('admin_parties_party'); ?></th>
		<th scope="col" class="w15"><?php echo e('admin_parties_alias'); ?></th>
		<th scope="col" class="w45"><?php echo e('admin_parties_description'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_actions'); ?></th>
	</tr>
	<?php if (empty($parties)): ?>
	<tr>
		<td colspan="5" align="center"><em><?php echo e('admin_parties_no_parties'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($parties as $party): ?>
	<tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?php echo $party['id']; ?>
		</td>
		<td>
			<?php echo anchor('admin/parties/edit/' . $party['id'], $party['party']); ?>
		</td>
		<td>
			<?php echo $party['alias']; ?>
		</td>
		<td>
			<?php echo nl2br($party['description']); ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/parties/edit/' . $party['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/parties/delete/' . $party['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>