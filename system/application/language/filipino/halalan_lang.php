<?php

// common to controllers
$lang['halalan_common_unauthorized'] = 'Kailangang nakapasok ka para makita ang pahina na ito.';

// common to views
$lang['halalan_common_message_box'] = 'Halalan Message Box';
$lang['halalan_common_edit'] = 'Baguhin';
$lang['halalan_common_delete'] = 'Tanggalin';
$lang['halalan_common_action'] = 'Aksyon';

// controllers/gate.php
// common to voter_login and admin_login
$lang['halalan_gate_common_login_failure'] = 'Hindi matagumpay na pagpasok.';
// index
// voter
$lang['halalan_gate_voter_title'] = 'Voter Login';
// voter_login
$lang['halalan_gate_voter_already_voted'] = 'Ikaw ay nakaboto na.';
$lang['halalan_gate_voter_currently_logged_in'] = 'Ang botante ay kasalukuyang naka-log-in sa ibang session.';
// admin
$lang['halalan_gate_admin_title'] = 'Admin Login';
// admin_login
// logout
// result
$lang['halalan_gate_result_title'] = 'Resulta';
$lang['halalan_gate_result_unavailable'] = 'Wala pa ang mga resulta ng eleksyon.';
// statistics
$lang['halalan_gate_statistics_title'] = 'Statistics';

// views/gate/voter.php
$lang['halalan_gate_voter_login_label'] = 'LOGIN';
$lang['halalan_gate_voter_username'] = 'Username';
$lang['halalan_gate_voter_password'] = 'Password';
$lang['halalan_gate_voter_login_button'] = 'Login';
$lang['halalan_gate_voter_not_running'] = 'Hindi pa nagsisimula ang eleksyon. Hintaying simulan ito ng tagapamahala ng eleksyon.';
$lang['halalan_gate_voter_result'] = 'Ang resulta ng eleksyon ay matatagpuan ' . anchor('gate/results', 'dito') . '.';

// views/gate/admin.php
$lang['halalan_gate_admin_login_label'] = 'ADMIN LOGIN';
$lang['halalan_gate_admin_username'] = 'Username';
$lang['halalan_gate_admin_password'] = 'Password';
$lang['halalan_gate_admin_login_button'] = 'Login';

// views/gate/result.php
$lang['halalan_gate_result_label'] = 'RESULTA';
$lang['halalan_gate_result_no_candidates'] = 'Walang mga kandidato.';
$lang['halalan_gate_result_submit_button'] = 'Update Page';
$lang['halalan_gate_result_reminder'] = 'Select at least one position then press <em>Update Page</em>.';
// views/gate/statistics.php
$lang['halalan_gate_statistics_label'] = 'STATISTICS';


// controllers/voter.php
// commont to all functions
$lang['halalan_voter_common_not_running_one'] = 'Hindi pa tumatakbo ang eleksyon.';
$lang['halalan_voter_common_not_running_two'] = 'Hindi ka maaaring makapasok ngayon.';
// index
// vote
$lang['halalan_voter_vote_title'] = 'Pagboto';
$lang['halalan_voter_vote_no_candidates'] = 'Walang mga kandidato.';
// do_vote
$lang['halalan_voter_vote_no_selected'] = 'Walang napiling kandidato';
$lang['halalan_voter_vote_not_all_selected'] = 'Hindi lahat ng posisyon ay nabotohan.';
$lang['halalan_voter_vote_maximum'] = 'Lumagpas ka sa bilang ng maaaring iboto sa isang posisyon.';
$lang['halalan_voter_vote_abstain_and_others'] = 'Hindi ka maaaring pumili ng kandidato kung napili na ang abstain.';
// confirm_vote
$lang['halalan_voter_confirm_vote_title'] = 'Pagkumpirma';
// do_confirm_vote
$lang['halalan_voter_confirm_vote_no_captcha'] = 'Walang nilagay na captcha';
$lang['halalan_voter_confirm_vote_not_captcha'] = 'Mali ang nilagay na captcha';
$lang['halalan_voter_confirm_vote_no_pin'] = 'Walang nilagay na PIN';
$lang['halalan_voter_confirm_vote_not_pin'] = 'Mali ang nilagay na PIN';
// logout
$lang['halalan_voter_logout_title'] = 'Logout';
// votes
$lang['halalan_voter_votes_title'] = 'Mga Boto';

