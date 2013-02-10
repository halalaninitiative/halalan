<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Halalan Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		UP Linux Users' Group
 * @link		http://uplug.org
 */

// ------------------------------------------------------------------------

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
function for_dropdown($array, $key, $value, $blank = TRUE)
{
	$tmp = array();
	foreach ($array as $a)
	{
		$tmp[$a[$key]] = $a[$value];
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

/* End of file halalan_helper.php */
/* Location: ./application/helpers/halalan_helper.php */