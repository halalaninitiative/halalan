<?php

// common to controllers
$lang['halalan_unauthorized'] = 'Kailangang nakapasok ka para makita ang pahina na ito.';

// common to views
$lang['halalan_message_box'] = 'Halalan Message Box';
$lang['halalan_edit'] = 'Baguhin';
$lang['halalan_delete'] = 'Tanggalin';
$lang['halalan_voted'] = 'Voted';
$lang['halalan_name'] = 'Pangalan';
$lang['halalan_unit'] = 'Unit';
$lang['halalan_action'] = 'Aksyon';

// controllers/gate.php
$lang['halalan_gate_login_failure'] = 'Hindi matagumpay na pagpasok.  Boo!'; // common
$lang['halalan_gate_voter_title'] = 'Voter Login';
$lang['halalan_gate_voter_already_voted'] = 'ikaw ay nakaboto na';
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
$lang['halalan_voter_vote_no_candidates'] = 'walang kandidato';
$lang['halalan_voter_vote_no_selected'] = 'walang piniling kandidato';
$lang['halalan_voter_vote_not_all_selected'] = 'hindi lahat ng posisyon ay may napiling kandidato';
$lang['halalan_voter_vote_maximum'] = 'lumampas ang boto mo sa dapat';
$lang['halalan_voter_vote_abstain_and_others'] = 'hindi pwedeng pumili ng ibang kandidato kapag napili ang abstain';

$lang['halalan_voter_confirm_vote_title'] = 'Confirm Vote';
$lang['halalan_voter_confirm_vote_from_vote'] = 'kailangang bumoto ka muna';
$lang['halalan_voter_confirm_vote_no_captcha'] = 'walang nilagay na captcha';
$lang['halalan_voter_confirm_vote_not_captcha'] = 'maling nilagay na captcha';
$lang['halalan_voter_confirm_vote_no_pin'] = 'walang nilagay na PIN';
$lang['halalan_voter_confirm_vote_not_pin'] = 'maling nilagay na PIN';

$lang['halalan_voter_logout_title'] = 'Logout';

// views/voter/logout.php
$lang['halalan_voter_logout_message'] = '<p>Thank you for using Halalan!</p><p>You have been automatically logged out.  Redirecting in 5 seconds...</p><p>Follow this ' . anchor(base_url(), 'link', 'title="Halalan - Login"') . ' if the redirection fails.</p>';

// controllers/admin.php
$lang['halalan_admin_manage_title'] = 'Administration';
$lang['halalan_admin_voters_title'] = 'Manage Voters';
$lang['halalan_admin_add_voter_title'] = 'Magdagdag ng botante';
$lang['halalan_admin_edit_voter_title'] = 'Baguhin ang botante';
$lang['halalan_admin_delete_voter_already_voted'] = 'Cannot delete a voter who has already voted';
$lang['halalan_admin_delete_voter_success'] = 'The voter has been successfully deleted';
// common to add and edit voter
$lang['halalan_admin_voter_no_username'] = 'Kailangan ang username.';
$lang['halalan_admin_voter_exists'] = 'Meron nang ganitong boter.';
$lang['halalan_admin_voter_no_first_name'] = 'Kailangan ang first name.';
$lang['halalan_admin_voter_no_last_name'] = 'Kailangan ang last name.';
//
$lang['halalan_admin_add_voter_success'] = 'Matagumpay ang pagdagdag ng botante!';
$lang['halalan_admin_edit_voter_success'] = 'Matagumpay ang pagbabago ng botante!';
// parties
$lang['halalan_admin_parties_title'] = 'Manage Parties';
$lang['halalan_admin_add_party_title'] = 'Add Party';
$lang['halalan_admin_edit_party_title'] = 'Edit Party';
// common to add and edit party
$lang['halalan_admin_party_no_party'] = 'Party is required';
//
$lang['halalan_admin_add_party_success'] = 'The party has been successfully added.';
$lang['halalan_admin_edit_party_success'] = 'The party has been successfully edited.';
$lang['halalan_admin_delete_party_success'] = 'The party has been successfully deleted';
// positions
$lang['halalan_admin_positions_title'] = 'Manage Positions';
$lang['halalan_admin_add_position_title'] = 'Add Position';
$lang['halalan_admin_edit_position_title'] = 'Edit Position';
// common to add and edit position
$lang['halalan_admin_position_no_position'] = 'Position is required';
$lang['halalan_admin_position_no_maximum'] = 'Maximum is required';
$lang['halalan_admin_position_maximum_not_digit'] = 'Maximum should be a digit';
$lang['halalan_admin_position_no_ordinality'] = 'Ordinality is required';
$lang['halalan_admin_position_ordinality_not_digit'] = 'Ordinality should be a digit';
//
$lang['halalan_admin_add_position_success'] = 'The position has been successfully added.';
$lang['halalan_admin_edit_position_success'] = 'The position has been successfully edited.';
$lang['halalan_admin_delete_position_success'] = 'The position has been successfully deleted';
// candidates
$lang['halalan_admin_candidates_title'] = 'Manage Candidates';
$lang['halalan_admin_add_candidate_title'] = 'Add Candidate';
$lang['halalan_admin_edit_candidate_title'] = 'Edit Candidate';
// common to add and edit candidate
$lang['halalan_admin_candidate_no_first_name'] = 'First name is required';
$lang['halalan_admin_candidate_no_last_name'] = 'Last name is required';
$lang['halalan_admin_candidate_no_position'] = 'Position is required';
//
$lang['halalan_admin_add_candidate_success'] = 'The candidate has been successfully added.';
$lang['halalan_admin_edit_candidate_success'] = 'The candidate has been successfully edited.';
$lang['halalan_admin_delete_candidate_success'] = 'The candidate has been successfully deleted';

