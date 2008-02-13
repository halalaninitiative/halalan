<?php

// common to controllers
$lang['halalan_common_unauthorized'] = 'You must be logged in to view this page.';

// common to views
$lang['halalan_common_message_box'] = 'Halalan Message Box';
$lang['halalan_common_edit'] = 'Edit';
$lang['halalan_common_delete'] = 'Delete';
$lang['halalan_common_action'] = 'Action';

// controllers/gate.php
// common to voter_login and admin_login
$lang['halalan_gate_common_login_failure'] = 'Login failed.';
// index
// voter
$lang['halalan_gate_voter_title'] = 'Voter Login';
// voter_login
$lang['halalan_gate_voter_already_voted'] = 'You have already voted';
// admin
$lang['halalan_gate_admin_title'] = 'Admin Login';
// admin_login
// logout
// result
$lang['halalan_gate_result_title'] = 'Result';
$lang['halalan_gate_result_unavailable'] = 'The result is not yet available.';

// views/gate/voter.php
$lang['halalan_gate_voter_login_label'] = 'Login to Halalan';
$lang['halalan_gate_voter_username'] = 'Username';
$lang['halalan_gate_voter_password'] = 'Password';
$lang['halalan_gate_voter_login_button'] = 'Login';
$lang['halalan_gate_voter_not_running'] = 'The election is not running. Please wait for the election administrator to activate the election.';
$lang['halalan_gate_voter_result'] = 'The result is now available! View it ' . anchor('gate/result', 'here');

// views/gate/admin.php
$lang['halalan_gate_admin_login_label'] = 'Login to Halalan as Admin';
$lang['halalan_gate_admin_username'] = 'Username';
$lang['halalan_gate_admin_password'] = 'Password';
$lang['halalan_gate_admin_login_button'] = 'Login';

// views/gate/result.php
$lang['halalan_gate_result_no_candidates'] = 'No candidates found.';

// controllers/voter.php
// commont to all functions
$lang['halalan_voter_common_not_running_one'] = 'The election is not running.';
$lang['halalan_voter_common_not_running_two'] = 'You cannot login at this time.';
// index
// vote
$lang['halalan_voter_vote_title'] = 'Vote';
$lang['halalan_voter_vote_no_candidates'] = 'No candidates found.';
// do_vote
$lang['halalan_voter_vote_no_selected'] = 'No candidates selected';
$lang['halalan_voter_vote_not_all_selected'] = 'You have not voted in all positions.';
$lang['halalan_voter_vote_maximum'] = 'You have exceeded the number of votes in a certain position.';
$lang['halalan_voter_vote_abstain_and_others'] = 'You can not vote for a candidate if you chose to abstain.';
// confirm_vote
$lang['halalan_voter_confirm_vote_title'] = 'Confirm Vote';
// do_confirm_vote
$lang['halalan_voter_confirm_vote_no_captcha'] = 'No captcha entered';
$lang['halalan_voter_confirm_vote_not_captcha'] = 'Incorrect captcha';
$lang['halalan_voter_confirm_vote_no_pin'] = 'No PIN entered';
$lang['halalan_voter_confirm_vote_not_pin'] = 'Incorrect PIN';
// logout
$lang['halalan_voter_logout_title'] = 'Logout';

// views/voter/vote.php
$lang['halalan_voter_vote_submit_button'] = 'Vote';

// views/voter/confirm_vote.php
$lang['halalan_voter_confirm_vote_validation_label'] = 'Validation';
$lang['halalan_voter_confirm_vote_captcha_label'] = 'Enter the word here:';
$lang['halalan_voter_confirm_vote_pin_label'] = 'Enter your pin here:';
$lang['halalan_voter_confirm_vote_submit_button'] = 'Confirm';
$lang['halalan_voter_confirm_vote_reminder'] = 'Once you press the confirm button, you can no longer change your votes.';

