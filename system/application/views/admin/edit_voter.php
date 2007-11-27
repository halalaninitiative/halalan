<script>
function copyToList(from,to)
{
  fromList = document.getElementById(from);
  toList = document.getElementById(to);
  var sel = false;
  for (i=0;i<fromList.options.length;i++)
  {
    var current = fromList.options[i];
    if (current.selected)
    {
      sel = true;
      txt = current.text;
      val = current.value;
      toList.options[toList.length] = new Option(txt,val);
      fromList.options[i] = null;
      i--;
    }
  }
  if (!sel) alert ('You haven\'t selected any options!');
}

function allSelect()
{
  List = document.getElementById('chosen');
  for (i=0;i<List.length;i++)
  {
     List.options[i].selected = true;
  }
}
</script>
<div class="admin_menu">
	<div id="left_menu">
		<ul>
			<li><?= anchor('admin', 'Home'); ?> | </li>
			<li><?= anchor('admin/voters', 'Voters'); ?> |  </li>
			<li><?= anchor('admin/units', 'Units'); ?> | </li>
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
<?= form_open('admin/do_edit_voter/' . $voter['id'], array('onsubmit'=>'allSelect();')); ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"> <?= e('admin_edit_voter_legend'); ?> </span></legend>
			<table>
				<tr>
					<td width="30%">Username</td>
					<td width="70%"><?= form_input(array('name'=>'username', 'value'=>$voter['username'])); ?></td>
				</tr>
				<tr>
					<td width="30%">First Name</td>
					<td width="70%"><?= form_input(array('name'=>'first_name', 'value'=>$voter['first_name'])); ?></td>
				</tr>
				<tr>
					<td width="30%">Last Name</td>
					<td width="70%"><?= form_input(array('name'=>'last_name', 'value'=>$voter['last_name'])); ?></td>
				</tr>
				<tr>
					<td width="30%">General Positions</td>
					<td width="70%">
					<?php foreach ($general as $g): ?>
					<?= $g['position']; ?><br />
					<?php endforeach; ?>
					</td>
				</tr>
				<tr>
					<td width="30%">Specific Positions</td>
					<td width="70%">
					<?php if (empty($specific)): ?>
					<em>No specific positions found.</em>
					<?php else: ?>
						<table>
							<tr>
								<td><?= form_dropdown('possible[]', $positions, '', 'id="possible" multiple="true" size="5" style="width : 150px;"'); ?><br />Possible Positions</td>
								<td><input type="button" onclick="copyToList('possible','chosen');" value="  &gt;&gt;  " /><br /><input type="button" onclick="copyToList('chosen','possible');" value="  &lt;&lt;  " /></td>
								<td><?= form_dropdown('chosen[]', $chosen, '', 'id="chosen" multiple="true" size="5" style="width : 150px;"'); ?><br />Chosen Positions</td>
							</tr>
						</table>
					<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td width="30%">Regenerate</td>
					<td width="70%"><?= form_checkbox(array('name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?> Password <?= form_checkbox(array('name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?> Pin</td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= form_submit('edit_submit', e('admin_edit_voter_submit')) ?>
	</div>
	<div class="clear"></div>
</div>
<?= form_close(); ?>