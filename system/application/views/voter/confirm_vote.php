<div class="menu">
	<div id="left_menu">
		<ul>
			<li><img src="<?= base_url(); ?>public/images/ok.png" alt="voter" /> VOTE</li>
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
				?>
				<?php if ($checked): ?>
				<tr>
				<?php else: ?>
				<tr class="not_selected">
				<?php endif; ?>
					<td width="5%"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$candidate['id'], 'disabled'=>'disabled')); ?></td>
					<td width="90%"><?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?></td>
					<td width="5%"><a href="#" title="Info on <?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>" onclick="return makeFalse(domTT_activate(this, event, 'caption', '&lt;span style=&quot;width : 300px;&quot;&gt;&lt;strong&gt;Information&lt;/strong&gt;&lt;/span&gt;', 'content', setContent('<?= $candidate['id']; ?>', '<?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>', '<?= $candidate['picture']; ?>', '<?= $candidate['description']; ?>', '<?= (isset($candidate['party']['party']) && !empty($candidate['party']['party'])) ? $candidate['party']['party'] : 'none'; ?>', '<?= (isset($candidate['party']['logo']) && !empty($candidate['party']['logo'])) ? $candidate['party']['logo'] : ''; ?>',  '<?= base_url(); ?>/public/'), 'type', 'sticky', 'closeLink', '[X]', 'draggable', true));"><img src="<?= base_url(); ?>public/images/info.png" alt="info" /></a></td>
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
					<td width="5%"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>'', 'disabled'=>'disabled')); ?></td>
					<td width="90%">ABSTAIN</td>
					<td width="5%"></td>
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
<?php if ($settings['captcha'] || $settings['pin']): ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="position"><?= e('voter_confirm_vote_validation_label'); ?></span></legend>
			<table cellpadding="2" cellspacing="2">
				<tr>
					<?php if ($settings['captcha']): ?>
					<td><?= $captcha['image']; ?></td>
					<td><?= e('voter_confirm_vote_captcha_label'); ?><br /><?= form_input(array('name'=>'captcha', 'size'=>20, 'maxlength'=>8)); ?></td>
					<?php endif ;?>
					<?php if ($settings['pin']): ?>
					<td>&nbsp;</td>
					<td><?= e('voter_confirm_vote_pin_label'); ?><br /><?= form_input(array('name'=>'pin', 'size'=>20)); ?></td>
					<?php endif; ?>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<?php endif; ?>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('voter/vote', 'GO BACK'); ?>
		|
		<input type="submit" value="<?= e('voter_confirm_vote_submit_button'); ?>" />
		<br />
		<span style="font-size:small;"><?= e('voter_confirm_vote_reminder'); ?></span>
	</div>
	<div class="clear"></div>
</div>
</form>