<div class="content_center">
<h2><?= strtoupper($settings['name']) . ' ' . e('gate_result_label'); ?></h2>
</div>
<?php for ($i = 0; $i < count($positions); $i++): ?>
<?php if ($i % 2 == 0): ?>
<div class="content_left notes">
<?php else: ?>
<div class="content_right notes">
<?php endif; ?>
	<h2><?= $positions[$i]['position']; ?> (<?= $positions[$i]['maximum']; ?>)</h2>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<?php if (empty($positions[$i]['candidates'])): ?>
		<tr>
			<td><em><?= e('gate_result_no_candidates'); ?></em></td>
		</tr>
		<?php else: ?>
		<?php foreach ($positions[$i]['candidates'] as $key=>$candidate): ?>
		<?php
			$name = $candidate['first_name'];
			if (!empty($candidate['alias']))
				$name .= ' "' . $candidate['alias'] . '"';
			$name .= ' ' . $candidate['last_name'];
			$name = quotes_to_entities($name);
		?>
		<tr>
			<td width="5%" align="center"><?= $candidate['votes']; ?></td>
			<td width="70%"><?= $name; ?></td>
			<?php if ($settings['show_candidate_details']): ?>
			<td width="20%">
			<?php else: ?>
			<td width="25%">
			<?php endif; ?>
				<?php if (isset($candidate['party']['party']) && !empty($candidate['party']['party'])): ?>
				<?php if (empty($candidate['party']['alias'])): ?>
				<?= $candidate['party']['party']; ?>
				<?php else: ?>
				<?= $candidate['party']['alias']; ?>
				<?php endif; ?>
				<?php endif; ?>
			</td>
			<?php if ($settings['show_candidate_details']): ?>
			<td width="5%">
				<a href="#" class="toggle_details">
				<?= img(array('src'=>'public/images/info.png', 'alt'=>'info')); ?>
				</a>
			</td>
			<?php endif; ?>
		</tr>
		<tr>
			<td colspan="4">
			<div style="display:none;" class="details">
			<?php if (!empty($candidate['picture'])): ?>
			<div style="float:left;padding-right:5px;">
			<?= img(array('src'=>'public/uploads/pictures/' . $candidate['picture'], 'alt'=>'picture')); ?>
			</div>
			<?php endif; ?>
			<div style="float:left;">
			Name: <?= $name; ?><br />
			Party: <?= (isset($candidate['party']['party']) && !empty($candidate['party']['party'])) ? $candidate['party']['party'] . (!empty($candidate['party']['alias']) ? ' (' . $candidate['party']['alias'] . ')' : '') : 'none'; ?>
			</div>
			<div class="clear"></div>
			<?php if (!empty($candidate['description'])): ?>
			<div><br />
			<?= nl2br($candidate['description']); ?>
			</div>
			<?php endif; ?>
			</div>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php if ($positions[$i]['abstain'] == TRUE): ?>
		<tr>
			<td width="5%"><?= $positions[$i]['abstains']; ?></td>
			<td width="60%"><label for="<?= 'cb' . $positions[$i]['id'] . '_abstain'; ?>">ABSTAIN</label></td>
			<?php if ($settings['show_candidate_details']): ?>
			<td width="30%"></td>
			<td width="5%"></td>
			<?php else: ?>
			<td width="35%"></td>
			<?php endif; ?>
		</tr>
		<?php endif; ?>
		<?php endif; ?>
	</table>
</div>
<?php if ($i % 2 == 1): ?>
<div class="clear"></div>
<?php endif; ?>
<?php endfor; ?>
<?php // in case the number of positions is odd ?>
<?php if (count($positions) % 2 == 1): ?>
<div class="content_right">
</div>
<div class="clear"></div>
<?php endif; ?>