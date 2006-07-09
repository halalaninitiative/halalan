<?php

require_once APP_CORE . "/classes/HypParser.class.php";

/**
 * NOTE: the order is sometimes important
 * e.g. in select elements, there are general and specific
 * specifics must come first before the generals
 * there can also be elements with the same properties except that one is a function, and another one is a block
 * blocks must come first before the functions
 * Make sure that in a key value pair, no double quote, single quote, or whitespace must exist in the value part.
 *
 */
$GLOBALS['SMARTY_TRANSLATIONS'] = array
(
	array('html', 'block', 'html'),
	array('head', 'block', 'head'),
	array('body', 'block', 'body'),
	array('form', 'block', 'form'),
	array('select', 'block', 'select'),
	array('option', 'block', 'option'),
	array('textarea', 'block', 'textarea'),
	array('text', 'function', 'input', 'type' => 'text'),
	array('checkbox', 'function', 'input', 'type' => 'checkbox'),
	array('file', 'function', 'input', 'type' => 'file'),
	array('hidden', 'function', 'input', 'type' => 'hidden'),
	array('img', 'function', 'img'),
	array('password', 'function', 'input', 'type' => 'password'),
	array('radio', 'function', 'input', 'type' => 'radio'),
	array('reset', 'function', 'input', 'type' => 'reset'),
	array('submit', 'function', 'input', 'type' => 'submit'),
	array('text', 'function', 'input'), // if no type is specified in an input tag, it is implied as text
);

function smarty_prefilter_hypworks ($source, &$smarty) {
	$parser = new HypParser();

	/* save the literal blocks */
	$literal_pattern = '@\{literal[^}]*\}.*\{/literal\}@isU';
	$source = $parser->savePattern($source, $literal_pattern);

	$patterns = array('@\{errors(.*)\}(.*)\{errorelse(.*)\}(.*)\{/errors.*\}@isU', '@\{messages(.*)\}(.*)\{messageelse(.*)\}(.*)\{/messages.*\}@isU');
	$replaces = array('{errors$1}$2{/errors}{errorless$3}$4{/errorless}', '{messages$1}$2{/messages}{messageless$3}$4{/messageless}');
	$source = preg_replace($patterns, $replaces, $source);

	/// NOTE: {errors}/{messages} element can exist within <script> elements, that's why escaping is of <script>s are done after

	/* save the <script> blocks */
	$script_pattern = "@<script[^>]+>.*?</script>@is";
	$source = $parser->savePattern($source, $script_pattern);

	/* Smarty Translations */
	global $SMARTY_TRANSLATIONS;
	$keyvalue_pattern = '[\s]+[\w:]+[\s]*=[\s]*(?:"[^"]*"|\'[^\']*\'|[^>\s]*)';

 	$patterns = array();
 	$replaces = array();
	foreach ($SMARTY_TRANSLATIONS as $properties) {
		$element = array_shift($properties);
		$type = array_shift($properties);
		$name = array_shift($properties);

		// the rest are attributes
		$num_attrs = count($properties);
		$attributes = "";
		foreach ($properties as $key => $value) {
			/// NOTE: $key and [\\s] are separated intentionally
			$attributes .= "[\\s]+$key" . "[\\s]*=[\\s]*(?:\"$value\"|'$value'|$value)?((?:$keyvalue_pattern)*)";
		}
		if ($type == 'block') {
			$pattern = "<$name((?:$keyvalue_pattern)*)$attributes" . "[\\s]*>(.*)</$name>";
			$replace_str = "{" . "$element\$1";
			for ($i = 2; $i < $num_attrs+2; $i++) {
				$replace_str .= "\$$i";
			}
			$replace_str .= "}\$$i{/$name}";
		} else if ($type == 'function') {
			$pattern = "<$name((?:$keyvalue_pattern)*)$attributes" . "[\\s]*/?>";
			$replace_str = "{" . "$element\$1";
			for ($i = 2; $i < $num_attrs+2; $i++) {
				$replace_str .= "\$$i";
			}
			$replace_str .= "}";
		}
		$patterns[] = "@$pattern@isU";
		$replaces[] = $replace_str;
	}
	$source = preg_replace($patterns, $replaces, $source);

	/* restore the <script> blocks */
	$source = $parser->restorePattern($source, $script_pattern);

	/* recover the literal blocks */
	$source = $parser->restorePattern($source, $literal_pattern);

	return $source;
}

?>