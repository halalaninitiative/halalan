<?php

// common to controllers
$lang['halalan_common_unauthorized'] = 'You must be logged in to view this page.';

// common to views
$lang['halalan_common_message_box'] = 'Halalan Message Box';
$lang['halalan_common_view'] = 'View';
$lang['halalan_common_edit'] = 'Edit';
$lang['halalan_common_delete'] = 'Delete';
$lang['halalan_common_actions'] = 'Actions';
$lang['halalan_common_id'] = 'ID';

// controllers/gate.php
// common to voter_login and admin_login
$lang['halalan_gate_common_login_failure'] = 'Login failed.';
// index
// voter
$lang['halalan_gate_voter_title'] = 'Voter Login';
// voter_login
$lang['halalan_gate_voter_already_voted'] = 'You have already voted';
$lang['halalan_gate_voter_currently_logged_in'] = 'Voter currently logged in another session.';
// admin
$lang['halalan_gate_admin_title'] = 'Admin Login';
// admin_login
// logout
// results
$lang['halalan_gate_results_title'] = 'Results';
$lang['halalan_gate_results_unavailable'] = 'The results are not yet available.';
// statistics
$lang['halalan_gate_statistics_title'] = 'Statistics';

// views/gate/voter.php
$lang['halalan_gate_voter_login_label'] = 'LOGIN';
$lang['halalan_gate_voter_username'] = 'Username';
$lang['halalan_gate_voter_password'] = 'Password';
$lang['halalan_gate_voter_login_button'] = 'Login';
$lang['halalan_gate_voter_not_running'] = 'The election is not running. Please wait for the election administrator to activate the election.';
$lang['halalan_gate_voter_result'] = 'The ' . anchor('gate/results', 'results') . ' are now available!';

// views/gate/admin.php
$lang['halalan_gate_admin_login_label'] = 'ADMIN LOGIN';
$lang['halalan_gate_admin_username'] = 'Username';
$lang['halalan_gate_admin_password'] = 'Password';
$lang['halalan_gate_admin_login_button'] = 'Login';

// views/gate/result.php
$lang['halalan_gate_results_label'] = 'RESULTS';
$lang['halalan_gate_results_no_elections'] = 'There are no available election results yet.';
$lang['halalan_gate_results_no_candidates'] = 'No candidates found.';
$lang['halalan_gate_results_submit_button'] = 'Update Page';
$lang['halalan_gate_results_reminder'] = 'Select at least one election then press <em>Update Page</em>.';
// views/gate/statistics.php
$lang['halalan_gate_statistics_label'] = 'STATISTICS';

// controllers/voter.php
// commont to all functions
$lang['halalan_voter_common_not_running_one'] = 'The election is not running.';
$lang['halalan_voter_common_not_running_two'] = 'You cannot login at this time.';
// index
$lang['halalan_voter_index_title'] = 'Home';
// vote
$lang['halalan_voter_vote_title'] = 'Vote';
$lang['halalan_voter_vote_no_candidates'] = 'No candidates found.';
// do_vote
$lang['halalan_voter_vote_no_selected'] = 'No candidates selected';
$lang['halalan_voter_vote_not_all_selected'] = 'You have not voted in all positions.';
$lang['halalan_voter_vote_maximum'] = 'You have exceeded the number of votes in a certain position.';
$lang['halalan_voter_vote_abstain_and_others'] = 'You cannot vote for a candidate if you chose to abstain.';
// confirm_vote
$lang['halalan_voter_confirm_vote_title'] = 'Verify';
// do_confirm_vote
$lang['halalan_voter_confirm_vote_no_captcha'] = 'No captcha entered';
$lang['halalan_voter_confirm_vote_not_captcha'] = 'Incorrect captcha';
$lang['halalan_voter_confirm_vote_no_pin'] = 'No PIN entered';
$lang['halalan_voter_confirm_vote_not_pin'] = 'Incorrect PIN';
// logout
$lang['halalan_voter_logout_title'] = 'Logout';
// votes
$lang['halalan_voter_votes_title'] = 'Votes';
$lang['halalan_voter_votes_image_trail_disabled'] = 'Generation of image trail is disabled.';
$lang['halalan_voter_votes_image_trail_not_found'] = 'Image trail is not found.';

// views/voter/index.php
$lang['halalan_voter_index_label'] = 'List of Elections';
$lang['halalan_voter_index_election'] = 'Election';
$lang['halalan_voter_index_voted'] = 'Voted';
$lang['halalan_voter_index_status'] = 'Status';
$lang['halalan_voter_index_results'] = 'Results';
$lang['halalan_voter_index_no_elections'] = 'No elections found.';

