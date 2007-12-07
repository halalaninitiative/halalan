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
</script>
<div class="menu">
	<div id="center_menu">
		RESULT
	</div>
	<div class="clear"></div>
</div>

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
					<td><em>No candidates found.</em></td>
				</tr>
				<?php else: ?>
				<?php foreach ($positions[$i]['candidates'] as $key=>$candidate): ?>
				<tr>
					<td width="5%" align="center"><?= $candidate['votes']; ?></td>
					<td width="90%"><?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?></td>
					<td width="5%"><a href="#" title="Info on <?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>" onclick="return makeFalse(domTT_activate(this, event, 'caption', '&lt;span style=&quot;width : 300px;&quot;&gt;&lt;strong&gt;Information&lt;/strong&gt;&lt;/span&gt;', 'content', setContent('<?= $candidate['id']; ?>', '<?= $candidate['first_name'] . ' ' . $candidate['last_name']; ?>', '<?= $candidate['picture']; ?>', '<?= $candidate['description']; ?>', '<?= (isset($candidate['party']['party']) && !empty($candidate['party']['party'])) ? $candidate['party']['party'] : 'none'; ?>', '<?= (isset($candidate['party']['logo']) && !empty($candidate['party']['logo'])) ? $candidate['party']['logo'] : ''; ?>'), 'type', 'sticky', 'closeLink', '[X]', 'draggable', true));"><img src="<?= base_url(); ?>public/images/info.png" alt="info" /></a></td>
				</tr>
				<?php endforeach; ?>
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
		&nbsp;
	</div>
	<div class="clear"></div>
</div>