<script type="text/javascript" src="<?= base_url(); ?>public/javascripts/domTT/domLib.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>public/javascripts/domTT/domTT.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>public/javascripts/domTT/domTT_drag.js"></script>
<script>
function setContent(id, name, picture, description, party, logo) {
	var ret = "";
	ret += "<div style=\"width: 300px;\">";
	ret += "<div style=\"float: left;\">";
	if (picture == '')
	ret += "<img src=\"<?= base_url() . 'public/images/default.png'; ?>\" alt=\"picture\" />";
	else
	ret += "<img src=\"<?= base_url(); ?>public/uploads/" + id + "/" + picture + "\" alt=\"picture\" />";
	ret += "</div>";
	ret += "<div style=\"float: left;\">";
	ret += "Name: " + name;
	ret += "<br />Party: " + party;
	ret += "</div>";
	ret += "</div>";
	ret += "<div style=\"clear: both;\"></div>";
	ret += "<div style=\"width: 300px;\">" + description + "</div>";
	return ret;
}
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
function saveState() {
	var inputs = document.getElementsByTagName("input");
	var checkboxes = new Array();
	for(var i = 0; i < inputs.length; i++) {
		if(inputs[i].type == "checkbox") {
			if(inputs[i].disabled == true)
				checkboxes.push(i);
		}
	}
	setCookie('halalan_cookie', checkboxes.toString(), 1);
}
function restoreState(checkboxes) {
	checkboxes = checkboxes.split(",");
	var inputs = document.getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++) {
		if(in_array(i, checkboxes))
			inputs[i].disabled = true;
	}
}
function in_array(needle, haystack) {
	for(var i = 0; i < haystack.length; i++) {
		if(haystack[i] == needle)
			return true;
	}
	return false;
}
function checkCookie() {
	var checkboxes = getCookie('halalan_cookie');
	if(checkboxes != null && checkboxes != "")
		restoreState(checkboxes);
}

function setCookie(c_name,value,expiredays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie = c_name + "=" + escape(value) + ((expiredays==null) ? "" : ";expires=" + exdate.toGMTString()) + ";path=/";
}

function getCookie(c_name) {
	if(document.cookie.length > 0) {
		var c_start = document.cookie.indexOf(c_name + "=");
		if(c_start != -1) {
			c_start = c_start + c_name.length + 1;
			c_end = document.cookie.indexOf(";", c_start);
			if(c_end == -1)
				c_end = document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return "";
}
window.onload = checkCookie;
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
<?= form_open('voter/do_vote', array('onsubmit'=>'saveState();')); ?>
<?php if (count($positions) == 0): ?>
<div class="message">
	<div class="message_header"><?= e('message_box'); ?></div>
	<div class="message_body">
		<ul>			
			<li><?= $none; ?></li>			
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
					<td width="5%"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>$candidate['id'], 'onclick'=>'checkNumber(this, \'votes[' . $positions[$i]['id'] . '][]\', this.form, '. $positions[$i]['maximum'] . ');')); ?></td>
					<td width="90%"><?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?></td>
					<td width="5%"><a href="#" title="Info on <?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>" onclick="return makeFalse(domTT_activate(this, event, 'caption', '&lt;span style=&quot;width : 300px;&quot;&gt;&lt;strong&gt;Information&lt;/strong&gt;&lt;/span&gt;', 'content', setContent('<?= $candidate['id']; ?>', '<?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>', '<?= $candidate['picture']; ?>', '<?= $candidate['description']; ?>', '<?= (isset($candidate['party']['party']) && !empty($candidate['party']['party'])) ? $candidate['party']['party'] : 'none'; ?>', '<?= (isset($candidate['party']['logo']) && !empty($candidate['party']['logo'])) ? $candidate['party']['logo'] : ''; ?>'), 'type', 'sticky', 'closeLink', '[X]', 'draggable', true));"><img src="<?= base_url(); ?>public/images/info.png" alt="info" /></a></td>
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
					<td width="5%"><?= form_checkbox(array('name'=>'votes[' . $positions[$i]['id'] . '][]', 'checked'=>$checked, 'value'=>'', 'onclick'=>'manipulateCheckBoxes(this, \'votes[' . $positions[$i]['id'] . '][]\', this.form);')); ?></td>
					<td width="90%">ABSTAIN</td>
					<td width="5%"></td>
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