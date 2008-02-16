<?php if (isset($messages) && !empty($messages)): ?>
<div class="positive">
	<ul>
		<?php foreach ($messages as $message): ?>
		<li><?= $message; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
<div class="content_left">
	<h2><?= e('admin_parties_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"><?= anchor('admin/add/party', e('admin_parties_add')); ?></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" border="0" class="table">
	<tr>
		<th width="5%">#</th>
		<th width="25%"><?= e('admin_parties_party'); ?></th>
		<th width="15%"><?= e('admin_parties_alias'); ?></th>
		<th width="40%"><?= e('admin_parties_description'); ?></th>
		<th width="15%"><?= e('common_action'); ?></th>
	</tr>
	<?php if (empty($parties)): ?>
	<tr>
		<td colspan="5" align="center"><em><?= e('admin_parties_no_parties'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($parties as $party): ?>
	<tr class="<?= ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td width="5%" align="center"><?= ($i+1); ?></td>
		<td width="25%">
			<?= anchor('admin/edit/party/' . $party['id'], $party['party']); ?>
		</td>
		<td width="15%"><?= $party['alias']; ?></td>
		<td width="40%">
			<?= nl2br($party['description']); ?>
		</td>
		<td width="15%" align="center"><?= anchor('admin/edit/party/' . $party['id'], '<img src="' . base_url() . 'public/images/edit.png" alt="' . e('common_edit') . '" />', 'title="' . e('common_edit') . '"'); ?> | <?= anchor('admin/delete/party/' . $party['id'], '<img src="' . base_url() . 'public/images/x.png" alt="' . e('common_delete') . '" />', array('class'=>'confirm_delete', 'title'=>e('common_delete'))); ?></a></td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>