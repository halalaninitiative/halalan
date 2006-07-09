<?php

require_once "HTML/QuickForm.php";
require_once "HTML/QuickForm/Renderer/ArraySmarty.php";

class QuickForm extends HTML_QuickForm {

	function QuickForm () {
		$args = func_get_args();
		call_user_func_array(array(&$this, 'HTML_QuickForm'), $args);
	}

	function render () {
		$smarty =& $GLOBALS['SMARTY'];
		// create renderer and HTML code
		$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);

		// set the required and error templates
		if (defined('QUICKFORM_REQUIREDTPL'))
			$renderer->setRequiredTemplate(file_get_contents(QUICKFORM_REQUIREDTPL));
		if (defined('QUICKFORM_ERRORTPL'))
			$renderer->setErrorTemplate(file_get_contents(QUICKFORM_ERRORTPL));

		$this->accept($renderer);
		return $renderer->toArray();
	}

}

?>