<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<div class="content_left">
	<h2><?php echo e('admin_elections_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?php echo anchor('admin/elections/add', e('admin_elections_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5"><?php echo e('common_id'); ?></th>
		<th scope="col"><?php echo e('admin_elections_election'); ?></th>
		<th scope="col" class="w20"><?php echo e('admin_elections_status'); ?></th>
		<th scope="col" class="w20"><?php echo e('admin_elections_results'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_actions'); ?></th>
	</tr>
	<?php if (empty($elections)): ?>
	<tr>
		<td colspan="5" align="center"><em><?php echo e('admin_elections_no_elections'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($elections as $election): ?>
	<tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?php echo $election['id']; ?>
		</td>
		<td>
			<?php if ($election['parent_id'] > 0): ?>
			&nbsp;&nbsp;
			<?php endif; ?>
			<?php echo anchor('admin/elections/edit/' . $election['id'], $election['election']); ?>
		</td>
		<td align="center">
			<?php if ($election['status']): ?>
				Running (<?php echo anchor('admin/elections/options/status/' . $election['id'], 'stop'); ?>)
			<?php else: ?>
				Not Running (<?php echo anchor('admin/elections/options/status/' . $election['id'], 'start'); ?>)
			<?php endif; ?>
		</td>
		<td align="center">
			<?php if ($election['results']): ?>
				Available (<?php echo anchor('admin/elections/options/results/' . $election['id'], 'hide'); ?>)
			<?php else: ?>
				Not Available (<?php echo anchor('admin/elections/options/results/' . $election['id'], 'show'); ?>)
			<?php endif; ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/elections/edit/' . $election['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/elections/delete/' . $election['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>