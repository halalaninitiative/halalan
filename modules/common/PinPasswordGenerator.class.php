<?php

class PinPasswordGenerator {

	function generator($length) {
		$chars = ELECTION_PIN_PASSWORD_CHARS;
		$i = 0;
		$random = '' ;
		while ($i < $length) {
			$num = mt_rand() % strlen($chars);
			$random = $random . substr($chars, $num, 1);
			$i++;
		}
		return $random;
	}

	function generatePin() {
		return PinPasswordGenerator::generator(ELECTION_PIN_LENGTH);
	}

	function generatePassword() {
		return PinPasswordGenerator::generator(ELECTION_PASSWORD_LENGTH);
	}

}

?>