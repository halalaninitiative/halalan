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
				<td><em><?php echo e('voter_votes_no_candidates'); ?></em></td>
			</tr>
		<?php else: ?>
			<?php foreach ($position['candidates'] as $candidate): ?>
				<?php
					$name = $candidate['first_name'];
					if (!empty($candidate['alias']))
						$name .= ' "' . $candidate['alias'] . '"';
					$name .= ' ' . $candidate['last_name'];
					$name = quotes_to_entities($name);
				?>
				<?php if ($candidate['voted']): ?>
				<tr class="selected">
				<?php else: ?>
				<tr>
				<?php endif; ?>
					<td class="w5" align="center">
						<?php if ($candidate['voted']): ?>
							<?php echo img(array('src'=>'public/images/ok.png', 'alt'=>'Check')); ?>
						<?php else: ?>
							<?php echo img(array('src'=>'public/images/x.png', 'alt'=>'X')); ?>
						<?php endif; ?>
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
			<?php if ($position['abstain'] == TRUE): ?>
				<?php if ($position['abstains']): ?>
				<tr class="selected">
				<?php else: ?>
				<tr>
				<?php endif; ?>
					<td class="w5" align="center">
						<?php if ($position['abstains']): ?>
							<?php echo img(array('src'=>'public/images/ok.png', 'alt'=>'Check')); ?>
						<?php else: ?>
							<?php echo img(array('src'=>'public/images/x.png', 'alt'=>'X')); ?>
						<?php endif; ?>
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
<div class="paging">
	<input type="hidden" name="election_id" value="<?php echo $election['id']; ?>" id="election_id" />
	<input type="button" class="printVotes" value="<?php echo e('voter_votes_print_button'); ?>" />
	<?php if ($settings['generate_image_trail']): ?>
	<input type="button" class="downloadVotes" value="<?php echo e('voter_votes_download_button'); ?>" />
	<?php endif; ?>
</div>