// views/admin/voters.php
$lang['halalan_admin_voters_voted'] = 'Voted';
$lang['halalan_admin_voters_name'] = 'Pangalan';
$lang['halalan_admin_voters_action'] = 'Aksyon';

// views/admin/edit_voter.php
$lang['halalan_admin_edit_voter_legend'] = 'Mga detalye ng botante na babaguhin';
$lang['halalan_admin_edit_voter_submit'] = 'Baguhin';

// views/admin/parties.php
$lang['halalan_admin_parties_party'] = 'Party';
$lang['halalan_admin_parties_description'] = 'Description';
$lang['halalan_admin_parties_action'] = 'Action';
$lang['halalan_admin_parties_add'] = 'Add Party';

// views/admin/add_party.php
$lang['halalan_admin_add_party_legend'] = 'Add Party Details';
$lang['halalan_admin_add_party_party'] = 'Party';
$lang['halalan_admin_add_party_description'] = 'Description';
$lang['halalan_admin_add_party_logo'] = 'Logo';
$lang['halalan_admin_add_party_submit'] = 'Add';

// views/admin/edit_party.php
$lang['halalan_admin_edit_party_legend'] = 'Edit Party Details';
$lang['halalan_admin_edit_party_party'] = 'Party';
$lang['halalan_admin_edit_party_description'] = 'Description';
$lang['halalan_admin_edit_party_logo'] = 'Logo';
$lang['halalan_admin_edit_party_submit'] = 'Edit';

// views/admin/positions.php
$lang['halalan_admin_positions_position'] = 'Position';
$lang['halalan_admin_positions_description'] = 'Description';
$lang['halalan_admin_positions_action'] = 'Action';
$lang['halalan_admin_positions_add'] = 'Add Position';

// views/admin/add_position.php
$lang['halalan_admin_add_position_legend'] = 'Add Position Details';
$lang['halalan_admin_add_position_position'] = 'Position';
$lang['halalan_admin_add_position_description'] = 'Description';
$lang['halalan_admin_add_position_maximum'] = 'Maximum';
$lang['halalan_admin_add_position_ordinality'] = 'Ordinality';
$lang['halalan_admin_add_position_abstain'] = 'Abstain';
$lang['halalan_admin_add_position_unit'] = 'Type';
$lang['halalan_admin_add_position_submit'] = 'Add';

// views/admin/edit_position.php
$lang['halalan_admin_edit_position_legend'] = 'Edit Position Details';
$lang['halalan_admin_edit_position_position'] = 'Position';
$lang['halalan_admin_edit_position_description'] = 'Description';
$lang['halalan_admin_edit_position_maximum'] = 'Maximum';
$lang['halalan_admin_edit_position_ordinality'] = 'Ordinality';
$lang['halalan_admin_edit_position_abstain'] = 'Abstain';
$lang['halalan_admin_edit_position_unit'] = 'Type';
$lang['halalan_admin_edit_position_submit'] = 'Edit';

// views/admin/candidates.php
$lang['halalan_admin_candidates_candidate'] = 'Candidate';
$lang['halalan_admin_candidates_description'] = 'Description';
$lang['halalan_admin_candidates_action'] = 'Action';
$lang['halalan_admin_candidates_add'] = 'Add Candidate';

// views/admin/add_candidate.php
$lang['halalan_admin_add_candidate_legend'] = 'Add Candidate Details';
$lang['halalan_admin_add_candidate_first_name'] = 'First Name';
$lang['halalan_admin_add_candidate_last_name'] = 'Last Name';
$lang['halalan_admin_add_candidate_description'] = 'Description';
$lang['halalan_admin_add_candidate_party'] = 'Party';
$lang['halalan_admin_add_candidate_position'] = 'Position';
$lang['halalan_admin_add_candidate_picture'] = 'Picture';
$lang['halalan_admin_add_candidate_submit'] = 'Add';

// views/admin/edit_candidate.php
$lang['halalan_admin_edit_candidate_legend'] = 'Edit Candidate Details';
$lang['halalan_admin_edit_candidate_first_name'] = 'First Name';
$lang['halalan_admin_edit_candidate_last_name'] = 'Last Name';
$lang['halalan_admin_edit_candidate_description'] = 'Description';
$lang['halalan_admin_edit_candidate_party'] = 'Party';
$lang['halalan_admin_edit_candidate_position'] = 'Position';
$lang['halalan_admin_edit_candidate_picture'] = 'Picture';
$lang['halalan_admin_edit_candidate_submit'] = 'Edit';

// Admin Main Page
$lang['halalan_admin_title'] = 'Administration';
$lang['halalan_admin_home'] = 'Home';
$lang['halalan_admin_home_label'] = 'Ano ang gusto mong gawin?';
$lang['halalan_admin_add_voter'] = 'Magdagdag ng botante';
$lang['halalan_admin_add_candidate'] = 'Magdagdag ng kandidato';

// Other admin views
$lang['halalan_add_voter_submit'] = 'Idagdag';
$lang['halalan_add_voter_details'] = 'Mga detalye ng botante na idadagdag';

?>