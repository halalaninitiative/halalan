<?php

require_once APP_CORE . "/HypModule.class.php";

/**
 * For now, this class doesn't have difference with the one it extends.
 *
 */
class HypAction extends HypModule {

	var $type = HYP_MOD_ACTION;

	function HypAction ($name) {
		parent::HypModule($name);
	}

}

?>