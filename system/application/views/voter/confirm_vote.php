<div class="reminder"><?= e('voter_confirm_vote_reminder_too'); ?></div>
<?= format_messages($messages, $message_type); ?>
<?= form_open('voter/do_verify'); ?>
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
		<?php if ($checked): ?>
		<tr class="selected">
		<?php else: ?>
		<tr>
		<?php endif; ?>
			<td class="w5"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$candidate['id'], 'disabled'=>'disabled')); ?></td>
			<td class="w60"><?= $name; ?></td>
			<?php if ($settings['show_candidate_details']): ?>
			<td class="w30">
			<?php else: ?>
			<td class="w35">
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
			<td class="w5">
				<?= img(array('src'=>'public/images/info.png', 'alt'=>'info', 'class'=>'toggleDetails', 'title'=>'More info')); ?>
			</td>
			<?php endif; ?>
		</tr>
		<tr>
			<?php if ($settings['show_candidate_details']): ?>
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
			<?php else: ?>
			<td>
			<?php endif; ?>
			</td>
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
		<?php if ($checked): ?>
		<tr class="selected">
		<?php else: ?>
		<tr>
		<?php endif; ?>
			<td class="w5"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>'', 'disabled'=>'disabled')); ?></td>
			<td class="w60">ABSTAIN</td>
			<?php if ($settings['show_candidate_details']): ?>
			<td class="w30"></td>
			<td class="w5"></td>
			<?php else: ?>
			<td class="w35"></td>
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
<?php if ($settings['captcha'] || $settings['pin']): ?>
<div class="notes">
<h2><?= e('voter_confirm_vote_validation_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<?php if ($settings['captcha']): ?>
		<td><?= $captcha['image']; ?></td>
		<td><label for="captcha"><?= e('voter_confirm_vote_captcha_label'); ?><br /><?= form_input(array('id'=>'captcha', 'name'=>'captcha', 'size'=>20, 'maxlength'=>8)); ?></label></td>
		<?php endif ;?>
		<?php if ($settings['pin']): ?>
		<td>&nbsp;</td>
		<td><label for="pin"><?= e('voter_confirm_vote_pin_label'); ?><br /><?= form_input(array('id'=>'pin', 'name'=>'pin', 'size'=>20)); ?></label></td>
		<?php endif; ?>
	</tr>
</table>
</div>
<?php endif; ?>
<div class="reminder"><?= e('voter_confirm_vote_reminder'); ?></div>
<div class="paging">
	<a name="bottom"></a>
	<input type="button" class="modifyBallot" value="<?= e('voter_confirm_vote_modify_button'); ?>" />
	|
	<input type="submit" value="<?= e('voter_confirm_vote_submit_button'); ?>" />
</div>
</form>