// views/voter/logout.php
$lang['halalan_voter_logout_message'] = '<p>Thank you for using Halalan!</p><p>You have been automatically logged out.  Redirecting in 5 seconds...</p><p>Follow this ' . anchor(base_url(), 'link', 'title="Halalan - Login"') . ' if the redirection fails.</p>';

// controllers/admin.php
// commont to all functions
$lang['halalan_admin_common_running_one'] = 'The election is already running.';
$lang['halalan_admin_common_running_two'] = 'You cannot manage the election at this time.';
// index
// home
$lang['halalan_admin_home_title'] = 'Home';
// do_edit_options
$lang['halalan_admin_edit_option_success'] = 'The option has been successfully edited';
// voters
$lang['halalan_admin_voters_title'] = 'Manage Voters';
// parties
$lang['halalan_admin_parties_title'] = 'Manage Parties';
// positions
$lang['halalan_admin_positions_title'] = 'Manage Positions';
// candidates
$lang['halalan_admin_candidates_title'] = 'Manage Candidates';
// delete
$lang['halalan_admin_delete_voter_already_voted'] = 'A voter who has already voted cannot be deleted.';
$lang['halalan_admin_delete_voter_success'] = 'The voter has been successfully deleted.';
$lang['halalan_admin_delete_party_in_used'] = 'A party which is in used cannot be deleted.';
$lang['halalan_admin_delete_party_success'] = 'The party has been successfully deleted.';
$lang['halalan_admin_delete_position_in_used'] = 'A position which is in used cannot be deleted.';
$lang['halalan_admin_delete_position_success'] = 'The position has been successfully deleted.';
$lang['halalan_admin_delete_candidate_already_has_votes'] = 'The candidate who already has votes cannot be deleted.';
$lang['halalan_admin_delete_candidate_success'] = 'The candidate has been successfully deleted.';
// edit
$lang['halalan_admin_edit_voter_title'] = 'Edit Voter';
$lang['halalan_admin_edit_party_title'] = 'Edit Party';
$lang['halalan_admin_edit_position_title'] = 'Edit Position';
$lang['halalan_admin_edit_candidate_title'] = 'Edit Candidate';
// add
$lang['halalan_admin_add_voter_title'] = 'Add Voter';
$lang['halalan_admin_add_party_title'] = 'Add Party';
$lang['halalan_admin_add_position_title'] = 'Add Position';
$lang['halalan_admin_add_candidate_title'] = 'Add Candidate';
// common to do_add_voter and do_edit_voter
$lang['halalan_admin_voter_no_username'] = 'Username is required';
$lang['halalan_admin_voter_no_email'] = 'Email is required';
$lang['halalan_admin_voter_exists'] = 'Voter already exists';
$lang['halalan_admin_voter_invalid_email'] = 'Email is invalid';
$lang['halalan_admin_voter_no_last_name'] = 'Last name is required';
$lang['halalan_admin_voter_no_first_name'] = 'First name is required';
$lang['halalan_admin_voter_email_success'] = 'The login credentials was successfully emailed.';
// do_add_voter
$lang['halalan_admin_add_voter_success'] = 'The voter has been successfully added.';
// do_edit_voter
$lang['halalan_admin_edit_voter_success'] = 'The voter has been successfully edited.';
// common to do_add_party and do_edit_party
$lang['halalan_admin_party_no_party'] = 'Party is required';
// do_add_party
$lang['halalan_admin_add_party_success'] = 'The party has been successfully added.';
// do_edit_party
$lang['halalan_admin_edit_party_success'] = 'The party has been successfully edited.';
// common to do_add_position and do_edit_position
$lang['halalan_admin_position_no_position'] = 'Position is required';
$lang['halalan_admin_position_no_maximum'] = 'Maximum is required';
$lang['halalan_admin_position_maximum_not_digit'] = 'Maximum should be a digit';
$lang['halalan_admin_position_no_ordinality'] = 'Ordinality is required';
$lang['halalan_admin_position_ordinality_not_digit'] = 'Ordinality should be a digit';
// do_add_position
$lang['halalan_admin_add_position_success'] = 'The position has been successfully added.';
// do_edit_position
$lang['halalan_admin_edit_position_success'] = 'The position has been successfully edited.';
// common to do_add_candidate and do_edit_candidate
$lang['halalan_admin_candidate_no_first_name'] = 'First name is required';
$lang['halalan_admin_candidate_no_last_name'] = 'Last name is required';
$lang['halalan_admin_candidate_no_position'] = 'Position is required';
// do_add_candidate
$lang['halalan_admin_add_candidate_success'] = 'The candidate has been successfully added.';
// do_edit_candidate
$lang['halalan_admin_edit_candidate_success'] = 'The candidate has been successfully edited.';
// import
$lang['halalan_admin_import_title'] = 'Import Voters';
// do_import
$lang['halalan_admin_import_success_singular'] = ' voter has been successfully imported.';
$lang['halalan_admin_import_success_plural'] = ' voters have been successfully imported.';
$lang['halalan_admin_import_reminder'] = 'You can use the Export Voters option to do batch generation of passwords.';
$lang['halalan_admin_import_reminder_too'] = ' and pins.';
// export
$lang['halalan_admin_export_title'] = 'Export Voters';

