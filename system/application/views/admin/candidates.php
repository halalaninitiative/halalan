<script>
function confirmDelete(name, id)
{
	var answer = confirm('Are you sure you want to delete ' + name + '?\nWarning: This action cannot be undone!');
	if (answer)
		document.location.href = '<?= site_url('admin/delete/candidate'); ?>/' + id;
}
</script>
<div class="admin_menu">
	<div id="left_menu">
		<ul>
			<li><?= anchor('admin', 'Home'); ?> | </li>
			<li><?= anchor('admin/voters', 'Voters'); ?> |  </li>
			<li><?= anchor('admin/parties', 'Parties'); ?> | </li>
			<li><?= anchor('admin/positions', 'Positions'); ?> | </li>
			<li><?= anchor('admin/candidates', 'Candidates'); ?></li>
		</ul>
	</div>
	<div id="right_menu">
		<p>LOGGED IN AS <?= strtoupper($username); ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
	</div>
	<div class="clear"></div>
</div>
<?php if (isset($messages) && !empty($messages)): ?>
<div class="message">
	<div class="message_header"><?= e('message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $message; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>
<?php if (empty($positions)): ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"><?= e('admin_candidates_label'); ?></span></legend>
			<table cellspacing="2" cellpadding="2" width="100%" bgcolor="white">
				<tr bgcolor="#FFAAAA">
					<th width="30%" align="center"><?= e('admin_candidates_candidate'); ?></th>
					<th width="55%" align="center"><?= e('admin_candidates_description'); ?></th>
					<th width="15%" align="center"><?= e('common_action'); ?></th>
				</tr>
				<tr>
					<td colspan="3" align="center"><em><?= e('admin_candidates_no_candidates'); ?></em></td>
				</tr>
			</table>
		</fieldset>
	</div>
</div>
<?php else: ?>
<?php foreach ($positions as $position): ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"><?= $position['position']; ?> Candidates</span></legend>
			<table cellspacing="2" cellpadding="2" width="100%" bgcolor="white">
				<tr bgcolor="#FFAAAA">
					<th width="30%" align="center"><?= e('admin_candidates_candidate'); ?></th>
					<th width="55%" align="center"><?= e('admin_candidates_description'); ?></th>
					<th width="15%" align="center"><?= e('common_action'); ?></th>
				</tr>
				<?php if (empty($position['candidates'])): ?>
				<tr>
					<td colspan="3" align="center"><em><?= e('admin_candidates_no_candidates'); ?></em></td>
				</tr>
				<?php else: ?>
				<?php $i = 0; ?>
				<?php foreach ($position['candidates'] as $candidate): ?>
				<tr <?= ($i % 2 == 0) ? '' : 'bgcolor="#FFE5E5"'  ?>>
					<td width="30%">
						<?= anchor('admin/edit/candidate/' . $candidate['id'], $candidate['last_name'] . ', ' . $candidate['first_name']); ?>
					</td>
					<td width="55%">
						<?= nl2br($candidate['description']); ?>
					</td>
					<td width="15%" align="center"><?= anchor('admin/edit/candidate/' . $candidate['id'], '<img src="' . base_url() . 'public/images/edit.png" alt="' . e('common_edit') . '" />', 'title="' . e('common_edit') . '"'); ?> | <?= anchor('admin/delete/candidate/' . $candidate['id'], '<img src="' . base_url() . 'public/images/x.png" alt="' . e('common_delete') . '" />', 'title="' . e('common_delete') . '" onclick="confirmDelete(\'' . $candidate['last_name'] . ', ' . $candidate['first_name'] . '\', ' . $candidate['id'] . ');return false;"'); ?></a></td>
				</tr>
				<?php $i = $i + 1; ?>
				<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('admin/add/candidate', e('admin_candidates_add')); ?>
	</div>
	<div class="clear"></div>
</div>