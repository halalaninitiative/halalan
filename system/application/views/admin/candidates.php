<?= format_messages($messages, $message_type); ?>
<?php if (empty($positions)): ?>
<div class="content_left">
	<h2><?= e('admin_candidates_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?= anchor('admin/add/candidate', e('admin_candidates_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0" class="table">
	<tr>
		<th width="5%">#</th>
		<th width="30%"><?= e('admin_candidates_candidate'); ?></th>
		<th width="50%"><?= e('admin_candidates_description'); ?></th>
		<th width="15%"><?= e('common_action'); ?></th>
	</tr>
	<tr>
		<td colspan="4" align="center"><em><?= e('admin_candidates_no_candidates'); ?></em></td>
	</tr>
</table>
<?php else: ?>
<a href="#" class="manipulate_all_positions">expand all</a> | <a href="#" class="manipulate_all_positions">collapse all</a>
<br />
<br />
<?php foreach ($positions as $position): ?>
<div class="content_left">
	<h2><?= img(array('src'=>'public/images/minus.png', 'class'=>'toggle_position', 'alt'=>'Collapse', 'title'=>'Collapse')); ?> <?= $position['position']; ?> Candidates</h2>
</div>
<div class="content_right">
	<p class="align_right"><?= anchor('admin/add/candidate', e('admin_candidates_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0" class="table">
	<tr>
		<th width="5%">#</th>
		<th width="30%"><?= e('admin_candidates_candidate'); ?></th>
		<th width="50%"><?= e('admin_candidates_description'); ?></th>
		<th width="15%"><?= e('common_action'); ?></th>
	</tr>
	<?php if (empty($position['candidates'])): ?>
	<tr>
		<td colspan="4" align="center"><em><?= e('admin_candidates_no_candidates'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($position['candidates'] as $candidate): ?>
	<tr class="<?= ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td width="5%" align="center">
			<?= ($i+1); ?>
		</td>
		<td width="30%">
			<?= anchor('admin/edit/candidate/' . $candidate['id'], $candidate['last_name'] . ', ' . $candidate['first_name']); ?>
			<?php if (!empty($candidate['alias'])): ?>
			<?= '"' . $candidate['alias'] . '"'; ?>
			<?php endif; ?>
		</td>
		<td width="50%">
			<?= nl2br($candidate['description']); ?>
		</td>
		<td width="15%" align="center">
			<?= anchor('admin/edit/candidate/' . $candidate['id'], img(array('src'=>'public/images/edit.png', 'alt'=>e('common_edit'))), 'title="' . e('common_edit') . '"'); ?> |
			<?= anchor('admin/delete/candidate/' . $candidate['id'], img(array('src'=>'public/images/x.png', 'alt'=>e('common_delete'))), array('class'=>'confirm_delete', 'title'=>e('common_delete'))); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>
<?php endforeach; ?>
<a href="#" class="manipulate_all_positions">expand all</a> | <a href="#" class="manipulate_all_positions">collapse all</a>
<?php endif; ?>
