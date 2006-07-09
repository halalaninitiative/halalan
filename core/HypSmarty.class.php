<?php

require_once SMARTY_PATH . "/libs/Smarty.class.php";

class HypSmarty extends Smarty {

	function HypSmarty () {
		parent::Smarty();

		$this->caching = SMARTY_CACHING;
		$this->cache_lifetime = SMARTY_CACHE_LIFETIME;
		$this->use_sub_dirs = SMARTY_USE_SUB_DIRS;
		$this->compile_check = SMARTY_COMPILE_CHECK;

		$this->template_dir = TEMPLATES_PATH;
		$this->compile_dir  = TEMPLATES_COMPILED_PATH;
		if (SMARTY_CACHING)
			$this->cache_dir = TEMPLATES_CACHE_PATH;

		$this->debugging = SMARTY_DEBUG;
		$this->error_reporting = SMARTY_ERROR_REPORTING;
		$this->plugins_dir = array_merge($this->plugins_dir, $GLOBALS['SMARTY_PLUGINS_PATH']);

		$this->register_block('dynamic', array('HypSmarty', 'smarty_block_dynamic'), false);

		$this->load_filter('pre', 'hypworks');
		$this->load_filter('post', 'hypworks');

		global $SMARTY;
		$SMARTY = $this;
	}

	function smarty_block_dynamic ($param, $content, &$smarty) {
		return $content;
	}

	function clearCache ($cacheid, $template = null) {
		$this->clear_cache($template, strtolower($cacheid));
	}


	var $_variables = array();
	var $_tempVars = array();

	function saveVariables ($temp_vars = array()) {
		$this->_variables[] = $this->_tpl_vars;
		$this->_tempVars[] = $temp_vars;
		$this->assign($temp_vars);
	}

	function restoreVariables () {
		$_variables = array_pop($this->_variables);
		$_tempVars = array_pop($this->_tempVars);
		$diff = array_diff_assoc($this->_tpl_vars, $_variables, $_tempVars);
		$this->_tpl_vars = $_variables + $diff;
	}


	var $_htmlHead = "";
	var $_scripts = array();
	var $_links = array();

	function addToHtmlHead ($str) {
		$this->_htmlHead .= "$str\n";
	}

	/// TODO: add a generalized addScript() function
	function addJavascript ($src, $attributes = array(), $absolute = null) {
		if (func_get_args() < 3) {
			$absolute = isAbsUri($src);
		}
		if (!$absolute) {
			$src = APP_INCLUDES . '/' . $src;
		}
		if (!isset($attributes['language'])) {
			$attributes['language'] = 'JavaScript';
		}
		$attributes['type'] = 'text/javascript';
		$this->_scripts[$src] = $attributes;
	}

	function addLink ($src, $attributes = array(), $absolute = null) {
		if (func_get_args() < 3) {
			$absolute = isAbsUri($src);
		}
		if (!$absolute) {
			$src = APP_INCLUDES . '/' . $src;
		}
		$this->_links[$src] = $attributes;
	}

	function htmlHead () {
		$htmlHead = "";
		foreach ($this->_links as $src => $link_attrs) {
			$link_attrs['href'] = $src;
			$attributes = htmlAttributes($link_attrs);
			$htmlHead .= "<link $attributes/>\n";
		}
		foreach ($this->_scripts as $src => $script_attrs) {
			$script_attrs['src'] = $src;
			$attributes = htmlAttributes($script_attrs);
			$htmlHead .= "<script $attributes></script>\n";
		}
		$htmlHead .= $this->_htmlHead;
		return $htmlHead;
	}

	function clearHtmlHead () {
		$this->_htmlHead = "";
		$this->_scripts = array();
		$this->_links = array();
	}

	var $_htmlHeadAttributes = array();

	function addHtmlHeadAttributes ($attributes) {
		$this->_htmlHeadAttributes = $attributes + $this->_htmlHeadAttributes;
	}

	function htmlHeadAttributes () {
		return $this->_htmlHeadAttributes;
	}

	function clearHtmlHeadAttributes () {
		$this->_htmlHeadAttributes = array();
	}


	var $_htmlBodyAttributes = array();