// views/voter/vote.php
$lang['halalan_voter_vote_reminder'] = 'You still need to verify and confirm your votes in the next page.';
$lang['halalan_voter_vote_reminder_too'] = 'You can submit your votes by pressing the <em>Submit Ballot</em> button ' . anchor('voter/vote#bottom', 'below', array('class'=>'scrollToBottom')) . '.';
$lang['halalan_voter_vote_submit_button'] = 'Submit Ballot';

// views/voter/confirm_vote.php
$lang['halalan_voter_confirm_vote_validation_label'] = 'Validation';
$lang['halalan_voter_confirm_vote_captcha_label'] = 'Enter the word here:';
$lang['halalan_voter_confirm_vote_pin_label'] = 'Enter your PIN here:';
$lang['halalan_voter_confirm_vote_modify_button'] = 'Modify Votes';
$lang['halalan_voter_confirm_vote_submit_button'] = 'Confirm Ballot';
$lang['halalan_voter_confirm_vote_reminder'] = 'Once you press the <em>Confirm Ballot</em> button, you can no longer change your votes.';
$lang['halalan_voter_confirm_vote_reminder_too'] = '<strong>Your ballot has NOT been recorded yet.</strong><br />Please review your votes, then complete your submission by pressing the <em>Confirm Ballot</em> button ' . anchor('voter/verify#bottom', 'below', array('class'=>'scrollToBottom')) . '.';

// views/voter/logout.php
$lang['halalan_voter_logout_message'] = '<p>Your ballot has been recorded. Thank you for using Halalan!</p><p>You have been automatically logged out.  Redirecting in 5 seconds...</p><p>Follow this ' . anchor(base_url(), 'link', 'title="Halalan - Login"') . ' if the redirection fails.</p>';

// views/voter/votes.php
$lang['halalan_voter_votes_no_candidates'] = 'No candidates found.';
$lang['halalan_voter_votes_print_button'] = 'Generate Page for Printing';
$lang['halalan_voter_votes_download_button'] = 'Download Generated Image Trail';

// controllers/admin/
$lang['halalan_admin_common_running_one'] = 'The election is already running.';
$lang['halalan_admin_common_running_two'] = 'You cannot manage the election at this time.';

// controllers/admin/home.php
$lang['halalan_admin_home_title'] = 'Home';
$lang['halalan_admin_edit_option_success'] = 'The option has been successfully edited';
$lang['halalan_admin_regenerate_no_username'] = 'Username is required.';
$lang['halalan_admin_regenerate_no_email'] = 'Email is required.';
$lang['halalan_admin_regenerate_not_exists'] = 'The voter does not exist.';
$lang['halalan_admin_regenerate_invalid_email'] = 'Email is invalid.';
$lang['halalan_admin_regenerate_success'] = 'Regeneration successful.';
$lang['halalan_admin_regenerate_email_success'] = 'The new login credentials was successfully emailed.';

// controllers/admin/voters.php
$lang['halalan_admin_voters_title'] = 'Manage Voters';
$lang['halalan_admin_delete_voter_already_voted'] = 'A voter who has already voted cannot be deleted.';
$lang['halalan_admin_delete_voter_success'] = 'The voter has been successfully deleted.';
$lang['halalan_admin_edit_voter_title'] = 'Edit Voter';
$lang['halalan_admin_add_voter_title'] = 'Add Voter';
$lang['halalan_admin_voter_exists'] = 'Voter already exists';
$lang['halalan_admin_voter_dependencies'] = 'The voter is in use.  The Elections and Positions fields cannot be edited.';
$lang['halalan_admin_voter_email_success'] = 'The login credentials was successfully emailed.';
$lang['halalan_admin_add_voter_success'] = 'The voter has been successfully added.';
$lang['halalan_admin_edit_voter_success'] = 'The voter has been successfully edited.';
$lang['halalan_admin_import_title'] = 'Import Voters';
$lang['halalan_admin_import_success_singular'] = ' voter has been successfully imported.';
$lang['halalan_admin_import_success_plural'] = ' voters have been successfully imported.';
$lang['halalan_admin_import_reminder'] = 'You can use the Export Voters option to do batch generation of passwords.';
$lang['halalan_admin_import_reminder_too'] = ' and PINs.';
$lang['halalan_admin_export_title'] = 'Export Voters';
$lang['halalan_admin_voter_in_running_election'] = 'A voter in a running election cannot be modifed.';
$lang['halalan_admin_voter_running_election'] = 'A voter cannot be added to a running election.';