// views/voter/vote.php
$lang['halalan_voter_vote_reminder'] = 'Kailangan pang kumpirmahin ang iyong mga boto sa susunod na pahina.';
$lang['halalan_voter_vote_reminder_too'] = 'Isumite ang iyong mga boto sa pamamagitan ng pagpindot ng Isumite sa ' . anchor('voter/vote#bottom', 'baba', array('class'=>'scrollToBottom')) . '.';
$lang['halalan_voter_vote_submit_button'] = 'Isumite';

// views/voter/confirm_vote.php
$lang['halalan_voter_confirm_vote_validation_label'] = 'Pagkumpirma';
$lang['halalan_voter_confirm_vote_captcha_label'] = 'Ilagay ang salita dito:';
$lang['halalan_voter_confirm_vote_pin_label'] = 'Ilagay ang PIN dito:';
$lang['halalan_voter_confirm_vote_modify_button'] = 'Baguhin';
$lang['halalan_voter_confirm_vote_submit_button'] = 'Kumpirmahin';
$lang['halalan_voter_confirm_vote_reminder'] = 'Hindi na maaaring baguhin ang boto matapos pindutin ang <em>Kumpirmahin</em>.';
$lang['halalan_voter_confirm_vote_reminder_too'] = '<strong>Hindi pa naitatala ang iyong balota.</strong><br />Tingnan muli ang mga boto at pindutin ang <em>Kumpirmahin</em> sa ' . anchor('voter/verify#bottom', 'baba', array('class'=>'scrollToBottom')) . ' kung sigurado na sa iyong mga boto.';

// views/voter/logout.php
$lang['halalan_voter_logout_message'] = '<p>Naitala na ang iyong balota. Salamat sa paggamit ng Halalan!</p><p>Ikaw ay na-i-log-out na.  Redirecting in 5 seconds...</p><p>Follow this ' . anchor(base_url(), 'link', 'title="Halalan - Login"') . ' if the redirection fails.</p>';

// views/voter/votes.php
$lang['halalan_voter_votes_no_candidates'] = 'Walang natagpuang kandidato.';
$lang['halalan_voter_votes_submit_button'] = 'Generate Page for Printing';