// views/admin/home.php
$lang['halalan_admin_home_left_label'] = 'Manage Halalan';
$lang['halalan_admin_home_right_label'] = 'Options';

// views/admin/voters.php
$lang['halalan_admin_voters_label'] = 'Manage Voters';
$lang['halalan_admin_voters_voted'] = 'Voted';
$lang['halalan_admin_voters_name'] = 'Name';
$lang['halalan_admin_voters_no_voters'] = 'No voters found.';
$lang['halalan_admin_voters_add'] = 'Add Voter';

// views/admin/voter.php
$lang['halalan_admin_add_voter_label'] = 'Add Voter Details';
$lang['halalan_admin_edit_voter_label'] = 'Edit Voter Details';
$lang['halalan_admin_voter_email'] = 'Email';
$lang['halalan_admin_voter_username'] = 'Username';
$lang['halalan_admin_voter_first_name'] = 'First Name';
$lang['halalan_admin_voter_last_name'] = 'Last Name';
$lang['halalan_admin_voter_general_positions'] = 'General Positions';
$lang['halalan_admin_voter_no_general_positions'] = 'No general positions found.';
$lang['halalan_admin_voter_specific_positions'] = 'Specific Positions';
$lang['halalan_admin_voter_no_specific_positions'] = 'No specific positions found.';
$lang['halalan_admin_voter_possible_positions'] = 'Possible Positions';
$lang['halalan_admin_voter_chosen_positions'] = 'Chosen Positions';
$lang['halalan_admin_voter_regenerate'] = 'Regenerate';
$lang['halalan_admin_voter_password'] = 'Password';
$lang['halalan_admin_voter_pin'] = 'Pin';
$lang['halalan_admin_add_voter_submit'] = 'Add Voter';
$lang['halalan_admin_edit_voter_submit'] = 'Edit Voter';

// views/admin/parties.php
$lang['halalan_admin_parties_label'] = 'Manage Parties';
$lang['halalan_admin_parties_party'] = 'Party';
$lang['halalan_admin_parties_description'] = 'Description';
$lang['halalan_admin_parties_no_parties'] = 'No parties found.';
$lang['halalan_admin_parties_add'] = 'Add Party';

// views/admin/party.php
$lang['halalan_admin_add_party_label'] = 'Add Party Details';
$lang['halalan_admin_edit_party_label'] = 'Edit Party Details';
$lang['halalan_admin_party_party'] = 'Party';
$lang['halalan_admin_party_description'] = 'Description';
$lang['halalan_admin_party_logo'] = 'Logo';
$lang['halalan_admin_add_party_submit'] = 'Add Party';
$lang['halalan_admin_edit_party_submit'] = 'Edit Party';

