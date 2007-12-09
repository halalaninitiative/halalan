<script>
function confirmDelete(name, id)
{
	var answer = confirm('Are you sure you want to delete ' + name + '?\nWarning: This action cannot be undone!');
	if (answer)
		document.location.href = '<?= site_url('admin/delete/voter'); ?>/' + id;
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
		<table width="100%">
			<tr>
				<td colspan="2" align="right">Display per Page
					<select>
						<option>20</option>
						<option>50</option>
						<option>100</option>
						<option>200</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="left"><?= anchor('admin/add/voter', e('admin_voters_add')); ?></td>
				<td align="right">1 - 20 of 100&nbsp;&nbsp;&nbsp;&lt;&lt; Next | &lt; Previous | Next &gt; | Last &gt;&gt;</td>
			</tr>
		</table>
		<fieldset>
			<legend><span class="header"><?= e('admin_voters_label'); ?></span></legend>
			<table cellspacing="2" cellpadding="2" width="100%" bgcolor="white">
				<tr bgcolor="#FFAAAA">
					<th width="5%" align="center"><?= e('admin_voters_voted'); ?></th>
					<th width="80%" align="center"><?= e('admin_voters_name'); ?></th>
					<th width="15%" align="center"><?= e('common_action'); ?></th>
				</tr>
				<?php if (empty($voters)): ?>
				<tr>
					<td colspan="3" align="center"><em><?= e('admin_voters_no_voters'); ?></em></td>
				</tr>
				<?php else: ?>
				<?php $i = 0; ?>
				<?php foreach ($voters as $voter): ?>
				<tr <?= ($i % 2 == 0) ? '' : 'bgcolor="#FFE5E5"'  ?>>
					<td width="5%" align="center">
						<?php if ($voter['voted'] == TRUE): ?>
						<img src="<?= base_url(); ?>public/images/ok.png" />
						<?php else: ?>
						<img src="<?= base_url(); ?>public/images/x.png" />
						<?php endif; ?>
					</td>
					<td width="80%"><?= anchor('admin/edit/voter/' . $voter['id'], $voter['last_name'] . ', ' . $voter['first_name']); ?></td>
					<td width="15%" align="center"><?= anchor('admin/edit/voter/' . $voter['id'], '<img src="' . base_url() . 'public/images/edit.png" alt="' . e('common_edit') . '" />', 'title="' . e('common_edit') . '"'); ?> | <?= anchor('admin/delete/voter/' . $voter['id'], '<img src="' . base_url() . 'public/images/x.png" alt="' . e('common_delete') . '" />', 'title="' . e('common_delete') . '" onclick="confirmDelete(\'' . $voter['last_name'] . ', ' . $voter['first_name'] . '\', ' . $voter['id'] . ');return false;"'); ?></a></td>
				</tr>
				<?php $i = $i + 1; ?>
				<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</fieldset>
		<table width="100%">
			<tr>
				<td align="left"><?= anchor('admin/add/voter', e('admin_voters_add')); ?></td>
				<td align="right">1 - 20 of 100&nbsp;&nbsp;&nbsp;&lt;&lt; First | &lt; Previous | Next &gt; | Last &gt;&gt;</td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<form>
			<input name="votes" value="1" type="checkbox" /> Include votes?<br/>
			<input value="Download List" type="submit" />
		</form>
	</div>
	<div class="clear"></div>
</div>