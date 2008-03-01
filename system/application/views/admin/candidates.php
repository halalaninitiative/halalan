<?= format_messages($messages, $message_type); ?>
<?php if (empty($positions)): ?>
<div class="content_left">
	<h2><?= e('admin_candidates_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?= anchor('admin/add/candidate', e('admin_candidates_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5">#</th>
		<th scope="col"><?= e('admin_candidates_candidate'); ?></th>
		<th scope="col" class="w45"><?= e('admin_candidates_description'); ?></th>
		<th scope="col" class="w10"><?= e('common_action'); ?></th>
	</tr>
	<tr>
		<td colspan="4" align="center"><em><?= e('admin_candidates_no_candidates'); ?></em></td>
	</tr>
</table>
<?php else: ?>
<a href="#" class="manipulateAllPositions">expand all</a> | <a href="#" class="manipulateAllPositions">collapse all</a>
<br />
<br />
<?php foreach ($positions as $position): ?>
<div class="content_left">
	<h2><?= img(array('src'=>'public/images/minus.png', 'class'=>'togglePosition', 'alt'=>'Collapse', 'title'=>'Collapse')); ?> <?= $position['position']; ?> Candidates <span>(<?= count($position['candidates']); ?>)</span></h2>
</div>
<div class="content_right">
	<p class="align_right"><?= anchor('admin/add/candidate', e('admin_candidates_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5">#</th>
		<th scope="col"><?= e('admin_candidates_candidate'); ?></th>
		<th scope="col" class="w45"><?= e('admin_candidates_description'); ?></th>
		<th scope="col" class="w10"><?= e('common_action'); ?></th>
	</tr>
	<?php if (empty($position['candidates'])): ?>
	<tr>
		<td colspan="4" align="center"><em><?= e('admin_candidates_no_candidates'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($position['candidates'] as $candidate): ?>
	<tr class="<?= ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?= ($i+1); ?>
		</td>
		<td>
			<?= anchor('admin/edit/candidate/' . $candidate['id'], $candidate['last_name'] . ', ' . $candidate['first_name']); ?>
			<?php if (!empty($candidate['alias'])): ?>
			<?= '"' . $candidate['alias'] . '"'; ?>
			<?php endif; ?>
		</td>
		<td>
			<?= nl2br($candidate['description']); ?>
		</td>
		<td align="center">
			<?= anchor('admin/edit/candidate/' . $candidate['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?= anchor('admin/delete/candidate/' . $candidate['id'], img(array('src'=>'public/images/delete.png', 'alt'=>e('common_delete'))), array('class'=>'confirmDelete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>
<?php endforeach; ?>
<a href="#" class="manipulateAllPositions">expand all</a> | <a href="#" class="manipulateAllPositions">collapse all</a>
<?php endif; ?>
