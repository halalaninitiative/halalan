<?php

class HypSelect {

	function csJavaScript ($rootid, $options, $hide_empty = false, $disable_empty = false) {
		$listname = $rootid . "list";
		$defaults = array_pop_assoc($options, '_default');
		if (empty($defaults)) {
			$defaults = array();
		} else if (!is_array($defaults)) {
			$defaults = array($defaults);
		}
		$javascript = "";
		if ($hide_empty)
			$javascript .= "var hide_empty_list = true;\n";
		if ($disable_empty)
			$javascript .= "var disable_empty_list = true;\n";
		$javascript .= "addListGroup('$rootid', '$listname');\n";
		$javascript .= HypSelect::_addOptions($listname, $options, $defaults);


		return $javascript;
	}

	function csInit ($rootid, $ids, $cookie = null, $callback = null, $selected = array()) {
		$init = "";

		if ($selected) {
			foreach ($selected as $_key => $_sel) {
				$selected[$_key] = addslashes($_sel);
			}
			$selected = implode('::', $selected);
			$init .= "selectOptions('$rootid', \"$selected\", 1);";
		}

		foreach ($ids as $id) {
			$init .= "repaintVisibility('$id');"; // fix for IE
		}

		$init .= "initListGroup('$rootid'";
		foreach ($ids as $id) {
			$init .= ", document.getElementById('$id')";
		}
		$init .= $cookie ? ", '$cookie'" : "";
		$init .= $callback ? ", $callback" : "";
		$init .= ");";

		return $init;
	}

	function _addOptions ($parent, $options, $defaults = array()) {
		$javascript = "";
		$key = 0;
		foreach ($options as $value => $contents) {
			if (is_array($contents)) {
				$name = array_pop_assoc($contents, '_name');
				$isdefault = in_array($value, $defaults);
				$sublistname = $parent . "_" . $key;
				$name = addslashes($name);
				$value = addslashes($value);
				$javascript .= "addList('$parent', '$name', '$value', '$sublistname'" . ($isdefault ? ", 1" : "") . ");\n";

				$_default = array_pop_assoc($contents, '_default');
				if (empty($_default)) {
					$_default = array();
				} else if (!is_array($_default)) {
					$_default = array($_default);
				}
				$javascript .= HypSelect::_addOptions($sublistname, $contents, $_default);
			} else {
				$name = $contents;
				$isdefault = in_array($value, $defaults);
				$name = addslashes($name);
				$value = addslashes($value);
				$javascript .= "addOption('$parent', '$name', '$value'" . ($isdefault ? ", 1" : "") . ");\n";
			}
			$key++;
		}
		return $javascript;
	}

	function &setHierSelected (&$options, $selected) {
		$cur = array(&$options);
		foreach ($selected as $_s) {
			$_cur = array();
			$keys = array_keys($cur);
			foreach ($keys as $k) {
				$c =& $cur[$k];
				if (!is_array($c)) {
					continue;
				}
				if (is_array($_s)) {
					$_s = array_intersect($_s, array_keys($c));
					if (empty($_s))	{
						$_s = null;
					}
				} else if (!array_key_exists($_s, $c)) {
					$_s = null;
				}
				if (isset($_s)) {
					$c['_default'] = $_s;
				} else if (isset($c['_default'])) {
					$_s = $c['_default'];
				} else {
					$_keys = array_keys($c);
					$_s = (string)$_keys[0];
					if ($_s == "_name") {
						$_s = $_keys[1];
					}
				}
				if (is_array($_s)) {
					foreach ($_s as $__s) {
						$_cur[] =& $c[$__s];
					}
				} else {
					$_cur[] =& $c[$_s];
				}
			}
			$cur =& $_cur;
			unset($_cur);
		}
		return $options;
	}

	function csDateJavaScript ($rootid, $options, $hide_empty = false, $disable_empty = false) {
		$javascript = "";
		if ($hide_empty)
			$javascript .= "var hide_empty_list = true;\n";
		if ($disable_empty)
			$javascript .= "var disable_empty_list = true;\n";

		extract($options);
		$time = "[" . (int)$time['year'] . "," . (int)$time['month'] . "," . (int)$time['day'] . "]";

		$min_date = "[" . (int)$min_date['year'] . "," . (int)$min_date['month'] . "," . (int)$min_date['day'] . "]";
		$max_date = "[" . (int)$max_date['year'] . "," . (int)$max_date['month'] . "," . (int)$max_date['day'] . "]";

		$days = array();
		$day_secs = 60*60*24;
		for ($i = 1; $i <= 31; $i++) {
			$days[] = "$i:\"" . addslashes(strftime($day_format, ($i-1) * $day_secs)) . '"';
		}
		$days = "{" . implode(',', $days) . "}";

		$months = array();
		$month_secs = $day_secs*30;
		for ($i = 1; $i <= 12; $i++) {
			$months[] = "$i:\"" . addslashes(strftime($month_format, (($i-1) * $month_secs) + 15*$day_secs)) . '"';
		}
		$months = "{" . implode(',', $months) . "}";

		$object = "{$rootid}_csdate";
		$javascript .= "$object = new HypCsDate($months, $days);\n";
		if ($year_prefix)
			$javascript .= "$object.year_prefix = \"" . addslashes($year_prefix) . "\";\n";
		if ($month_prefix)
			$javascript .= "$object.month_prefix = \"" . addslashes($month_prefix) . "\";\n";
		if ($day_prefix)
			$javascript .= "$object.day_prefix = \"" . addslashes($day_prefix) . "\";\n";

		$javascript .= "$object.populate('$rootid', $min_date, $max_date, $time);";

		return $javascript;
	}

}


?>