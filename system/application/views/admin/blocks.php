<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<div class="content_left">
	<h2><?php echo e('admin_blocks_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right">
		<?php echo anchor('admin/blocks/add', e('admin_blocks_add')); ?>
		| View:
		<?php echo form_dropdown('election_id', array('' => 'Choose Election') + $elections, $election_id, 'class="changeElections" style="width: 130px;"'); ?>
	</p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5"><?php echo e('common_id'); ?></th>
		<th scope="col"><?php echo e('admin_blocks_block'); ?></th>
		<th scope="col" class="w45"><?php echo e('admin_blocks_description'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_actions'); ?></th>
	</tr>
	<?php if (empty($blocks)): ?>
	<tr>
		<td colspan="4" align="center"><em><?php echo e('admin_blocks_no_blocks'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($blocks as $block): ?>
	<tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?php echo $block['id']; ?>
		</td>
		<td>
			<?php echo anchor('admin/blocks/edit/' . $block['id'], $block['block']); ?>
		</td>
		<td>
			<?php echo nl2br($block['description']); ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/blocks/edit/' . $block['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/blocks/delete/' . $block['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>