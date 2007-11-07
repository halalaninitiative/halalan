<script>
function checkNumber(field, name, form, limit) {
	var cntr = 0;
	var group = form.elements[name];
	for(var i = 0; i < group.length; i++)
		if(group[i].checked)
			cntr++;
	if(cntr > limit) {
		field.checked = false;
		alert("You are over the allowed limit");
	}
}
function manipulateCheckBoxes(field, name, form) {
	var group = form.elements[name];
	for(var i = 0; i < group.length; i++) {
		if(field.checked)
			group[i].disabled = true;
		else
			group[i].disabled = false;
	}
	field.disabled = false;
}
</script>

<div class="menu">
	<div id="left_menu">
		<ul>
			<li class="active"><img src="<?= base_url(); ?>public/images/user.png" alt="voter" /> VOTE</li>
			<li><img src="<?= base_url(); ?>public/images/forward.png" alt="next" /> CONFIRM VOTE</li>
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
<?= form_open('voter/do_vote'); ?>
<?php if (count($positions) == 0): ?>
<div class="message">
	<div class="message_header"><?= e('message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $none; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>
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
				<tr>
					<td><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$candidate['id'], 'onclick'=>'checkNumber(this, \'votes[' . $positions[$i]['id'] . '][]\', this.form, '. $positions[$i]['maximum'] . ');')); ?></td>
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
				<tr>
					<td><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>'', 'onclick'=>'manipulateCheckBoxes(this, \'votes[' . $positions[$i]['id'] . '][]\', this.form);')); ?></td>
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
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?php if (count($positions) == 0): ?>
		<input type="submit" value="SUBMIT" disabled="disabled" />
		<?php else: ?>
		<input type="submit" value="SUBMIT" />
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>
</form>