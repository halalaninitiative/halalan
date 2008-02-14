<?php if (isset($messages) && !empty($messages)): ?>
<div class="positive">
	<ul>
		<?php foreach ($messages as $message): ?>
		<li><?= $message; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
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
<?php foreach ($positions as $position): ?>
<div class="content_left">
	<h2><?= $position['position']; ?> Candidates</h2>
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
		<td width="5%" align="center"><?= ($i+1); ?></td>
		<td width="30%">
			<?= anchor('admin/edit/candidate/' . $candidate['id'], $candidate['last_name'] . ', ' . $candidate['first_name']); ?>
			<?php if (!empty($candidate['alias'])): ?>
			<?= '"' . $candidate['alias'] . '"'; ?>
			<?php endif; ?>
		</td>
		<td width="50%">
			<?= nl2br($candidate['description']); ?>
		</td>
		<td width="15%" align="center"><?= anchor('admin/edit/candidate/' . $candidate['id'], '<img src="' . base_url() . 'public/images/edit.png" alt="' . e('common_edit') . '" />', 'title="' . e('common_edit') . '"'); ?> | <?= anchor('admin/delete/candidate/' . $candidate['id'], '<img src="' . base_url() . 'public/images/x.png" alt="' . e('common_delete') . '" />', 'title="' . e('common_delete') . '" onclick="confirmDelete(\'' . $candidate['last_name'] . ', ' . $candidate['first_name'] . '\', \'' . site_url('admin/delete/candidate/' . $candidate['id']) . '\');return false;"'); ?></a></td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>
<?php endforeach; ?>
<?php endif; ?>