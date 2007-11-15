<?php

// common to controllers
$lang['halalan_unauthorized'] = 'You must be logged in to view this page.';

// common to views
$lang['halalan_message_box'] = 'Halalan Message Box';

// controllers/gate.php
$lang['halalan_gate_title'] = 'Login';
$lang['halalan_login_failure'] = 'Login Failed.';
$lang['halalan_already_voted'] = 'You have voted already.';

// views/gate.php
$lang['halalan_login_label'] = 'Login to Halalan';
$lang['halalan_username'] = 'Username';
$lang['halalan_password'] = 'Password';
$lang['halalan_login_button'] = 'Login';

// controllers/voter.php
$lang['halalan_vote_title'] = 'Vote';
$lang['halalan_vote_no_candidates'] = 'No candidates';
$lang['halalan_vote_no_selected'] = 'No chosen candidates';
$lang['halalan_vote_not_all_selected'] = 'You have not voted for all positions.';
$lang['halalan_vote_maximum'] = 'You have exceeded the number of votes per position.';
$lang['halalan_vote_abstain_and_others'] = 'You can not vote for a candidate if you chose to abstain.';

$lang['halalan_confirm_vote_title'] = 'Confirm Vote';
$lang['halalan_confirm_vote_from_vote'] = 'You must vote first';
$lang['halalan_confirm_vote_no_captcha'] = 'No captcha entered';
$lang['halalan_confirm_vote_not_captcha'] = 'Incorrect captcha';
$lang['halalan_confirm_vote_no_pin'] = 'No PIN entered';
$lang['halalan_confirm_vote_not_pin'] = 'Incorrect PIN';

// views/gate/admin
$lang['halalan_admin_login_label'] = 'Login to Halalan as Admin';

// Admin Main Page
$lang['halalan_admin_title'] = 'Administration';
$lang['halalan_admin_home'] = 'Home';
$lang['halalan_admin_home_label'] = 'What do you want to do?';
$lang['halalan_admin_add_voter'] = 'Add Voters';
$lang['halalan_admin_add_candidate'] = 'Add Candidates';

$lang['halalan_logout_title'] = 'Logout';

// views/logout.php
$lang['halalan_logout_message'] = '<p>Thank you for using Halalan!</p><p>You have been automatically logged out.  Redirecting in 5 seconds...</p><p>Follow this ' . anchor(base_url(), 'link', 'title="Halalan - Login"') . ' if the redirection fails.</p>';


?> 
