<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Halalan - Ballot - Print Votes</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<h2><?= $settings['name']; ?></h2>
	<p>Voted as <?= $voter['username']; ?></p>
	<h3>Votes</h3>
	<table cellspacing="2" cellpadding="2" border="0" style="width: 75%">
		<?php for ($i = 0; $i < count($positions); $i++): ?>
		<?php if ($i % 2 == 0): ?>
		<tr>
		<?php endif; ?>
			<td valign="top">
				<strong><?= $positions[$i]['position']; ?> (<?= $positions[$i]['maximum']; ?>)</strong>
				<ul>
					<?php if (empty($positions[$i]['candidates'])): ?>
					<li>No candidates found.</li>
					<?php else: ?>
					<?php foreach ($positions[$i]['candidates'] as $key=>$candidate): ?>
					<?php if ($candidate['voted']): ?>
					<?php
						$name = $candidate['first_name'];
						if (!empty($candidate['alias']))
						$name .= ' "' . $candidate['alias'] . '"';
						$name .= ' ' . $candidate['last_name'];
						$name = quotes_to_entities($name);
						if (isset($candidate['party']['party']) && !empty($candidate['party']['party']))
						{
							if (empty($candidate['party']['alias']))
							{
								$party = $candidate['party']['party'];
							}
							else
							{
								$party = $candidate['party']['alias'];
							}
						}
					?>
					<li><?= $name; ?>, <?= $party; ?></li>
					<?php endif; ?>
					<?php endforeach; ?>
					<?php if ($positions[$i]['abstain'] == TRUE): ?>
					<?php if ($positions[$i]['abstains']): ?>
					<li>ABSTAIN</li>
					<?php endif; ?>
					<?php endif; ?>
					<?php endif; ?>
				</ul>
			</td>
		<?php if ($i % 2 == 1): ?>
		</tr>
		<?php endif; ?>
		<?php endfor; ?>
		<?php if (count($positions) % 2 == 1): ?>
			<td>&nbsp;</td>
		</tr>
		<?php endif; ?>
	</table>
</body>
</html>
