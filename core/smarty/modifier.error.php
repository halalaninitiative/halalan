<?php


/**
 * Returns the error specified by the $errorid
 *
 */

function smarty_modifier_error ($errorid) {
	return HypModule::error($errorid);
}



?>