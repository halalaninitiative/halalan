<?php echo format_messages($messages, $message_type); ?>
<div class="content_left">
	<h2><?php echo e('admin_parties_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?php echo anchor('admin/add/party', e('admin_parties_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5">#</th>
		<th scope="col"><?php echo e('admin_parties_party'); ?></th>
		<th scope="col" class="w15"><?php echo e('admin_parties_alias'); ?></th>
		<th scope="col" class="w45"><?php echo e('admin_parties_description'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_action'); ?></th>
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
			<?php echo ($i+1); ?>
		</td>
		<td>
			<?php echo anchor('admin/edit/party/' . $party['id'], $party['party']); ?>
		</td>
		<td>
			<?php echo $party['alias']; ?>
		</td>
		<td>
			<?php echo nl2br($party['description']); ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/edit/party/' . $party['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/delete/party/' . $party['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>