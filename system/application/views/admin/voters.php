
<div class="admin_menu">
	<div id="left_menu">
		<ul>
			<li> <?= anchor('admin', 'Home'); ?> </li> |
			<li class="active"> <?= anchor('admin/voters', 'Voters'); ?> </li> |
			<li> <?= anchor('admin/units', 'Units'); ?> </li> |
			<li> <?= anchor('admin/parties', 'Parties'); ?> </li> |
			<li> <?= anchor('admin/positions', 'Positions'); ?> </li> |
			<li> <?= anchor('admin/candidates', 'Candidates'); ?> </li>
		</ul>
	</div>
	<div id="right_menu">
		<p>LOGGED IN AS <?= $username ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
	</div>
	<div class="clear"></div>
</div>
	
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
				<td align="left"><a href="">Add Voter</a></td>
				<td align="right">1 - 20 of 100&nbsp;&nbsp;&nbsp;&lt;&lt; First | &lt; Previous | Next &gt; | Last &gt;&gt;</td>
			</tr>
		</table>
		<fieldset>
			<legend><span class="header">Voters</span></legend>
			<table cellspacing="2" cellpadding="2" width="100%" bgcolor="FFFFFF">
				<thead>
					<tr bgcolor="#FFAAAA">
						<th align="center">Voted</th>
						<th align="center">Name</th>
						<?php if($unit) { ?>
							<th align="center">Unit</th>
						<?php } ?>						
						<th align="center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 0;
						
						foreach ($voters as $voter) {
					?>
					<tr <?= ($i % 2 == 0) ? 'bgcolor="#FFE5E5"' : ''  ?>
					>
						<td width="5%" align="center">
							<?php if($voter['voted'] == TRUE) { ?>
								<img src="<?= base_url(); ?>/public/images/apply.png" />
							<?php } ?>
						</td>
						<?php if($unit) { ?>
						<td width="50%" ><a href=""><?= $voter['last_name'] ?>, <?= $voter['first_name'] ?></td>
						<td width="30%" align="center">DCS</td>
						<?php } else { ?>
						<td width="80%" ><a href=""><?= $voter['last_name'] ?>, <?= $voter['first_name'] ?></td>
						<?php } ?>
						<td wodth="15%" align="center">Edit</a> | <a href="">Delete</a></td>
					</tr>
					
					<?php
					
							$i = $i + 1;
						}
					
					?>
					
				</tbody>
			</table>
		</fieldset>
		<table width="100%">
	<tr>
		<td align="left"><a href="">Add Voter</a></td>
		<td align="right">1 - 20 of 100&nbsp;&nbsp;&nbsp;&lt;&lt; First | &lt; Previous | Next &gt; | Last &gt;&gt;</td>
	</tr>
</table>
	</div>
	<div class="clear"></div>
</div>
<div class="body">
	<div class="center_body">
		<fieldset>
			<form>
				<div align="center">
					<input name="votes" value="1" type="checkbox" /> Include votes?<br/>
					<input value="Download List" type="submit" />
				</div>
			</form>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