// controllers/admin/parties.php
$lang['halalan_admin_parties_title'] = 'Manage Parties';
$lang['halalan_admin_delete_party_in_use'] = 'A party which is in use cannot be deleted.';
$lang['halalan_admin_delete_party_success'] = 'The party has been successfully deleted.';
$lang['halalan_admin_edit_party_title'] = 'Edit Party';
$lang['halalan_admin_add_party_title'] = 'Add Party';
$lang['halalan_admin_party_exists'] = 'Party already exists';
$lang['halalan_admin_add_party_success'] = 'The party has been successfully added.';
$lang['halalan_admin_edit_party_success'] = 'The party has been successfully edited.';
$lang['halalan_admin_party_in_running_election'] = 'A party in a running election cannot be modifed.';

// controllers/admin/positions.php
$lang['halalan_admin_positions_title'] = 'Manage Positions';
$lang['halalan_admin_delete_position_in_use'] = 'A position which is in use cannot be deleted.';
$lang['halalan_admin_delete_position_success'] = 'The position has been successfully deleted.';
$lang['halalan_admin_edit_position_title'] = 'Edit Position';
$lang['halalan_admin_add_position_title'] = 'Add Position';
$lang['halalan_admin_position_exists'] = 'Position already exists';
$lang['halalan_admin_position_dependencies'] = 'The position is in use.  The Chosen Elections field cannot be edited.';
$lang['halalan_admin_add_position_success'] = 'The position has been successfully added.';
$lang['halalan_admin_edit_position_success'] = 'The position has been successfully edited.';
$lang['halalan_admin_position_in_running_election'] = 'A position in a running election cannot be modifed.';
$lang['halalan_admin_position_running_election'] = 'A position cannot be added to a running election.';

// controllers/admin/candidates.php
$lang['halalan_admin_candidates_title'] = 'Manage Candidates';
$lang['halalan_admin_delete_candidate_already_has_votes'] = 'The candidate who already has votes cannot be deleted.';
$lang['halalan_admin_delete_candidate_success'] = 'The candidate has been successfully deleted.';
$lang['halalan_admin_edit_candidate_title'] = 'Edit Candidate';
$lang['halalan_admin_add_candidate_title'] = 'Add Candidate';
$lang['halalan_admin_candidate_exists'] = 'Candidate already exists';
$lang['halalan_admin_candidate_dependencies'] = 'The candidate is in use.  The Election and Position fields cannot be edited.';
$lang['halalan_admin_add_candidate_success'] = 'The candidate has been successfully added.';
$lang['halalan_admin_edit_candidate_success'] = 'The candidate has been successfully edited.';
$lang['halalan_admin_candidate_in_running_election'] = 'A candidate in a running election cannot be modifed.';
$lang['halalan_admin_candidate_running_election'] = 'A candidate cannot be added to a running election.';

// controllers/admin/elections.php
$lang['halalan_admin_elections_title'] = 'Manage Elections';
$lang['halalan_admin_delete_election_in_use'] = 'An election which is in use cannot be deleted.';
$lang['halalan_admin_delete_election_running'] = 'An election which is running cannot be deleted.';
$lang['halalan_admin_delete_election_success'] = 'The election has been successfully deleted.';
$lang['halalan_admin_edit_election_title'] = 'Edit Election';
$lang['halalan_admin_add_election_title'] = 'Add Election';
//$lang['halalan_admin_party_exists'] = 'Party already exists';
$lang['halalan_admin_add_election_success'] = 'The election has been successfully added.';
$lang['halalan_admin_edit_election_running'] = 'An election which is running cannot be edited.';
$lang['halalan_admin_edit_election_success'] = 'The election has been successfully edited.';
$lang['halalan_admin_options_election_success'] = 'The election options has been successfully changed.';

