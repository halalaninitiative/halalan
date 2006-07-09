<?php

class HypParser {

	var $placeholders = array();
	var $matches = array();
	var $counter = 0;

	function HypParser () {
	}

	function savePattern ($string, $pattern) {
		$this->counter++; // to make sure no one will have the same placeholder
		$matches =& $this->matches[$pattern];
		$placeholder =& $this->placeholders[$pattern];
		$placeholder = "@@@SMARTY:HYPWORKS:{$this->counter}:" . mt_rand() . "@@@";;
		preg_match_all($pattern, $string, $matches);
		$matches = $matches[0];
		return preg_replace($pattern, $placeholder, $string);
	}

	function restorePattern ($string, $pattern) {
		$matches =& $this->matches[$pattern];
		$placeholder =& $this->placeholders[$pattern];
		$len = strlen($placeholder);
		$pos = 0;
		for ($i = 0, $count = count($matches); $i < $count; $i++) {
			if (($pos = strpos($string, $placeholder, $pos)) !== false) {
				$string = substr_replace($string, $matches[$i], $pos, $len);
			} else {
				break;
			}
		}
		return $string;
	}

}


?>