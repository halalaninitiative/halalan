<div class="reminder"><?php echo e('voter_vote_reminder_too'); ?></div>
<?php echo format_messages($messages, $message_type); ?>
<?php echo form_open('voter/do_vote'); ?>
<?php if (count($positions) == 0): ?>
<?php echo format_messages(array($none), 'negative'); ?>
<?php endif; ?>
<?php for ($i = 0; $i < count($positions); $i++): ?>
<?php if ($i % 2 == 0): ?>
<div class="content_left notes">
<?php else: ?>
<div class="content_right notes">
<?php endif; ?>
	<h2><?php echo $positions[$i]['position']; ?> (<?php echo $positions[$i]['maximum']; ?>)</h2>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table highlight">
		<?php if (empty($positions[$i]['candidates'])): ?>
		<tr>
			<td><em><?php echo e('voter_vote_no_candidates'); ?></em></td>
		</tr>
		<?php else: ?>
		<?php foreach ($positions[$i]['candidates'] as $candidate): ?>
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
			<td class="w5"><?php echo form_checkbox(array('id'=>'cb' . $positions[$i]['id'] . '_' . $candidate['id'], 'name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$candidate['id'], 'class'=>'checkNumber')); ?></td>
			<td class="w60"><label for="<?php echo 'cb' . $positions[$i]['id'] . '_' . $candidate['id']; ?>"><?php echo $name; ?></label></td>
			<?php if ($settings['show_candidate_details']): ?>
			<td class="w30">
			<?php else: ?>
			<td class="w35">
			<?php endif; ?>
				<?php if (isset($candidate['party']['party']) && !empty($candidate['party']['party'])): ?>
				<?php if (empty($candidate['party']['alias'])): ?>
				<?php echo $candidate['party']['party']; ?>
				<?php else: ?>
				<?php echo $candidate['party']['alias']; ?>
				<?php endif; ?>
				<?php endif; ?>
			</td>
			<?php if ($settings['show_candidate_details']): ?>
			<td class="w5">
				<?php echo img(array('src'=>'public/images/info.png', 'alt'=>'info', 'class'=>'toggleDetails pointer', 'title'=>'More info')); ?>
			</td>
			<?php endif; ?>
		</tr>
		<tr class="details">
			<?php if ($settings['show_candidate_details']): ?>
			<td colspan="4">
			<div style="display:none;" class="details">
			<?php if (!empty($candidate['picture'])): ?>
			<div style="float:left;padding-right:5px;">
			<?php echo img(array('src'=>'public/uploads/pictures/' . $candidate['picture'], 'alt'=>'picture')); ?>
			</div>
			<?php endif; ?>
			<div style="float:left;">
			Name: <?php echo $name; ?><br />
			Party: <?php echo (isset($candidate['party']['party']) && !empty($candidate['party']['party'])) ? $candidate['party']['party'] . (!empty($candidate['party']['alias']) ? ' (' . $candidate['party']['alias'] . ')' : '') : 'none'; ?>
			</div>
			<div class="clear"></div>
			<?php if (!empty($candidate['description'])): ?>
			<div><br />
			<?php echo nl2br($candidate['description']); ?>
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
		<tr>
			<td class="w5"><?php echo form_checkbox(array('id'=>'cb' . $positions[$i]['id'] . '_abstain', 'name'=>'votes[' . $positions[$i]['id'] . '][]', 'class'=>'abstainPosition', 'checked'=>$checked, 'value'=>'')); ?></td>
			<td class="w60"><label for="<?php echo 'cb' . $positions[$i]['id'] . '_abstain'; ?>">ABSTAIN</label></td>
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
<div class="reminder"><?php echo e('voter_vote_reminder'); ?></div>
<div class="paging">
	<a name="bottom"></a>
	<?php if (count($positions) == 0): ?>
	<input type="submit" value="<?php echo e('voter_vote_submit_button'); ?>" disabled="disabled" />
	<?php else: ?>
	<input type="submit" value="<?php echo e('voter_vote_submit_button'); ?>" />
	<?php endif; ?>
</div>
</form>
