<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<div class="content_left">
	<h2><?php echo e('admin_voters_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right">
		<?php echo anchor('admin/voters/add', e('admin_voters_add')); ?>
		| View:
		<?php echo form_dropdown('block_id', for_dropdown($blocks, 'id', 'block'), $block_id, 'class="changeBlocks" style="width: 130px;"'); ?>
	</p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5">#</th>
		<th scope="col"><?php echo e('admin_voters_name'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_actions'); ?></th>
	</tr>
	<?php if (empty($voters)): ?>
	<tr>
		<td colspan="3" align="center"><em><?php echo e('admin_voters_no_voters'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($voters as $voter): ?>
	<tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?php echo $i + 1; ?>
		</td>
		<td>
			<?php echo anchor('admin/voters/edit/' . $voter['id'], $voter['last_name'] . ', ' . $voter['first_name']); ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/voters/edit/' . $voter['id'], img(array('src' => 'public/images/edit.png', 'alt' => e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/voters/delete/' . $voter['id'], img(array('src' => 'public/images/delete.png', 'alt' => e('common_delete'))), 'class="confirmDelete" title="' . e('common_delete') . '"'); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>
<div class="notes">
	<h2>Advanced Options</h2>
	<ul>
		<li><?php echo anchor('admin/voters/generate', 'Generate Passwords'); ?></li>
		<li><?php echo anchor('admin/voters/import', 'Import Voters'); ?></li>
		<li><?php echo anchor('admin/voters/export', 'Export Voters'); ?></li>
	</ul>
</div>
