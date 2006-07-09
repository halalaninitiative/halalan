<?php

require_once APP_CORE . "/HypSmarty.class.php";
require_once APP_CORE . "/HypModule.class.php";

/**
 * This class encapsulates the display of HTML and its forms.
 *
 * @requires Smarty
 *
 */
class HypView extends HypModule {

	/** The Smarty Templating Engine class will be stored here */
	var $smarty;

	var $type = HYP_MOD_VIEW;

	function HypView ($name) {
		parent::HypModule($name);
		if (empty($this->params['template'])) {
			$this->params['template'] = TEMPLATES_DEFAULT;
		}
		$this->smarty = new HypSmarty();
	}


	/**
	 * Begins the output of HTML.
	 *
	 * This function do the job of assigning common variables (e.g. the application URL), etc.
	 *
	 * @param string $template The template to be used to display the module. Defaults to the template specified Modules Definition File
	 * @param string $id The id for the certain module. This is generally useful if caching is enabled.
	 *
	 */
	function display ($template = null, $id = null) {

		if (!$template)
			$template = $this->params['template'];

		$this->assign('MODULE_NAME', $this->name);
		$this->assign('PARAMS', $GLOBALS['PARAMS'] + $this->params);

		include(APP_HOOKS . "/pre-display.php");
		if (SMARTY_CACHING) {
			$cacheid = $this->cacheid($id);
			$this->smarty->display($template, $cacheid);
		} else {
			$this->smarty->display($template);
		}
		include(APP_HOOKS . "/post-display.php");
		$this->clearMessages();
		$this->clearErrors();
		$this->clearUserInput();
	}

	/**
	 * An alias of <code>Smarty::assign</code>.
	 *
	 */
	function assign () {
		@$params =& func_get_args();
		call_user_func_array(array(&$this->smarty, 'assign'), $params);
	}

	function is_cached ($template = null, $id = null) {
		if (!$template)
			$template = $this->params['template'];

		$cacheid = $this->cacheid($id);

		return $this->smarty->is_cached($template, $cacheid);
	}

	function clear_cache ($template = null, $id = null) {
		if (!$template)
			$template = $this->params['template'];

		$cacheid = $this->cacheid($id);

		return $this->smarty->clear_cache($template, $cacheid);
	}

	function cacheid ($id = null) {
		global $PARAMS;

		foreach ($PARAMS as $key => $param) {
			if (empty($param)) {
				unset($PARAMS[$key]);
			}
		}

		if (!empty($PARAMS))
			$cacheid = $this->name . "|" . implode("|", $PARAMS);
		else
			$cacheid = $this->name;

		if (isset($id)) {
			$cacheid .= "|$id";
		}

		return strtolower($cacheid);
	}

	/**
	 * An alias of <code>HypSmarty::setHtmlFormDefaults</code>.
	 *
	 */
	function setFormDefaults () {
		@$params =& func_get_args();
		call_user_func_array(array(&$this->smarty, 'setHtmlFormDefaults'), $params);
	}

}

?>