// controllers/admin.php
// commont to all functions
$lang['halalan_admin_common_running_one'] = 'Tumatakbo na ang eleksyon.';
$lang['halalan_admin_common_running_two'] = 'Hindi mo maaaring galawin ang eleksyon ngayon.';
// index
// home
$lang['halalan_admin_home_title'] = 'Home';
// do_edit_options
$lang['halalan_admin_edit_option_success'] = 'Matagumpay na napalitan ang opsyon.';
// do_regenerate
$lang['halalan_admin_regenerate_no_username'] = 'Kinakailangan ang username.';
$lang['halalan_admin_regenerate_no_email'] = 'Kinakailangan ang email.';
$lang['halalan_admin_regenerate_not_exists'] = 'Walang ganitong botante.';
$lang['halalan_admin_regenerate_invalid_email'] = 'Hindi katanggap-tanggap ang email.';
$lang['halalan_admin_regenerate_success'] = 'Tagumpay.';
$lang['halalan_admin_regenerate_email_success'] = 'Matagumpay na naipadala ang impormasyon para sa login.';
// voters
$lang['halalan_admin_voters_title'] = 'Manage Voters';
// parties
$lang['halalan_admin_parties_title'] = 'Manage Parties';
// positions
$lang['halalan_admin_positions_title'] = 'Manage Positions';
// candidates
$lang['halalan_admin_candidates_title'] = 'Manage Candidates';
// delete
$lang['halalan_admin_delete_voter_already_voted'] = 'Hindi maaaring tanggalin ang botanteng nakaboto na.';
$lang['halalan_admin_delete_voter_success'] = 'Matagumpay na natanggal ang botante.';
$lang['halalan_admin_delete_party_in_use'] = 'Hindi maaaring tanggalin ang partido kasalukuyang ginagamit.';
$lang['halalan_admin_delete_party_success'] = 'Matagumpay na natanggal ang partido.';
$lang['halalan_admin_delete_position_in_use'] = 'Hindi maaaring tanggalin ang posisyon na kasalukuyang ginagamit.';
$lang['halalan_admin_delete_position_success'] = 'Matagumpay na natanggal ang posisyon.';
$lang['halalan_admin_delete_candidate_already_has_votes'] = 'Hindi maaaring tanggalin ang kandidatong nakatanggap na ng boto.';
$lang['halalan_admin_delete_candidate_success'] = 'Matagumpay na natanggal ang kandidato.';
// edit
$lang['halalan_admin_edit_voter_title'] = 'Magbago ng Botante';
$lang['halalan_admin_edit_party_title'] = 'Magbago ng Partido';
$lang['halalan_admin_edit_position_title'] = 'Magbago ng Posisyon';
$lang['halalan_admin_edit_candidate_title'] = 'Magbago ng Kandidato';
// add
$lang['halalan_admin_add_voter_title'] = 'Magdagdag ng Botante';
$lang['halalan_admin_add_party_title'] = 'Magdagdag ng Partido';
$lang['halalan_admin_add_position_title'] = 'Magdagdag ng Posisyon';
$lang['halalan_admin_add_candidate_title'] = 'Magdagdag ng Kandidato';
// common to do_add_voter and do_edit_voter
$lang['halalan_admin_voter_no_username'] = 'Kinakailangan ang username.';
$lang['halalan_admin_voter_no_email'] = 'Kinakailangan ang email.';
$lang['halalan_admin_voter_exists'] = 'Mayroon nang ganitong botante.';
$lang['halalan_admin_voter_invalid_email'] = 'Hindi katanggap-tanggap ang email.';
$lang['halalan_admin_voter_no_last_name'] = 'Kinakailangang ang apelyido.';
$lang['halalan_admin_voter_no_first_name'] = 'Kinakailangan ang pangalan.';
$lang['halalan_admin_voter_email_success'] = 'Matagumpay na naipadala ang impormasyon para sa login.';
// do_add_voter
$lang['halalan_admin_add_voter_success'] = 'Matagumpay na naidagdag ang botante.';
// do_edit_voter
$lang['halalan_admin_edit_voter_success'] = 'Matagumpay na nabago ang botante.';
// common to do_add_party and do_edit_party
$lang['halalan_admin_party_no_party'] = 'Kinakailangan ang partido.';
$lang['halalan_admin_party_exists'] = 'Mayroon nang ganitong partido.';
// do_add_party
$lang['halalan_admin_add_party_success'] = 'Matagumpay na naidagdag ang partido.';
// do_edit_party
$lang['halalan_admin_edit_party_success'] = 'Matagumpay na nabago ang partido.';
// common to do_add_position and do_edit_position
$lang['halalan_admin_position_no_position'] = 'Kinakailangan ang posisyon.';
$lang['halalan_admin_position_no_maximum'] = 'Kinakailangan ang dami ng maaaring iboto.';
$lang['halalan_admin_position_exists'] = 'Mayroon nang ganitong posisyon.';
$lang['halalan_admin_position_maximum_not_digit'] = 'Ang dami ng maaaring iboto ay dapat isang bilang.';
$lang['halalan_admin_position_no_ordinality'] = 'Kinakailangan ang posisyon sa pagkakasunod-sunod.';
$lang['halalan_admin_position_ordinality_not_digit'] = 'Ang posisyon sa pagkakasunod-sunod ay dapat isang bilang.';
// do_add_position
$lang['halalan_admin_add_position_success'] = 'Matagumpay na nadagdag ang posisyon.';
// do_edit_position
$lang['halalan_admin_edit_position_success'] = 'Matagumpay na nabago ang posisyon.';
// common to do_add_candidate and do_edit_candidate
$lang['halalan_admin_candidate_no_first_name'] = 'Kinakailangan ang pangalan.';
$lang['halalan_admin_candidate_no_last_name'] = 'Kinakailangang ang apelyido.';
$lang['halalan_admin_candidate_no_position'] = 'Kinakailangan ang posisyon.';
$lang['halalan_admin_candidate_exists'] = 'Mayroon nang ganitong kandidato.';
// do_add_candidate
$lang['halalan_admin_add_candidate_success'] = 'Matagumpay na naidagdag ang kandidato.';
// do_edit_candidate
$lang['halalan_admin_edit_candidate_success'] = 'Matagumpay na nabago ang kandidato.';
// import
$lang['halalan_admin_import_title'] = 'Import Voters';
// do_import
$lang['halalan_admin_import_success_singular'] = ' botante ang matagumpay na na-import.';
$lang['halalan_admin_import_success_plural'] = ' botante ang matagumpay na na-import.';
$lang['halalan_admin_import_reminder'] = 'Maaaring gamitin ang Export Voters sa malawakang paggawa ng mga password.';
$lang['halalan_admin_import_reminder_too'] = ' at pin.';
// export
$lang['halalan_admin_export_title'] = 'Export Voters';


