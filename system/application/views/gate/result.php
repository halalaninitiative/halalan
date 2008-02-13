<div class="menu">
	<div id="center_menu">
		<?= strtoupper($settings['name']); ?> RESULT
	</div>
	<div class="clear"></div>
</div>

<?php for ($i = 0; $i < count($positions); $i++): ?>
<?php if ($i % 2 == 0): ?>
<div class="body">
	<div class="left_body">
<?php else: ?>
	<div class="right_body">
<?php endif; ?>
		<fieldset>
			<legend><span class="position"><?= $positions[$i]['position']; ?></span> (<?= $positions[$i]['maximum']; ?>)</legend>
			<table cellspacing="2" cellpadding="2">
				<?php if (empty($positions[$i]['candidates'])): ?>
				<tr>
					<td><em><?= e('gate_result_no_candidates'); ?></em></td>
				</tr>
				<?php else: ?>
				<?php foreach ($positions[$i]['candidates'] as $key=>$candidate): ?>
				<tr>
					<td width="5%" align="center"><?= $candidate['votes']; ?></td>
					<td width="90%"><?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?></td>
					<td width="5%"><a href="#" title="Info on <?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>" onclick="return makeFalse(domTT_activate(this, event, 'caption', '&lt;span style=&quot;width : 300px;&quot;&gt;&lt;strong&gt;Information&lt;/strong&gt;&lt;/span&gt;', 'content', setContent('<?= $candidate['id']; ?>', '<?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>', '<?= $candidate['picture']; ?>', '<?= $candidate['description']; ?>', '<?= (isset($candidate['party']['party']) && !empty($candidate['party']['party'])) ? $candidate['party']['party'] : 'none'; ?>', '<?= (isset($candidate['party']['logo']) && !empty($candidate['party']['logo'])) ? $candidate['party']['logo'] : ''; ?>',  '<?= base_url(); ?>/public/'), 'type', 'sticky', 'closeLink', '[X]', 'draggable', true));"><img src="<?= base_url(); ?>public/images/info.png" alt="info" /></a></td>
				</tr>
				<?php endforeach; ?>
				<?php if ($positions[$i]['abstain'] == TRUE): ?>
				<tr>
					<td width="5%"><?= $positions[$i]['abstains']; ?></td>
					<td width="90%">ABSTAIN</td>
					<td width="5%"></td>
				</tr>
				<?php endif; ?>
				<?php endif; ?>
			</table>
		</fieldset>
	</div>
<?php if ($i % 2 == 1): ?>
	<div class="clear"></div>
</div>
<?php endif; ?>
<?php endfor; ?>
<?php // in case the number of positions is odd ?>
<?php if (count($positions) % 2 == 1): ?>
	<div class="right_body">
	</div>
	<div class="clear"></div>
</div>
<?php endif; ?>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('gate/voter', 'GO BACK'); ?>
	</div>
	<div class="clear"></div>
</div>