// views/admin/positions.php
$lang['halalan_admin_positions_label'] = 'Manage Positions';
$lang['halalan_admin_positions_position'] = 'Position';
$lang['halalan_admin_positions_description'] = 'Description';
$lang['halalan_admin_positions_no_positions'] = 'No positions found.';
$lang['halalan_admin_positions_add'] = 'Add Position';

// views/admin/position.php
$lang['halalan_admin_add_position_label'] = 'Add Position Details';
$lang['halalan_admin_edit_position_label'] = 'Edit Position Details';
$lang['halalan_admin_position_position'] = 'Position';
$lang['halalan_admin_position_description'] = 'Description';
$lang['halalan_admin_position_maximum'] = 'Maximum';
$lang['halalan_admin_position_ordinality'] = 'Ordinality';
$lang['halalan_admin_position_abstain'] = 'Abstain';
$lang['halalan_admin_position_unit'] = 'Type';
$lang['halalan_admin_add_position_submit'] = 'Add Position';
$lang['halalan_admin_edit_position_submit'] = 'Edit Position';

// views/admin/candidates.php
$lang['halalan_admin_candidates_label'] = 'Manage Candidates';
$lang['halalan_admin_candidates_candidate'] = 'Candidate';
$lang['halalan_admin_candidates_description'] = 'Description';
$lang['halalan_admin_candidates_no_candidates'] = 'No candidates found.';
$lang['halalan_admin_candidates_add'] = 'Add Candidate';

// views/admin/candidate.php
$lang['halalan_admin_add_candidate_label'] = 'Add Candidate Details';
$lang['halalan_admin_edit_candidate_label'] = 'Edit Candidate Details';
$lang['halalan_admin_candidate_first_name'] = 'First Name';
$lang['halalan_admin_candidate_last_name'] = 'Last Name';
$lang['halalan_admin_candidate_description'] = 'Description';
$lang['halalan_admin_candidate_party'] = 'Party';
$lang['halalan_admin_candidate_position'] = 'Position';
$lang['halalan_admin_candidate_picture'] = 'Picture';
$lang['halalan_admin_add_candidate_submit'] = 'Add Candidate';
$lang['halalan_admin_edit_candidate_submit'] = 'Edit Candidate';

// views/admin/import.php
$lang['halalan_admin_import_label'] = 'Import Voters';
$lang['halalan_admin_import_general_positions'] = 'General Positions';
$lang['halalan_admin_import_no_general_positions'] = 'No general positions found.';
$lang['halalan_admin_import_specific_positions'] = 'Specific Positions';
$lang['halalan_admin_import_no_specific_positions'] = 'No specific positions found.';
$lang['halalan_admin_import_possible_positions'] = 'Possible Positions';
$lang['halalan_admin_import_chosen_positions'] = 'Chosen Positions';
$lang['halalan_admin_import_csv'] = 'CSV';
$lang['halalan_admin_import_sample'] = 'Sample Format';
$lang['halalan_admin_import_notes'] = 'Notes';
$lang['halalan_admin_import_submit'] = 'Import';

// views/admin/export.php
$lang['halalan_admin_export_label'] = 'Export Voters';
$lang['halalan_admin_export_password'] = 'Include password?';
$lang['halalan_admin_export_password_description'] = 'used for batch generation of password';
$lang['halalan_admin_export_pin'] = 'Include pin?';
$lang['halalan_admin_export_pin_description'] = 'used for batch generation of pin';
$lang['halalan_admin_export_votes'] = 'Include votes?';
$lang['halalan_admin_export_votes_description'] = 'used for manual counting of votes';
$lang['halalan_admin_export_status'] = 'Include status?';
$lang['halalan_admin_export_status_description'] = 'used for determining who voted or not';
$lang['halalan_admin_export_submit'] = 'Export';

?>