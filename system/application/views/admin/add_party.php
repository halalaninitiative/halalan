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
<?= form_open_multipart('admin/do_add_party'); ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"> <?= e('admin_add_party_legend'); ?> </span></legend>
			<table>
				<tr>
					<td width="30%"><?= e('admin_add_party_party'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'party', 'size'=>30)); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_add_party_description'); ?></td>
					<td width="70%"><?= form_textarea(array('name'=>'description', 'rows'=>7, 'cols'=>35)); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_add_party_logo'); ?></td>
					<td width="70%"><?= form_upload(array('name'=>'logo', 'size'=>30)); ?></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= form_submit('submit', e('admin_add_party_submit')) ?>
	</div>
	<div class="clear"></div>
</div>
<?= form_close(); ?>