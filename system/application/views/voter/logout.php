<div class="menu">
	<div id="left_menu">
		<ul>
			<li><img src="<?= base_url(); ?>public/images/apply.png" alt="voter" /> VOTE</li>
			<li><img src="<?= base_url(); ?>public/images/apply.png" alt="next" /> CONFIRM VOTE</li>
			<li class="active"><img src="<?= base_url(); ?>public/images/user.png" alt="next" /> LOG OUT</li>
		</ul>
	</div>
	<div id="right_menu">
		<p>YOU ARE NOW LOGGED OUT</p>
	</div>
	<div class="clear"></div>
</div>
<div class="body">
	<div class="center_body">
		<?= e('logout_message'); ?>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		THANK YOU FOR VOTING!
	</div>
	<div class="clear"></div>
</div>