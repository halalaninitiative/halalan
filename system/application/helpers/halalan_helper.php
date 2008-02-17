<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
 * Return formatted messages
 *
 * @access	public
 * @param	string
 * @param	string
 * @return	string
 */
function format_messages($messages, $type)
{
	if (empty($messages))
	{
		$return = '';
	}
	else
	{
		$return = '<div class="' . $type . '">';
		$return .= '<ul>';
		foreach ($messages as $message)
		{
			$return .= '<li>' . $message . '</li>';
		}
		$return .= '</ul>';
		$return .= '</div>';
	}
	return $return;
}

?>