// views/admin/home.php
$lang['halalan_admin_home_left_label'] = 'Manage Halalan';
$lang['halalan_admin_home_manage_question'] = 'What do you want to do?';
$lang['halalan_admin_home_manage_candidates'] = 'Manage Candidates';
$lang['halalan_admin_home_manage_elections'] = 'Manage Elections';
$lang['halalan_admin_home_manage_parties'] = 'Manage Parties';
$lang['halalan_admin_home_manage_positions'] = 'Manage Positions';
$lang['halalan_admin_home_manage_voters'] = 'Manage Voters';
$lang['halalan_admin_home_right_label'] = 'Regeneration Box';
$lang['halalan_admin_home_email'] = 'Email';
$lang['halalan_admin_home_username'] = 'Username';
$lang['halalan_admin_home_pin'] = 'Regenerate PIN too?';
$lang['halalan_admin_home_login'] = 'Reset login time? (for "logged in another session" errors)';
$lang['halalan_admin_home_submit'] = 'Regenerate';

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
$lang['halalan_admin_voter_elections'] = 'Elections';
$lang['halalan_admin_voter_no_elections'] = 'No elections found.  Create one in the Elections page.';
$lang['halalan_admin_voter_possible_elections'] = 'Possible Elections';
$lang['halalan_admin_voter_chosen_elections'] = 'Chosen Elections';
$lang['halalan_admin_voter_general_positions'] = 'General Positions';
$lang['halalan_admin_voter_specific_positions'] = 'Specific Positions';
$lang['halalan_admin_voter_possible_positions'] = 'Possible Positions';
$lang['halalan_admin_voter_chosen_positions'] = 'Chosen Positions';
$lang['halalan_admin_voter_regenerate'] = 'Regenerate';
$lang['halalan_admin_voter_password'] = 'Password';
$lang['halalan_admin_voter_pin'] = 'PIN';
$lang['halalan_admin_add_voter_submit'] = 'Add Voter';
$lang['halalan_admin_edit_voter_submit'] = 'Edit Voter';

// views/admin/parties.php
$lang['halalan_admin_parties_label'] = 'Manage Parties';
$lang['halalan_admin_parties_party'] = 'Party';
$lang['halalan_admin_parties_alias'] = 'Alias';
$lang['halalan_admin_parties_description'] = 'Description';
$lang['halalan_admin_parties_no_parties'] = 'No parties found.';
$lang['halalan_admin_parties_add'] = 'Add Party';

// views/admin/party.php
$lang['halalan_admin_add_party_label'] = 'Add Party Details';
$lang['halalan_admin_edit_party_label'] = 'Edit Party Details';
$lang['halalan_admin_party_party'] = 'Party';
$lang['halalan_admin_party_alias'] = 'Alias';
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
$lang['halalan_admin_position_possible_elections'] = 'Possible Elections';
$lang['halalan_admin_position_chosen_elections'] = 'Chosen Elections';
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
$lang['halalan_admin_candidate_alias'] = 'Alias';
$lang['halalan_admin_candidate_description'] = 'Description';
$lang['halalan_admin_candidate_party'] = 'Party';
$lang['halalan_admin_candidate_election'] = 'Election';
$lang['halalan_admin_candidate_position'] = 'Position';
$lang['halalan_admin_candidate_picture'] = 'Picture';
$lang['halalan_admin_add_candidate_submit'] = 'Add Candidate';
$lang['halalan_admin_edit_candidate_submit'] = 'Edit Candidate';

// views/admin/import.php
$lang['halalan_admin_import_label'] = 'Import Voters';
$lang['halalan_admin_import_elections'] = 'Elections';
$lang['halalan_admin_import_no_elections'] = 'No elections found.  Create one in the Elections page.';
$lang['halalan_admin_import_possible_elections'] = 'Possible Elections';
$lang['halalan_admin_import_chosen_elections'] = 'Chosen Elections';
$lang['halalan_admin_import_general_positions'] = 'General Positions';
$lang['halalan_admin_import_specific_positions'] = 'Specific Positions';
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
$lang['halalan_admin_export_pin'] = 'Include PIN?';
$lang['halalan_admin_export_pin_description'] = 'used for batch generation of PIN';
$lang['halalan_admin_export_votes'] = 'Include votes?';
$lang['halalan_admin_export_votes_description'] = 'used for manual counting of votes';
$lang['halalan_admin_export_status'] = 'Include status?';
$lang['halalan_admin_export_status_description'] = 'used for determining who voted or not';
$lang['halalan_admin_export_submit'] = 'Export';

// views/admin/elections.php
$lang['halalan_admin_elections_label'] = 'Manage Elections';
$lang['halalan_admin_elections_election'] = 'Election';
$lang['halalan_admin_elections_status'] = 'Status';
$lang['halalan_admin_elections_results'] = 'Results';
$lang['halalan_admin_elections_no_elections'] = 'No elections found.';
$lang['halalan_admin_elections_add'] = 'Add Election';

// views/admin/election.php
$lang['halalan_admin_add_election_label'] = 'Add Election Details';
$lang['halalan_admin_edit_election_label'] = 'Edit Election Details';
$lang['halalan_admin_election_election'] = 'Election';
$lang['halalan_admin_election_parent'] = 'Parent';
$lang['halalan_admin_election_notes'] = 'Notes';
$lang['halalan_admin_add_election_submit'] = 'Add Election';
$lang['halalan_admin_edit_election_submit'] = 'Edit Election';

?>
