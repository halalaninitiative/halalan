<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Return line from language file
 *
 * @access	public
 * @param	string
 * @return	string
 */	
function e($line)
{
	$CI =& get_instance();
	return $CI->lang->line('halalan_' . $line);
}

/**
 * Return formatted validation errors or custom messages
 *
 * @access	public
 * @param	string
 * @param	array
 * @return	string
 */
function display_messages($validation, $custom)
{
	$return = '';
	// negatives take precedent
	// but we are sure that only one of the params has values
	if (!empty($validation))
	{
		$return .= '<div class="negative"><ul>';
		$return .= $validation;
		$return .= '</ul></div>';
	}
	else if (!empty($custom))
	{
		if ($custom[0] == 'positive')
		{
			$return .= '<div class="positive"><ul>';
		}
		else
		{
			$return .= '<div class="negative"><ul>';
		}
		unset($custom[0]);
		$return .= '<li>' . implode('</li><li>', $custom) . '</li>';
		$return .= '</ul></div>';
	}
	return $return;
}

/**
 * Return array ready to be used for dropdown
 *
 * @access	public
 * @param	array
 * @param	string
 * @param	string
 * @param	boolean
 * @return	array
 */
function for_dropdown($array, $key, $value, $blank = TRUE, $filter)
{
	$tmp = array();
	foreach ($array as $a)
	{
		if ( ! in_array($a[$key], $filter))
		{
			$tmp[$a[$key]] = $a[$value];
		}
	}
	if ($blank)
	{
		$tmp = array('' => 'Choose ' . ucwords($value)) + $tmp;
	}
	return $tmp;
}

/**
 * Return formatted candidate name
 *
 * @access	public
 * @param	array
 * @return	string
 */
function candidate_name($candidate)
{
	$name = $candidate['first_name'];
	if ( ! empty($candidate['alias']))
	{
		$name .= ' &quot;' . $candidate['alias'] . '&quot;';
	}
	$name .= ' ' . $candidate['last_name'];
	return $name;
}

/**
 * Return formatted validation errors or custom messages
 *
 * @access	public
 * @param	string
 * @param	array
 * @return	string
 */
function alert($errors, $messages = array())
{
	$return = '';
	if ( ! empty($errors))
	{
		$return .= '<div class="alert alert-danger">';
		$return .= '<strong>Oh snap!</strong> Change a few things up and try submitting again.';
		//$return .= $errors; // Show form errors individually instead.
		$return .= '</div>';
	}
	else if ( ! empty($messages))
	{
		$type = array_shift($messages);
		$return .= '<div class="alert alert-' . $type . '">';
		$return .= implode('<br />', $messages);
		$return .= '</div>';
	}
	return $return;
}

/**
 * Return combined form elements and HTML
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
function form_group($field_column, $field, $label = '', $error = '')
{
	$return = '';
	$has_error = '';
	$column_offset = '';

	if ( ! empty($error))
	{
		$has_error = ' has-error';
	}
	$return .= '<div class="form-group' . $has_error . '">';

	if ( ! empty($label))
	{
		$return .= $label;
	}
	else
	{
		$column = 12 - $field_column;
		$column_offset = 'col-sm-offset-' . $column . ' ';
	}
	$return .= '<div class="' . $column_offset . 'col-sm-' . $field_column . '">';

	$return .= $field;

	if ( ! empty($error))
	{
		$return .= $error;
	}

	$return .= '</div></div>';
	return $return;
}

/* End of file halalan_helper.php */
/* Location: ./application/helpers/halalan_helper.php */