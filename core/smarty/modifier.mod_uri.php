<?php

function smarty_modifier_mod_uri ($modulename) {
	return HypModule::uri($modulename);
}

?>