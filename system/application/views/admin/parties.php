<script>
function confirmDelete(name, id)
{
	var answer = confirm('Are you sure you want to delete ' + name + '?\nWarning: This action cannot be undone!');
	if (answer)
		document.location.href = '<?= site_url('admin/delete/party'); ?>/' + id;
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
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"><?= e('admin_parties_label'); ?></span></legend>
			<table cellspacing="2" cellpadding="2" width="100%" bgcolor="white">
				<tr bgcolor="#FFAAAA">
					<th width="30%" align="center"><?= e('admin_parties_party'); ?></th>
					<th width="55%" align="center"><?= e('admin_parties_description'); ?></th>
					<th width="15%" align="center"><?= e('common_action'); ?></th>
				</tr>
				<?php if (empty($parties)): ?>
				<tr>
					<td colspan="3" align="center"><em><?= e('admin_parties_no_parties'); ?></em></td>
				</tr>
				<?php else: ?>
				<?php $i = 0; ?>
				<?php foreach ($parties as $party): ?>
				<tr <?= ($i % 2 == 0) ? '' : 'bgcolor="#FFE5E5"'  ?>>
					<td width="30%">
						<?= anchor('admin/edit/party/' . $party['id'], $party['party']); ?>
					</td>
					<td width="55%">
						<?= nl2br($party['description']); ?>
					</td>
					<td width="15%" align="center"><?= anchor('admin/edit/party/' . $party['id'], '<img src="' . base_url() . 'public/images/edit.png" alt="' . e('common_edit') . '" />', 'title="' . e('common_edit') . '"'); ?> | <?= anchor('admin/delete/party/' . $party['id'], '<img src="' . base_url() . 'public/images/x.png" alt="' . e('common_delete') . '" />', 'title="' . e('common_delete') . '" onclick="confirmDelete(\'' . $party['party'] . '\', ' . $party['id'] . ');return false;"'); ?></a></td>
				</tr>
				<?php $i = $i + 1; ?>
				<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('admin/add/party', e('admin_parties_add')); ?>
	</div>
	<div class="clear"></div>
</div>