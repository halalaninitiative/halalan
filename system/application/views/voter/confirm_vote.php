<div class="reminder"><?php echo e('voter_confirm_vote_reminder_too'); ?></div>
<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<?php echo form_open('voter/do_verify'); ?>
<?php foreach ($elections as $election): ?>
	<div class="election"><?php echo $election['election']; ?></div>
	<?php foreach ($election['positions'] as $key=>$position): ?>
		<?php if ($key % 2 == 0): ?>
			<div class="content_left notes">
		<?php else: ?>
			<div class="content_right notes">
		<?php endif; ?>

		<!-- start -->
		<h2><?php echo $position['position']; ?> (<?php echo $position['maximum']; ?>)</h2>
		<table cellpadding="0" cellspacing="0" border="0" class="form_table delegateEvents">
			<?php if (empty($position['candidates'])): ?>
				<tr>
					<td><em><?php echo e('voter_vote_no_candidates'); ?></em></td>
				</tr>
			<?php else: ?>
				<?php foreach ($position['candidates'] as $candidate): ?>
					<?php
						// used to populate the form
						if (isset($votes[$election['id']][$position['id']]) && in_array($candidate['id'], $votes[$election['id']][$position['id']]))
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
						<td class="w5">
							<?php
								echo form_checkbox(
								'votes[' . $election['id'] . '][' . $position['id'] . '][]',
								$candidate['id'],
								$checked,
								'disabled="disabled"'
								);
							?>
						</td>
						<td class="w60">
							<?php echo $name; ?>
						</td>
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
								<?php echo img(array('src'=>'public/images/info.png', 'alt'=>'info', 'class'=>'pointer', 'title'=>'More info')); ?>
							</td>
						<?php endif; ?>
					</tr>
					<tr>
						<td colspan="4">
						<?php if ($settings['show_candidate_details']): ?>
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
						<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php
					// same as above but for abstain
					if (isset($votes[$election['id']][$position['id']]) && in_array('abstain', $votes[$election['id']][$position['id']]))
						$checked = TRUE;
					else
						$checked = FALSE;
				?>
				<?php if ($position['abstain'] == TRUE): ?>
					<?php if ($checked): ?>
					<tr class="selected">
					<?php else: ?>
					<tr>
					<?php endif; ?>
						<td class="w5">
							<?php
								echo form_checkbox(
								'votes[' . $election['id'] . '][' . $position['id'] . '][]',
								'abstain',
								$checked,
								'disabled="disabled"'
								);
							?>
						</td>
						<td class="w60">
							ABSTAIN
						</td>
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
		<!-- end -->

		</div> <!-- end of content_{left,right} notes -->
		<?php if ($key % 2 == 1): ?>
			<div class="clear"></div>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php // in case the number of positions is odd, add another div ?>
	<?php if (count($election['positions']) % 2 == 1): ?>
		<div class="content_right"></div>
		<div class="clear"></div>
	<?php endif; ?>
<?php endforeach; ?>

<?php if ($settings['captcha'] || $settings['pin']): ?>
<div class="notes">
<h2><?php echo e('voter_confirm_vote_validation_label'); ?></h2>
<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<tr>
		<?php if ($settings['captcha']): ?>
		<td><?php echo $captcha['image']; ?></td>
		<td><label for="captcha"><?php echo e('voter_confirm_vote_captcha_label'); ?><br /><?php echo form_input(array('id'=>'captcha', 'name'=>'captcha', 'size'=>20, 'maxlength'=>$settings['captcha_length'])); ?></label></td>
		<?php endif ;?>
		<?php if ($settings['pin']): ?>
		<td>&nbsp;</td>
		<td><label for="pin"><?php echo e('voter_confirm_vote_pin_label'); ?><br /><?php echo form_input(array('id'=>'pin', 'name'=>'pin', 'size'=>20, 'maxlength'=>$settings['pin_length'])); ?></label></td>
		<?php endif; ?>
	</tr>
</table>
</div>
<?php endif; ?>

<div class="reminder"><?php echo e('voter_confirm_vote_reminder'); ?></div>
<div class="paging">
	<a name="bottom"></a>
	<input type="button" class="modifyBallot" value="<?php echo e('voter_confirm_vote_modify_button'); ?>" />
	|
	<input type="submit" value="<?php echo e('voter_confirm_vote_submit_button'); ?>" />
</div>
<?php echo form_close(); ?>
