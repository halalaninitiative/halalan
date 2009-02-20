<div class="content_center">
<h2><?php echo strtoupper($settings['name']) . ' ' . e('gate_result_label'); ?></h2>
</div>

<?php if (empty($positions)): ?>
<div class="reminder"><?php echo e('gate_result_reminder'); ?></div>
<?php endif; ?>

<div class="paging">
<a href="#" class="toggleOptions">[<?php echo (empty($positions)) ? 'show' : 'hide'; ?> options]</a>
<?php echo form_open('gate/results'); ?>
<div class="content_left">
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<?php for ($i = 0; $i < count($all_positions) / 2; $i++): ?>
		<?php $checked = (in_array($all_positions[$i]['id'], $selected)); ?>
		<tr>
			<td class="w5"><?php echo form_checkbox(array('id'=>'cb' . $all_positions[$i]['id'], 'name'=>'positions[' . $all_positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$all_positions[$i]['id'])); ?></td>
			<td><label for="<?php echo 'cb' . $all_positions[$i]['id']; ?>"><?php echo $all_positions[$i]['position']; ?></label></td>
		</tr>
	<?php endfor; ?>
	</table>
</div>
<div class="content_right">
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
	<?php for (; $i < count($all_positions); $i++): ?>
		<?php $checked = (in_array($all_positions[$i]['id'], $selected)); ?>
		<tr>
			<td class="w5"><?php echo form_checkbox(array('id'=>'cb' . $all_positions[$i]['id'], 'name'=>'positions[' . $all_positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$all_positions[$i]['id'])); ?></td>
			<td><label for="<?php echo 'cb' . $all_positions[$i]['id']; ?>"><?php echo $all_positions[$i]['position']; ?></label></td>
		</tr>
	<?php endfor; ?>
	</table>
</div>
<div class="notes">
	<?php echo form_submit(array('value'=>e('gate_result_submit_button'))); ?>
	<br /><br />
	<a href="#" class="toggeAllPositions">select all</a> | <a href="#" class="toggeAllPositions">deselect all</a>
</div>
</form>
</div>

<?php for ($i = 0; $i < count($positions); $i++): ?>
<?php if ($i % 2 == 0): ?>
<div class="content_left notes">
<?php else: ?>
<div class="content_right notes">
<?php endif; ?>
	<h2><?php echo $positions[$i]['position']; ?> (<?php echo $positions[$i]['maximum']; ?>)</h2>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<?php if (empty($positions[$i]['candidates'])): ?>
		<tr>
			<td><em><?php echo e('gate_result_no_candidates'); ?></em></td>
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
			<td class="w5" align="center"><?php echo $candidate['votes']; ?></td>
			<td class="w70"><?php echo $name; ?></td>
			<?php if ($settings['show_candidate_details']): ?>
			<td class="w20">
			<?php else: ?>
			<td class="w25">
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
		<tr>
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
		<?php if ($positions[$i]['abstain'] == TRUE): ?>
		<tr>
			<td class="w5"><?php echo $positions[$i]['abstains']; ?></td>
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
