<script>
window.onload = checkCookie;
</script>

<div class="menu">
	<div id="left_menu">
		<ul>
			<li class="active"><img src="<?= base_url(); ?>public/images/user.png" alt="voter" /> VOTE</li>
			<li><img src="<?= base_url(); ?>public/images/forward.png" alt="next" /> CONFIRM VOTE</li>
			<li><img src="<?= base_url(); ?>public/images/forward.png" alt="next" /> LOG OUT</li>
		</ul>
	</div>
	<div id="right_menu">
		<p>LOGGED IN AS <?= $username; ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
	</div>
	<div class="clear"></div>
</div>
<?php if (isset($messages) && !empty($messages)): ?>
<div class="message">
	<div class="message_header"><?= e('common_message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $message; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>
<?= form_open('voter/do_vote', array('onsubmit'=>'saveState();')); ?>
<?php if (count($positions) == 0): ?>
<div class="message">
	<div class="message_header"><?= e('common_message_box'); ?></div>
	<div class="message_body">
		<ul>
			<li><?= $none; ?></li>
		</ul>
	</div>
</div>
<?php endif; ?>
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
					<td><em><?= e('voter_vote_no_candidates'); ?></em></td>
				</tr>
				<?php else: ?>
				<?php foreach ($positions[$i]['candidates'] as $key=>$candidate): ?>
				<?php
					// used to populate the form
					if (isset($votes[$positions[$i]['id']]) && in_array($candidate['id'], $votes[$positions[$i]['id']]))
						$checked = TRUE;
					else
						$checked = FALSE;
					$name = $candidate['first_name'];
					if (!empty($candidate['alias']))
						$name .= ' "' . $candidate['alias'] . '"';
					$name .= ' ' . $candidate['last_name'];
					$name = quotes_to_entities($name);
				?>
				<tr>
					<td width="5%"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$candidate['id'], 'onclick'=>'checkNumber(this, \'votes[' . $positions[$i]['id'] . '][]\', this.form, '. $positions[$i]['maximum'] . ');')); ?></td>
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
					<td width="5%"><a href="#" title="Info on <?= $name; ?>" onclick="return makeFalse(domTT_activate(this, event, 'caption', '&lt;span style=&quot;width : 300px;&quot;&gt;&lt;strong&gt;Information&lt;/strong&gt;&lt;/span&gt;', 'content', setContent('<?= $candidate['id']; ?>', '<?= $name; ?>', '<?= $candidate['picture']; ?>', '<?= $candidate['description']; ?>', '<?= (isset($candidate['party']['party']) && !empty($candidate['party']['party'])) ? $candidate['party']['party'] . (!empty($candidate['party']['alias']) ? ' (' . $candidate['party']['alias'] . ')' : '') : 'none'; ?>', '<?= (isset($candidate['party']['logo']) && !empty($candidate['party']['logo'])) ? $candidate['party']['logo'] : ''; ?>',  '<?= base_url(); ?>/public/'), 'type', 'sticky', 'closeLink', '[X]', 'draggable', true));"><img src="<?= base_url(); ?>public/images/info.png" alt="info" /></a></td>
					<?php endif; ?>
				</tr>
				<?php endforeach; ?>
				<?php
					// same as above but for abstain
					if (isset($votes[$positions[$i]['id']]) && in_array('', $votes[$positions[$i]['id']]))
						$checked = TRUE;
					else
						$checked = FALSE;
				?>
				<?php if ($positions[$i]['abstain'] == TRUE): ?>
				<tr>
					<td width="5%"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>'', 'onclick'=>'manipulateCheckBoxes(this, \'votes[' . $positions[$i]['id'] . '][]\', this.form);')); ?></td>
					<td width="95%">ABSTAIN</td>
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
		<?php if (count($positions) == 0): ?>
		<input type="submit" value="<?= e('voter_vote_submit_button'); ?>" disabled="disabled" />
		<?php else: ?>
		<input type="submit" value="<?= e('voter_vote_submit_button'); ?>" />
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>
</form>