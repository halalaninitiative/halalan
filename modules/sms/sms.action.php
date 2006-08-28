<?php

if(isset($_GET['pid']) && $_SERVER['REMOTE_ADDR'] == SMS_SERVER) {
	$pid=$cel=$msg=$reply='';
	extract($_GET, EXTR_IF_EXISTS);
	$txt = preg_split("/[\s]+/", strtoupper($msg));
	switch ($txt[0]) // params w/o halalan keyword...
	{
		case SMS_REGISTER: // HALALAN REG <voter id> <password> <election pin>
			$reply = $this->register (array_slice($txt, 1));
			break;
		case SMS_VOTE: // HALALAN BOTO <space separated candidate code>
			$reply = $this->vote (array_slice($txt, 1));
			break;
		case SMS_RESULT: // HALALAN RESULTA
			$reply = $this->result ();
			break;
		default:
			$reply = SMS_DEFAULT_MESSAGE;
	}
	$url = "http://".SMS_SERVER."/api.php?pid=$pid&cel=$cel&msg="
         . urlencode($reply);
	// send reply & log...
	$status = (file_get_contents($url)) ? 'sent' : 'failed';
	error_log(date('r')." [$pid] $cel : $msg\n", 3, APP_LOGS . "/incoming.log");
	error_log(date('r')." [$pid] $status - $cel:  $reply\n", 3, APP_LOGS . "/outgoing.log");
}

?>