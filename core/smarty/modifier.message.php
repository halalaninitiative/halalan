<?php


/**
 * Returns the message specified by the $messageid
 *
 */

function smarty_modifier_message ($messageid) {
	return HypModule::message($messageid);
}



?>