// views/admin/home.php
$lang['halalan_admin_home_left_label'] = 'Manage';
$lang['halalan_admin_home_manage_question'] = 'Ano ang gusto mong gawin?';
$lang['halalan_admin_home_manage_candidates'] = 'Manage Candidates';
$lang['halalan_admin_home_manage_parties'] = 'Manage Parties';
$lang['halalan_admin_home_manage_positions'] = 'Manage Positions';
$lang['halalan_admin_home_manage_voters'] = 'Manage Voters';
$lang['halalan_admin_home_left_label_too'] = 'Regeneration Box';
$lang['halalan_admin_home_email'] = 'Email';
$lang['halalan_admin_home_username'] = 'Username';
$lang['halalan_admin_home_pin'] = 'Regenerate PIN too?';
$lang['halalan_admin_home_login'] = 'Reset login time? (for "logged in another session" errors)';
$lang['halalan_admin_home_submit_too'] = 'Regenerate';
$lang['halalan_admin_home_right_label'] = 'Options';
$lang['halalan_admin_home_status'] = 'Status';
$lang['halalan_admin_home_running'] = 'Bukas';
$lang['halalan_admin_home_not_running'] = 'Sarado';
$lang['halalan_admin_home_results'] = 'Resulta';
$lang['halalan_admin_home_publish'] = 'Ipahayag ang resulta?';
$lang['halalan_admin_home_submit'] = 'Save';

// views/admin/voters.php
$lang['halalan_admin_voters_label'] = 'Mga Botante';
$lang['halalan_admin_voters_voted'] = 'Voted';
$lang['halalan_admin_voters_name'] = 'Pangalan';
$lang['halalan_admin_voters_no_voters'] = 'Walang mga botante.';
$lang['halalan_admin_voters_add'] = 'Magdagdag ng Botante';

// views/admin/voter.php
$lang['halalan_admin_add_voter_label'] = 'Magdagdag ng detalye ng botante';
$lang['halalan_admin_edit_voter_label'] = 'Baguhin ang detalye ng botante';
$lang['halalan_admin_voter_email'] = 'Email';
$lang['halalan_admin_voter_username'] = 'Username';
$lang['halalan_admin_voter_first_name'] = 'Pangalan';
$lang['halalan_admin_voter_last_name'] = 'Apelyido';
$lang['halalan_admin_voter_general_positions'] = 'Pangkalahatang Posisyon';
$lang['halalan_admin_voter_no_general_positions'] = 'Walang mga pangkalahatang posisyon.';
$lang['halalan_admin_voter_specific_positions'] = 'Piling Posisyon';
$lang['halalan_admin_voter_no_specific_positions'] = 'Walang mga piling posisyon.';
$lang['halalan_admin_voter_possible_positions'] = 'Maaaring Posisyon';
$lang['halalan_admin_voter_chosen_positions'] = 'Napiling Posisyon';
$lang['halalan_admin_voter_regenerate'] = 'Regenerate';
$lang['halalan_admin_voter_password'] = 'Password';
$lang['halalan_admin_voter_pin'] = 'Pin';
$lang['halalan_admin_add_voter_submit'] = 'Idagdag ang Botante';
$lang['halalan_admin_edit_voter_submit'] = 'Baguhin ang Botante';

// views/admin/parties.php
$lang['halalan_admin_parties_label'] = 'Mga Partido';
$lang['halalan_admin_parties_party'] = 'Partido';
$lang['halalan_admin_parties_alias'] = 'Alias';
$lang['halalan_admin_parties_description'] = 'Description';
$lang['halalan_admin_parties_no_parties'] = 'Walang mga partido.';
$lang['halalan_admin_parties_add'] = 'Magdagdag ng partido';

// views/admin/party.php
$lang['halalan_admin_add_party_label'] = 'Magdagdag ng detalye ng partido';
$lang['halalan_admin_edit_party_label'] = 'Baguhin ang detalye ng partido';
$lang['halalan_admin_party_party'] = 'Partido';
$lang['halalan_admin_party_alias'] = 'Alias';
$lang['halalan_admin_party_description'] = 'Description';
$lang['halalan_admin_party_logo'] = 'Logo';
$lang['halalan_admin_add_party_submit'] = 'Idagdag ang Partido';
$lang['halalan_admin_edit_party_submit'] = 'Baguhin ang Partido';

