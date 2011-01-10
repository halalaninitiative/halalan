<div class="content_center">
<h2><?php echo 'HALALAN ' . e('gate_results_label'); ?></h2>
</div>

<?php if (empty($all_elections)): ?>
	<div class="reminder"><?php echo e('gate_results_no_elections'); ?></div>
<?php else: ?>

	<?php if (empty($elections)): ?>
	<div class="reminder"><?php echo e('gate_results_reminder'); ?></div>
	<?php endif; ?>

	<div class="paging">
	<a href="#" class="toggleOptions">[<?php echo (empty($elections)) ? 'show' : 'hide'; ?> options]</a>
	<?php echo form_open('gate/results'); ?>
	<?php for ($s = 0; $s < 2; $s++): ?>
	<?php
		$limit = count($all_elections);
		if ($s == 0)
		{
			$side = 'left';
			$i = 0;
			$limit /= 2;
		}
		else
		{
			$side = 'right';
		}
	?>
	<div class="content_<?php echo $side; ?>">
		<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<?php for (; $i < $limit; $i++): ?>
			<?php $checked = in_array($all_elections[$i]['id'], $selected); ?>
			<tr>
				<td class="w5">
					<?php
						echo form_checkbox(
						'elections[]',
						$all_elections[$i]['id'],
						$checked,
						'id="cb_' . $all_elections[$i]['id'] . '"'
						);
					?>
				</td>
				<td>
					<label for="<?php echo 'cb_' . $all_elections[$i]['id']; ?>"><?php echo $all_elections[$i]['election']; ?></label>
				</td>
			</tr>
		<?php endfor; ?>
		</table>
	</div>
	<?php endfor; ?>
	<div class="clear"></div>
	<div class="notes">
		<?php echo form_submit(array('value'=>e('gate_results_submit_button'))); ?>
		<br /><br />
		<a href="#" class="toggleAllElections">select all</a> | <a href="#" class="toggleAllElections">deselect all</a>
	</div>
	</form>
	</div>

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
						<td><em><?php echo e('gate_results_no_candidates'); ?></em></td>
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
						<tr>
							<td class="w5">
								<?php echo $candidate['votes']; ?>
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
						<tr>
							<td class="w5">
								<?php echo $position['abstains']; ?>
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

<?php endif; ?>
