<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<?php if (empty($positions)): ?>
<div class="content_left">
	<h2><?php echo e('admin_candidates_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right">
		<?php echo anchor('admin/candidates/add', e('admin_candidates_add')); ?>
		| View:
		<?php echo form_dropdown('election_id', array(''=>'Choose Election') + $elections, $election_id, 'class="changeElections" style="width: 130px;"'); ?>
		<?php echo form_dropdown('position_id', array(''=>'All Positions') + $pos, $position_id, 'class="changePositions" style="width: 100px;"'); ?>
	</p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5">#</th>
		<th scope="col"><?php echo e('admin_candidates_candidate'); ?></th>
		<th scope="col" class="w45"><?php echo e('admin_candidates_description'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_actions'); ?></th>
	</tr>
	<tr>
		<td colspan="4" align="center"><em><?php echo e('admin_candidates_no_candidates'); ?></em></td>
	</tr>
</table>
<?php else: ?>
<div class="content_left">
	<p>
		<a href="#" class="manipulateAllPositions">expand all</a> | <a href="#" class="manipulateAllPositions">collapse all</a>
	</p>
</div>
<div class="content_right">
	<p class="align_right">
		<?php echo anchor('admin/candidates/add', e('admin_candidates_add')); ?>
		| View:
		<?php echo form_dropdown('election_id', array(''=>'Choose Election') + $elections, $election_id, 'class="changeElections" style="width: 130px;"'); ?>
		<?php echo form_dropdown('position_id', array(''=>'All Positions') + $pos, $position_id, 'class="changePositions" style="width: 100px;"'); ?>
	</p>
</div>
<div class="clear"></div>
<?php foreach ($positions as $position): ?>
<div class="content_left">
	<h2><?php echo img(array('src'=>'public/images/minus.png', 'class'=>'togglePosition pointer', 'alt'=>'Collapse', 'title'=>'Collapse')); ?> <?php echo $position['position']; ?> Candidates <span>(<?php echo count($position['candidates']); ?>)</span></h2>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5">#</th>
		<th scope="col"><?php echo e('admin_candidates_candidate'); ?></th>
		<th scope="col" class="w45"><?php echo e('admin_candidates_description'); ?></th>
		<th scope="col" class="w10"><?php echo e('common_actions'); ?></th>
	</tr>
	<?php if (empty($position['candidates'])): ?>
	<tr>
		<td colspan="4" align="center"><em><?php echo e('admin_candidates_no_candidates'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($position['candidates'] as $candidate): ?>
	<tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?php echo ($i+1); ?>
		</td>
		<td>
			<?php echo anchor('admin/candidates/edit/' . $candidate['id'], $candidate['last_name'] . ', ' . $candidate['first_name']); ?>
			<?php if (!empty($candidate['alias'])): ?>
			<?php echo '"' . $candidate['alias'] . '"'; ?>
			<?php endif; ?>
		</td>
		<td>
			<?php echo nl2br($candidate['description']); ?>
		</td>
		<td align="center">
			<?php echo anchor('admin/candidates/edit/' . $candidate['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?php echo anchor('admin/candidates/delete/' . $candidate['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>
<?php endforeach; ?>
<div class="content_left">
	<p>
		<a href="#" class="manipulateAllPositions">expand all</a> | <a href="#" class="manipulateAllPositions">collapse all</a>
	</p>
</div>
<div class="clear"></div>
<?php endif; ?>