// views/admin/positions.php
$lang['halalan_admin_positions_label'] = 'Mga Posisyon';
$lang['halalan_admin_positions_position'] = 'Posisyon';
$lang['halalan_admin_positions_description'] = 'Description';
$lang['halalan_admin_positions_no_positions'] = 'Walang mga posisyon.';
$lang['halalan_admin_positions_add'] = 'Magdagdag ng posisyon';

// views/admin/position.php
$lang['halalan_admin_add_position_label'] = 'Magdagdag ng detalye ng posisyon';
$lang['halalan_admin_edit_position_label'] = 'Baguhin ang detalye ng posisyon';
$lang['halalan_admin_position_position'] = 'Posisyon';
$lang['halalan_admin_position_description'] = 'Description';
$lang['halalan_admin_position_maximum'] = 'Dami ng pwedeng iboto';
$lang['halalan_admin_position_ordinality'] = 'Pagkakasunod-sunod';
$lang['halalan_admin_position_abstain'] = 'Abstain';
$lang['halalan_admin_position_unit'] = 'Uri';
$lang['halalan_admin_add_position_submit'] = 'Idagdag ang Posisyon';
$lang['halalan_admin_edit_position_submit'] = 'Baguhin ang Posisyon';

// views/admin/candidates.php
$lang['halalan_admin_candidates_label'] = 'Mga Kandidato';
$lang['halalan_admin_candidates_candidate'] = 'Kandidato';
$lang['halalan_admin_candidates_description'] = 'Description';
$lang['halalan_admin_candidates_no_candidates'] = 'Walang mga kandidato.';
$lang['halalan_admin_candidates_add'] = 'Magdagdag ng Kandidato';

// views/admin/candidate.php
$lang['halalan_admin_add_candidate_label'] = 'Magdagdag ng detalye ng kandidato';
$lang['halalan_admin_edit_candidate_label'] = 'Baguhin ang detalye ng kandidato';
$lang['halalan_admin_candidate_first_name'] = 'Pangalan';
$lang['halalan_admin_candidate_last_name'] = 'Apelyido';
$lang['halalan_admin_candidate_alias'] = 'Alias';
$lang['halalan_admin_candidate_description'] = 'Description';
$lang['halalan_admin_candidate_party'] = 'Partido';
$lang['halalan_admin_candidate_position'] = 'Posisyon';
$lang['halalan_admin_candidate_picture'] = 'Larawan';
$lang['halalan_admin_add_candidate_submit'] = 'Idagdag ang kandidato';
$lang['halalan_admin_edit_candidate_submit'] = 'Baguhin ang kandidato';

// views/admin/import.php
$lang['halalan_admin_import_label'] = 'Import Voters';
$lang['halalan_admin_import_general_positions'] = 'Pangkalahatang Posisyon';
$lang['halalan_admin_import_no_general_positions'] = 'Walang posisyong natagpuan.';
$lang['halalan_admin_import_specific_positions'] = 'Piling Posisyon';
$lang['halalan_admin_import_no_specific_positions'] = 'Walang posisyong natagpuan.';
$lang['halalan_admin_import_possible_positions'] = 'Mga Posibleng Posisyon';
$lang['halalan_admin_import_chosen_positions'] = 'Mga Napiling Posisyon';
$lang['halalan_admin_import_csv'] = 'CSV';
$lang['halalan_admin_import_sample'] = 'Sample Format';
$lang['halalan_admin_import_notes'] = 'Notes';
$lang['halalan_admin_import_submit'] = 'Import';

// views/admin/export.php
$lang['halalan_admin_export_label'] = 'Export Voters';
$lang['halalan_admin_export_password'] = 'Isasama ang password?';
$lang['halalan_admin_export_password_description'] = 'para sa malawakang paggawa ng password';
$lang['halalan_admin_export_pin'] = 'Isasama ang PIN?';
$lang['halalan_admin_export_pin_description'] = 'para sa malawakang paggawa ng pin';
$lang['halalan_admin_export_votes'] = 'Isasama ang mga boto?';
$lang['halalan_admin_export_votes_description'] = 'para sa manual na pagbilang ng boto';
$lang['halalan_admin_export_status'] = 'Isasama ang status?';
$lang['halalan_admin_export_status_description'] = 'para malaman kung sino ang nakaboto na o hindi pa';
$lang['halalan_admin_export_submit'] = 'Export';
?>
