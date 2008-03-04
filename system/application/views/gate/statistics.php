<div class="content_center">
<h2><?= strtoupper($settings['name']) . ' ' . e('gate_statistics_label'); ?></h2>
</div>
<div class="content_left notes">
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<td>Registered Voters</td>
		<td><?= $voter_count; ?></td>
	</tr>
	<tr>
		<td>Voters who voted</td>
		<td><?= $voted_count; ?></td>
	</tr>
	<tr>
		<td>Voter turnout</td>
		<td><?php printf("%.2f", 100*$voted_count/$voter_count); ?>%</td>
	</tr>
</table>
</div>
<div class="clear"></div>