	function addHtmlBodyAttribute ($name, $value) {
		if (isset($this->_htmlBodyAttributes[$name]) && startsWith(strtolower($name), 'on')) {
			$this->_htmlBodyAttributes[$name] .= ";\n$value";
		} else {
			$this->_htmlBodyAttributes[$name] = $value;
		}
	}

	function clearHtmlBodyAttribute ($name) {
		if (isset($this->_htmlBodyAttributes[$name])) {
			unset($this->_htmlBodyAttributes[$name]);
			return true;
		} else {
			return false;
		}
	}

	function clearHtmlBodyAttributes () {
		$this->_htmlBodyAttributes = array();
	}

	function htmlBodyAttributes () {
		return $this->_htmlBodyAttributes;
	}

	function htmlBodyAttribute ($name) {
		if (isset($this->_htmlBodyAttributes[$name]))
			return $this->_htmlBodyAttributes[$name];
		else {
			return null;
		}
	}

	var $chainedSelectIds = array(); /// for keeping track of the IDs
	var $chainedSelects = array(); /// for verification if all selects are provided within an chained_selects blocks


	var $_htmlFormAttributes = array();
	function setHtmlFormAttributes ($param1, $param2 = null) {
		if (is_array($param1)) {
			$this->_htmlFormAttributes = $param1 + $this->_htmlFormAttributes;
		} else if (isset($param2)) {
			$this->_htmlFormAttributes[$param1] = $param2;
		} else {
			unset($this->_htmlFormAttributes[$param1]);
		}
		if (!isset($this->_htmlFormAttributes['name'])) { /// TODO: Will we allow empty stringed form name?
			$this->_htmlFormAttributes['name'] = FORM_NAME_DEFAULT;
		}
	}
	function htmlFormAttributes () {
		return $this->_htmlFormAttributes;
	}
	function htmlFormAttribute ($name) {
		if (isset($this->_htmlFormAttributes[$name])) {
			return $this->_htmlFormAttributes[$name];
		} else {
			return null;
		}
	}
	function clearHtmlFormAttributes () {
		$this->_htmlFormAttributes = array();
	}


	var $_htmlFormDefaults = array();
	function setHtmlFormDefaults ($param1, $param2 = FORM_NAME_DEFAULT, $param3 = FORM_NAME_DEFAULT) {
		if (is_array($param1)) {
			$defaults =& $param1;
			$name = $param2;
			if (func_num_args() > 2) {
				trigger_error("HypSmarty::setHtmlFormDefaults: if 1st parameter is an associative array, there's no need for 3rd parameter.", E_USER_WARNING);
			}
		} else if (func_num_args() >= 2) {
			$defaults[$param1] = $param2;
			$name = $param3;
		} else {
			trigger_error('HypSmarty::setHtmlFormDefaults : 1st parameter must be an associative array or a 2nd parameter must be given.', E_USER_ERROR);
			return false;
		}
		$formDefaults =& $this->_htmlFormDefaults[$name];
		$formDefaults = $defaults + (isset($formDefaults) ? $formDefaults : array());
		return true;
	}

	function &htmlFormDefaults ($formname = null) {
		if (!isset($formname)) {
			$formname = $this->htmlFormAttribute('name');
		}
		if (isset($this->_htmlFormDefaults[$formname])) {
			return $this->_htmlFormDefaults[$formname];
		} else {
			$array = array();
			return $array;
		}
	}

	function htmlFormDefault ($name, $formname = null) {
		$defaults =& $this->htmlFormDefaults($formname);
		$keys = array();
		parse_str("$name=0", $keys);
		$cur =& $defaults;
		while ($keys) {
			$_keys = array_keys($keys);
			$key = $_keys[0];
			if ($key) {
				if (array_key_exists($key, $cur)) {
					$cur =& $cur[$key];
					$keys = $keys[$key];
				} else {
					return null;
				}
			} else {
				break;
			}
		}
		if (endsWith($name, "[0]")) {
			$cur =& $cur[0];
		}
		return $cur;
	}

	var $_selectedOptions = array();

	function setSelectedOptions ($value) {
		if (is_array($value))
			$this->_selectedOptions = $value;
		else
			$this->_selectedOptions = array($value);
	}

	function clearSelectedOptions () {
		$this->_selectedOptions = array();
	}

	function selectedOptions () {
		return $this->_selectedOptions;
	}

}


?>