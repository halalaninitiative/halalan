<?php

// common to controllers
$lang['halalan_unauthorized'] = 'You must be logged in to view this page.';

// common to views
$lang['halalan_message_box'] = 'Halalan Message Box';
$lang['halalan_edit'] = 'Edit';
$lang['halalan_delete'] = 'Delete';
$lang['halalan_voted'] = 'Voted';
$lang['halalan_name'] = 'Name';
$lang['halalan_unit'] = 'Unit';
$lang['halalan_action'] = 'Action';

// controllers/gate.php
$lang['halalan_gate_login_failure'] = 'Login failed.'; // common
$lang['halalan_gate_voter_title'] = 'Voter Login';
$lang['halalan_gate_voter_already_voted'] = 'You have already voted';
$lang['halalan_gate_admin_title'] = 'Admin Login';

// views/gate/voter.php
$lang['halalan_gate_voter_login_label'] = 'Login to Halalan';
$lang['halalan_gate_voter_username'] = 'Username';
$lang['halalan_gate_voter_password'] = 'Password';
$lang['halalan_gate_voter_login_button'] = 'Login';

// views/gate/admin.php
$lang['halalan_gate_admin_login_label'] = 'Login to Halalan as Admin';
$lang['halalan_gate_admin_username'] = 'Username';
$lang['halalan_gate_admin_password'] = 'Password';
$lang['halalan_gate_admin_login_button'] = 'Login';

// controllers/voter.php
$lang['halalan_voter_vote_title'] = 'Vote';
$lang['halalan_voter_vote_no_candidates'] = 'No candidates';
$lang['halalan_voter_vote_no_selected'] = 'No candidates selected';
$lang['halalan_voter_vote_not_all_selected'] = 'You have not voted in all positions.';
$lang['halalan_voter_vote_maximum'] = 'You have exceeded the number of votes in a certain position.';
$lang['halalan_voter_vote_abstain_and_others'] = 'You can not vote for a candidate if you chose to abstain.';

$lang['halalan_voter_confirm_vote_title'] = 'Confirm Vote';
$lang['halalan_voter_confirm_vote_from_vote'] = 'You must vote first';
$lang['halalan_voter_confirm_vote_no_captcha'] = 'No captcha entered';
$lang['halalan_voter_confirm_vote_not_captcha'] = 'Incorrect captcha';
$lang['halalan_voter_confirm_vote_no_pin'] = 'No PIN entered';
$lang['halalan_voter_confirm_vote_not_pin'] = 'Incorrect PIN';

// Admin Main Page
$lang['halalan_admin_title'] = 'Administration';
$lang['halalan_admin_home'] = 'Home';
$lang['halalan_admin_home_label'] = 'What do you want to do?';
$lang['halalan_admin_add_voter'] = 'Add Voter';
$lang['halalan_admin_add_candidate'] = 'Add Candidate';

// Other admin views
$lang['halalan_add_voter'] = 'Add Voter';
$lang['halalan_add_voter_submit'] = 'Submit';
$lang['halalan_add_voter_details'] = 'Voter Details';
$lang['halalan_add_voter_exists'] = 'Voter already exists.';
$lang['halalan_add_voter_no_username'] = 'Username required.';
$lang['halalan_add_voter_no_firstname'] = 'First name required.';
$lang['halalan_add_voter_no_lastname'] = 'Last name required.';
$lang['halalan_add_voter_success'] = 'Voter successfully added!';

$lang['halalan_logout_title'] = 'Logout';

// views/logout.php
$lang['halalan_logout_message'] = '<p>Thank you for using Halalan!</p><p>You have been automatically logged out.  Redirecting in 5 seconds...</p><p>Follow this ' . anchor(base_url(), 'link', 'title="Halalan - Login"') . ' if the redirection fails.</p>';


?>