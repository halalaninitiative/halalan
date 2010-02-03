<?php echo display_messages('', $this->session->flashdata('messages')); ?>
<div class="content_left">
	<h2><?php echo e('voter_index_label'); ?></h2>
</div>
<div class="content_right">
	<p class="align_right"></p>
</div>
<div class="clear"></div>
<table cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th scope="col" class="w5"><?php echo e('common_id'); ?></th>
		<th scope="col"><?php echo e('voter_index_election'); ?></th>
		<th scope="col" class="w5"><?php echo e('voter_index_voted'); ?></th>
		<th scope="col" class="w15"><?php echo e('voter_index_status'); ?></th>
		<th scope="col" class="w15"><?php echo e('voter_index_results'); ?></th>
		<th scope="col" class="w15"><?php echo e('common_actions'); ?></th>
	</tr>
	<?php if (empty($elections)): ?>
	<tr>
		<td colspan="4" align="center"><em><?php echo e('voter_index_no_elections'); ?></em></td>
	</tr>
	<?php else: ?>
	<?php $i = 0; ?>
	<?php foreach ($elections as $election): ?>
	<?php if (in_array($election['id'], $election_ids)): ?>
	<tr class="<?php echo ($i % 2 == 0) ? 'odd' : 'even'  ?>">
		<td align="center">
			<?php echo $election['id']; ?>
		</td>
		<td>
			<?php if ($election['parent_id'] > 0): ?>
				&nbsp;&nbsp;
			<?php endif; ?>
			<?php echo $election['election']; ?>
		</td>
		<td align="center">
			<?php if (in_array($election['id'], $voted)): ?>
				Yes
			<?php else: ?>
				No
			<?php endif; ?>
		</td>
		<td align="center">
			<?php if ($election['status']): ?>
				Running
			<?php else: ?>
				Not Running
			<?php endif; ?>
		</td>
		<td align="center">
			<?php if ($election['results']): ?>
				Available
			<?php else: ?>
				Not Available
			<?php endif; ?>
		</td>
		<td align="center">
			<?php echo anchor('voter/votes/view/' . $election['id'], 'view votes'); ?>
		</td>
	</tr>
	<?php $i = $i + 1; ?>
	<?php endif; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</table>