<div class="menu">
	<div id="left_menu">
		<ul>
			<li><img src="<?= base_url(); ?>public/images/apply.png" alt="voter" /> VOTE</li>
			<li class="active"><img src="<?= base_url(); ?>public/images/user.png" alt="next" /> CONFIRM VOTE</li>
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
	<div class="message_header"><?= e('message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $message; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>
<?= form_open('voter/do_confirm_vote'); ?>
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
				<?php foreach ($positions[$i]['candidates'] as $key=>$candidate): ?>
				<?php
					// used to populate the form
					if (isset($votes[$positions[$i]['id']]) && in_array($candidate['id'], $votes[$positions[$i]['id']]))
						$checked = TRUE;
					else
						$checked = FALSE;
				?>
				<?php if ($checked): ?>
				<tr>
				<?php else: ?>
				<tr class="not_selected">
				<?php endif; ?>
					<td><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$candidate['id'], 'disabled'=>'disabled')); ?></td>
					<td><?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?></td>
					<td><?= $candidate['party']['party']; ?></td>
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
				<tr>
				<?php else: ?>
				<tr class="not_selected">
				<?php endif; ?>
					<td><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>'', 'disabled'=>'disabled')); ?></td>
					<td>ABSTAIN</td>
					<td></td>
				</tr>
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
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="position">Validation</span></legend>
			<table cellpadding="2" cellspacing="2">
				<tr>
					<td><?= $captcha['image']; ?></td>
					<td>Enter the word here:<br /><?= form_input(array('name'=>'captcha', 'size'=>20, 'maxlength'=>8)); ?></td>
					<td>&nbsp;</td>
					<td>Enter your pin here:<br /><?= form_input(array('name'=>'pin', 'size'=>20)); ?></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('voter/vote', 'GO BACK'); ?>
		|
		<input type="submit" value="SUBMIT" />
	</div>
	<div class="clear"></div>
</div>
</form>