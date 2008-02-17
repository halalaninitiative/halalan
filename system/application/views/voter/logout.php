<div class="menu">
	<div id="left_menu">
		<ul>
			<li><?= img(array('src'=>'public/images/ok.png', 'alt'=>'done')); ?> VOTE</li>
			<li><?= img(array('src'=>'public/images/ok.png', 'alt'=>'done')); ?> CONFIRM VOTE</li>
			<li class="active"><?= img(array('src'=>'public/images/user.png', 'alt'=>'voter')); ?> LOG OUT</li>
		</ul>
	</div>
	<div id="right_menu">
		<p>YOU ARE NOW LOGGED OUT</p>
	</div>
	<div class="clear"></div>
</div>
<div class="body">
	<div class="center_body">
		<?= e('voter_logout_message'); ?>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		THANK YOU FOR VOTING!
	</div>
	<div class="clear"></div>
</div>