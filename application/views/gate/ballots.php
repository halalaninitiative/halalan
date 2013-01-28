<div class="content_center">
	<h2>
		<?php echo 'HALALAN ' . e('gate_ballots_label'); ?>
		<?php echo form_dropdown('block_id', array('' => 'Choose Block') + $blocks, $block_id, 'class="changeBlocks" style="width: 130px;"'); ?>
	</h2>
</div>
<?php if (empty($elections)): ?>
<div class="reminder"><?php echo e('gate_ballots_reminder'); ?></div>
<?php else: ?>
<?php foreach ($elections as $election): ?>
	<div class="election"><?php echo $election['election']; ?></div>
	<?php foreach ($election['positions'] as $key => $position): ?>
		<?php if ($key % 2 == 0): ?>
			<div class="content_left notes">
		<?php else: ?>
			<div class="content_right notes">
		<?php endif; ?>

		<!-- start -->
		<h2><?php echo $position['position']; ?> (<?php echo $position['maximum']; ?>)</h2>
		<table cellpadding="0" cellspacing="0" border="0" class="form_table highlight delegateEvents">
			<?php if (empty($position['candidates'])): ?>
				<tr>
					<td><em><?php echo e('gate_ballots_no_candidates'); ?></em></td>
				</tr>
			<?php else: ?>
				<?php foreach ($position['candidates'] as $candidate): ?>
					<?php
						// used to populate the form
						$name = $candidate['first_name'];
						if ( ! empty($candidate['alias']))
						{
							$name .= ' "' . $candidate['alias'] . '"';
						}
						$name .= ' ' . $candidate['last_name'];
						$name = quotes_to_entities($name);
					?>
					<tr>
						<td class="w60"><?php echo $name; ?></td>
						<td class="w35">
						<?php if (isset($candidate['party']['party']) && ! empty($candidate['party']['party'])): ?>
							<?php if (empty($candidate['party']['alias'])): ?>
								<?php echo $candidate['party']['party']; ?>
							<?php else: ?>
								<?php echo $candidate['party']['alias']; ?>
							<?php endif; ?>
						<?php endif; ?>
						</td>
						<td class="w5">
							<?php echo img(array('src' => 'public/images/info.png', 'alt' => 'info', 'class' => 'pointer', 'title' => 'More info')); ?>
						</td>
					</tr>
					<tr class="details">
						<td colspan="3">
							<div style="display:none;" class="details">
							<?php if ( ! empty($candidate['picture'])): ?>
								<div style="float:left;padding-right:5px;">
									<?php echo img(array('src' => 'public/uploads/pictures/' . $candidate['picture'], 'alt' => 'picture')); ?>
								</div>
							<?php endif; ?>
							<div style="float:left;">
								Name: <?php echo $name; ?><br />
								Party: <?php echo (isset($candidate['party']['party']) && ! empty($candidate['party']['party'])) ? $candidate['party']['party'] . ( ! empty($candidate['party']['alias']) ? ' (' . $candidate['party']['alias'] . ')' : '') : 'none'; ?>
							</div>
							<div class="clear"></div>
							<?php if ( ! empty($candidate['description'])): ?>
								<div><br />
									<?php echo nl2br($candidate['description']); ?>
								</div>
							<?php endif; ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php if ($position['abstain'] == TRUE): ?>
					<tr>
						<td class="w60">ABSTAIN</td>
						<td class="w35"></td>
						<td class="w5"></td>
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
<?php endif; ?>