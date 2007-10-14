<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------
/**
 * Session Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		Rick Ellis
 * @link		http://www.codeigniter.com/user_guide/libraries/sessions.html
 */
// ------------------------------------------------------------------------
// Modified as OBSession version 2.0.1 by Oscar Bajner, 26 June 2007.
// ------------------------------------------------------------------------
class CI_Session {

	var $CI;
	var $now;
	var $encryption		     = FALSE;
	var $session_storage	 = 'cookie';
	var $session_table	     = FALSE;
	var $session_length	     = 0; 
	var $session_cookie	     = 'ci_session';
	var $session_data_cookie = 'ci_session_data';
	var $userdata		     = array();
    var $session_data        = array();
	var $gc_probability	     = 10;
    var $session_timeout     = 0; 
    var $session_start       = 0; 
	var $flash_key           = 'flash'; 
    var $session_http_only   = FALSE;
    var $session_secure      = FALSE;
    var $session_db;
    var $session_cookie_sent = FALSE;

// ------------------------------------------------------------------------
	/**
	 * Session Constructor
	 *
	 * The constructor runs the session routines automatically whenever the class is instantiated.
	 * 
	 */		
	function CI_Session()
	{
		$this->CI =& get_instance();
        define('OBSESSION_VERSION', '2.0.1');
		log_message('debug', "Session Class Initialized : OBSession " . OBSESSION_VERSION);
		$this->sess_run();
	}
	// --------------------------------------------------------------------
	/**
	 * Run the session routines
	 *
	 * @access	public
	 * @return	void
	 */		
	function sess_run()
	{
		/*
		 *  Set the "now" time
		 *
		 * It can either set to GMT or time(). The pref is set in the config file.
		 * If the developer is doing any sort of time localization they might want to set the session time to GMT so
		 * they can offset the "last_activity" and "last_visit" times based on each user's locale.
         *
		 */
		if (strtolower($this->CI->config->item('time_reference')) == 'gmt')
		{
			$now = time();
			$this->now = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));
	
			if (strlen($this->now) < 10)
			{
				$this->now = time();
				log_message('error', 'The session class could not set a proper GMT timestamp so the local time() value was used.');
			}
		}
		else
		{
			$this->now = time();
		}
		/*
		 *  Set the session length
		 *
		 * If the session expiration is set to zero in the config file we set the cookie expiration to 0. (FALSE)
		 * That will provide a non-persistent session which ends when the browser closes.
		 * This is effectively done by setting the session length to 12 hours. (ie if the browser session lasts
		 * longer than 12 hours the session will be terminated.
         *
         * NOTE: The key to the session class is the "session_last_activity". As this is updated it effectively
         * advances the actual expiry time of the session. A new "timeout" setting allows the developer to set a
         * fixed duration for the session lifetime.
		 */
		$expiration = $this->CI->config->item('sess_expiration');

		if (! is_numeric($expiration))
		{
            show_error('The session expiration configuration is invalid.');
        }
        $this->session_length = ($expiration > 0) ? $expiration : (60*60*12);
        
		/*
		 *  Set the session timeout
         *
		 * A timeout setting is provided in the config file.
		 * This allows the session to be "timed out" based on a fixed elapse of time. The session may be given a fixed
		 * duration or "time-to-live" after which it will be regenerated (with a new session id) or optionally, destroyed.
		 * 
		 * To prevent any timeout, we use a config setting of 0. Effectively this means two years.
		 */
		$timeout = $this->CI->config->item('sess_timeout');
		
		if (! is_numeric($timeout))
		{
            show_error('The session timeout configuration is invalid.');
        }
        $this->session_timeout = ($timeout > 0) ? $timeout : (60*60*24*365*2);
        
		// Do we need encryption?
		$this->encryption = $this->CI->config->item('sess_encrypt_cookie');
	
		if ($this->encryption === TRUE)	
		{
			$this->CI->load->library('encrypt');
		}
        
        // Set a secure cookie?
        if ($this->CI->config->item('sess_secure') === TRUE )
        {
            $this->session_secure = TRUE;
        }
        // Should we set the Httponly parameter?
        // This option is only for PHP > 5.2, and only some browsers honour it. (IE 6SP1 and 7)
        if ($this->CI->config->item('sess_http_only') === TRUE) 
        {
            $this->session_http_only = TRUE;
        }
        
		// Set the session cookie name
		if ($this->CI->config->item('sess_cookie_name') != FALSE)
		{
			$this->session_cookie = $this->CI->config->item('cookie_prefix').$this->CI->config->item('sess_cookie_name');
		}
        
		// Set the session data cookie name, if we are using cookie storage
		if ($this->CI->config->item('sess_data_cookie_name') != FALSE)
		{
			$this->session_data_cookie = $this->CI->config->item('cookie_prefix').$this->CI->config->item('sess_data_cookie_name');
		}
        
        // Set the session storage medium, config default is cookie
        if ($this->CI->config->item('sess_storage') != FALSE)
        {
            $this->session_storage = $this->CI->config->item('sess_storage');
        }
        
        // If storage is 'database', prepare to use the DB.
		if ($this->session_storage == 'database' AND $this->CI->config->item('sess_table_name') != '')
		{
			$this->session_table = $this->CI->config->item('sess_table_name');
			$this->session_db = $this->CI->load->database($this->CI->config->item('sess_database'), TRUE);
		}      
		/*
		 *  Fetch the current session
		 *
		 * If a session doesn't exist we'll create a new one.  If it does, we'll update it.
		 *
		 */
		if ( ! $this->sess_read())
		{
			$this->sess_create();
		}
		else
		{	
            // The session is only updated periodically, (based on the config setting) to ease system load.
            $interval = $this->CI->config->item('sess_update_interval');
            if (! is_numeric($interval))
            {
                $interval = 300; 
            }
			if (($this->session_data['session_last_activity'] + $interval) < $this->now) 
			{
				$this->sess_update();
			}
		}
		
		// Delete expired sessions if necessary
		if ($this->session_storage == 'database')
		{		
			$this->sess_gc();
		}
		// Delete old flashdata (from last request)
        	$this->_flashdata_sweep();
        
        // Mark all new flashdata as old (data will be deleted before next request)
        	$this->_flashdata_mark();
	}
	// END sess_run()	
	// --------------------------------------------------------------------
	/**
	 * Fetch the current session data if it exists
     * Session data now consists of two parts.
     * "session_data": An array, always written to the cookie. Items are prefixed with "session_". Session control info.
	 * These are: session_id, session_start, session_last_activity, session_ip_address, session_user_agent.
     * "userdata": User data written to the session. Maintains backward compatibility with CI_Session class usage.
     * User data is stored either in the cookie or other storage medium, depending on config setting.
	 * @access	public
	 * @return	void
	 */
	function sess_read()
	{	
		// Fetch the session cookie (only contains this session ID)
		$session_id = $this->CI->input->cookie($this->session_cookie);
		
		if ($session_id === FALSE)
		{
			log_message('debug', 'A session cookie was not found.');
			return FALSE;
		}
        
        // Get the session data from the session data cookie.
        if ($this->session_storage == 'cookie')
        {
            $session_data = $this->CI->input->cookie($this->session_data_cookie);
		    if ($session_data === FALSE)
		    {
			    log_message('debug', 'A session data cookie was not found.');
			    return FALSE;
		    }
		    // Decrypt and unserialize the session data
		    if ($this->encryption === TRUE)
		    {
			    $session_data = $this->CI->encrypt->decode($session_data);
		    }

		    $session_data = @unserialize($this->strip_slashes($session_data));
            
            if (! $this->sess_check_cookie_data($session_data))
            {
                return FALSE;
            }
        }   
		// Get the session data from the Database
		if ($this->session_storage == 'database')
		{
            $session_data = $this->sess_check_db_data($session_id);
            if ($session_data === FALSE )
            {
                log_message('debug', 'A session was not found in the database.');
                return FALSE;
            }
		}
        // Session looks good 
        // Now we process the "session data" array, splitting session control data and user data into seperate entities.
        foreach ($session_data as $key => $val)
        {
            if (substr($key, 0, 8) == 'session_')
            {
                $this->session_data[$key] = $val;
            }
            else
            {
                $this->userdata[$key] = $val;
            }
        }
    
        // Session is valid!        
		unset($session_id);
        unset($session_data);

		return TRUE;
	}
	// --------------------------------------------------------------------
	/**
	 * Check the Database session exists and contains valid data
     *
     *
	 * @access	public
	 * @return	mixed
	 */
	function sess_check_db_data($session_id)
    {
        // Does the session exist?
        $this->session_db->where('session_id', $session_id);
        // Does the IP match?
        if ($this->CI->config->item('sess_match_ip') === TRUE)
        {
            $this->session_db->where('session_ip_address', $this->_ip_address());
        }
        // Does the user agent match?
        if ($this->CI->config->item('sess_match_useragent') === TRUE)
        {
            $this->session_db->where('session_user_agent', substr($this->CI->input->user_agent(), 0, 50));
        }
			
        $query = $this->session_db->get($this->session_table);
        // No session found, so destroy this session, a new one will be started
        if ($query->num_rows() == 0)
        {
            $this->sess_destroy();
            return FALSE;
        }
        // Is this session current?
        $row = $query->row();
        if (($row->session_last_activity + $this->session_length) < $this->now) 
        {
            $this->session_db->where('session_id', $session_id);
            $this->session_db->delete($this->session_table);
            $this->sess_destroy();
            return FALSE;
        }
        // Is the session Timed Out? 
        $sess_destroy = $this->CI->config->item('sess_destroy_on_timeout');
		if (($row->session_start + $this->session_timeout) < $this->now)
		{
            // If the config setting is FALSE, we regenerate the session ID on next update.
            if ($sess_destroy === TRUE)
            {
			    $this->sess_destroy();
			    return FALSE;
            }
        }
        //  We have a valid session, return the session data array. 
        $session_data = @unserialize($row->session_data);
        if ( ! is_array($session_data)) 
        {
            $session_data = array();
        }
        $session_data['session_id'] = $session_id;
        $session_data['session_start'] = $row->session_start;
        $session_data['session_last_activity'] = $row->session_last_activity;
        $session_data['session_ip_address'] = $row->session_ip_address;
        $session_data['session_user_agent'] = $row->session_user_agent;
    
        return $session_data;
    }
	// --------------------------------------------------------------------
	/**
	 * Check the session data cookie exists and contains valid data
     *
     *
	 * @access	public
	 * @return	boolean
	 */
	function sess_check_cookie_data($session_data)
    {
        // Basic reality checks.
		if ( ! is_array($session_data) )
		{
			log_message('error', 'The session data cookie did not contain a valid array. This could be a possible hacking attempt.');
			return FALSE;
		}
		
		if ( ! isset($session_data['session_id']) )
		{
			log_message('error', 'Session id is not set. This could be a possible hacking attempt.');
			return FALSE;
		}

		if ( ! isset($session_data['session_last_activity']) )
		{
			log_message('error', 'The session_last_activity is not set. This could be a possible hacking attempt.');
			return FALSE;
		}
        
		// Is the session current?
		if (($session_data['session_last_activity'] + $this->session_length) < $this->now)
		{
			$this->sess_destroy();
			return FALSE;
		}

		// Does the IP Match?
		if ($this->CI->config->item('sess_match_ip') === TRUE AND $session_data['session_ip_address'] != $this->_ip_address())
		{
			$this->sess_destroy();
			return FALSE;
		}
		
		// Does the User Agent Match?
		if ($this->CI->config->item('sess_match_useragent') === TRUE AND $session_data['session_user_agent'] != substr($this->CI->input->user_agent(), 0, 50))
		{
			$this->sess_destroy();
			return FALSE;
		}

        // Is the session Timed Out? 
        $sess_destroy = $this->CI->config->item('sess_destroy_on_timeout');
		if (($session_data['session_start'] + $this->session_timeout) < $this->now)
		{
            // If the config setting is FALSE, we regenerate the session ID on next update.
            if ($sess_destroy === TRUE)
            {
			    $this->sess_destroy();
			    return FALSE;
            }
		}
        return TRUE;
    }
	// --------------------------------------------------------------------
	/**
	 * Generic session Write function, writes session data to storage.
     *
	 * @access	public
	 * @return	void
	 */
	function sess_write()
	{
        if ($this->session_storage == 'cookie')
        {
            $this->sess_write_cookie_data();
            return;
        }
        if ($this->session_storage == 'database')
        {
            $this->sess_write_db_data();
            return;
        }
    }
	// --------------------------------------------------------------------
	/**
	 * Write the session cookie
     *
     *
	 * @access	public
	 * @return	void
	 */
	function sess_send_session_cookie($force = FALSE)
    {
		if ( !$force && $this->session_cookie_sent ) {return;}
		log_message('debug','Sending session cookie');
        
        $cookie_data = $this->session_data['session_id'];
        
        $cookie_expiry = $this->CI->config->item('sess_expiration');   
        $cookie_expiry = ($cookie_expiry > 0) ? $this->session_length + time() : 0;
        // Check if we must set the session cookie as HttpOnly
        if (! $this->session_http_only)
        { 
            // This for any version of PHP < 5.2.0
		    setcookie($this->session_cookie, $cookie_data, $cookie_expiry, $this->CI->config->item('cookie_path'), $this->CI->config->item('cookie_domain'), $this->session_secure);
        }
        else 
        {
            // This only for PHP >= 5.2
		    setcookie($this->session_cookie, $cookie_data, $cookie_expiry, $this->CI->config->item('cookie_path'), $this->CI->config->item('cookie_domain'), $this->session_secure, $this->session_http_only);        
        }
        
        $this->session_cookie_sent = TRUE;
    }
	// --------------------------------------------------------------------
	/**
	 * Write the session data cookie, if storage is 'cookie'
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_write_cookie_data()
	{
        $cookie_data = array();
        $cookie_data = $this->session_data;
        
        foreach ($this->userdata as $key => $val)
        {
            $cookie_data[$key] = $val;
        }
        
        $cookie_data = serialize($cookie_data);
		
		if ($this->encryption === TRUE)
		{
			$cookie_data = $this->CI->encrypt->encode($cookie_data);            
		}
        
        $cookie_expiry = $this->CI->config->item('sess_expiration');   
        $cookie_expiry = ($cookie_expiry > 0) ? $this->session_length + time() : 0;        

        // Check if we must set the cookie as HttpOnly
        if (! $this->session_http_only)
        { 
            // This for any version of PHP < 5.2.0
		    setcookie($this->session_data_cookie, $cookie_data, $cookie_expiry, $this->CI->config->item('cookie_path'), $this->CI->config->item('cookie_domain'), $this->session_secure);
        }
        else 
        {
            // This only for PHP >= 5.2
		    setcookie($this->session_data_cookie, $cookie_data, $cookie_expiry, $this->CI->config->item('cookie_path'), $this->CI->config->item('cookie_domain'), $this->session_secure, $this->session_http_only);        
        }
		log_message('info','Session data cookie updated.');
    }
	// --------------------------------------------------------------------
	/**
	 * Write the session data to the DataBase
     *
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_write_db_data()
    {
        $db_user_data = $this->userdata;
        $query_array = array('session_start'            => $this->session_data['session_start'],
                            'session_last_activity'     => $this->session_data['session_last_activity'],
                            'session_ip_address'        => $this->session_data['session_ip_address'], 
                            'session_user_agent'        => $this->session_data['session_user_agent']
                            );

        $query_array['session_data'] = serialize($db_user_data);
        $this->session_db->query($this->session_db->update_string($this->session_table, $query_array, array('session_id' => $this->session_data['session_id'])));
	}
	// --------------------------------------------------------------------
	/**
	 * Create a new session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_create()
	{	
		$sessid = '';
		while (strlen($sessid) < 32)
		{
			$sessid .= mt_rand(0, mt_getrandmax());
		}
	
		$this->session_data = array(
							'session_id' 	        => md5(uniqid($sessid, TRUE)),
                            'session_start'         => $this->now, 
							'session_last_activity'	=> $this->now,
							'session_ip_address' 	=> $this->_ip_address(),
							'session_user_agent' 	=> substr($this->CI->input->user_agent(), 0, 50)
							);
                            
        $this->userdata = array();
        
		// Create the session in the DB if session storage is 'database'
		if ($this->session_storage == 'database')
		{
			$this->session_db->query($this->session_db->insert_string($this->session_table, $this->session_data));
            $this->sess_send_session_cookie();
		}
        // Create the session in the session data cookie if session storage is 'cookie'
        if ($this->session_storage == 'cookie')
        {
            $this->sess_send_session_cookie();
            $this->sess_write_cookie_data();
        }

		log_message('debug','New session started.');
	}
	// --------------------------------------------------------------------
	/**
	 * Update an existing session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_update()
	{	
        // Is the session Timed Out? If so we regenerate the session, new id,  keep the old data.
        $sess_destroy = $this->CI->config->item('sess_destroy_on_timeout');
		if (($this->session_data['session_start'] + $this->session_timeout) < $this->now)
		{
            if ($sess_destroy === FALSE)
            {
			    $this->regenerate_id();
			    return;
            }
		}
        // This little piggy drives the whole session.
		$this->session_data['session_last_activity'] = $this->now;
        
		if ($this->session_storage == 'database')   
		{		
			$this->session_db->query($this->session_db->update_string($this->session_table, array('session_last_activity' => $this->now), array('session_id' => $this->session_data['session_id'])));
		}
        
		if ($this->session_storage == 'cookie')   
		{
			$this->sess_write_cookie_data();
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Destroy the current session
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_destroy()
	{
        // If we are using a database, delete the session row now.
        if ($this->session_storage == 'database') 
        {
            if ( isset( $this->session_data['session_id'] ))
            {
                 $this->session_db->where('session_id', $this->session_data['session_id']);
                 $this->session_db->delete($this->session_table);
            }
        }
        if ($this->session_storage == 'cookie') 
        {
		    setcookie($this->session_data_cookie, '', ($this->now - 31500000), $this->CI->config->item('cookie_path'), $this->CI->config->item('cookie_domain'), $this->CI->config->item('sess_secure'));
        }        
        // Finally, delete the session cookie. This effectively destroys the session.
		setcookie($this->session_cookie, '', ($this->now - 31500000), $this->CI->config->item('cookie_path'), $this->CI->config->item('cookie_domain'), $this->CI->config->item('sess_secure'));
	}
	// --------------------------------------------------------------------
	/** 
	 * Generate a new session_id, saving the old userdata and session_data
	 *
	 * @access	public
	 * @return	void
	 */
	function regenerate_id()
	{
		$sessid = '';
		while (strlen($sessid) < 32)
		{
			$sessid .= mt_rand(0, mt_getrandmax());
		}
        
        // Update the session data in the session data array. 
		$this->session_data['session_id'] = md5(uniqid($sessid, TRUE));
        $this->session_data['session_start'] = $this->now;
        $this->session_data['session_last_activity'] = $this->now;
        
        // We MUST resend the session cookie with the NEW session ID.
        $this->sess_send_session_cookie($force = TRUE);

		if ($this->session_storage == 'cookie')
        {
            $this->sess_write_cookie_data();
        }
        // The session_id has changed, so insert a new row into the database.
		if ($this->session_storage == 'database')
		{
            $db_sess_data = array();
            $db_sess_data = $this->session_data;
			$this->session_db->query($this->session_db->insert_string($this->session_table, $db_sess_data));
            // We now have a new db session, make sure the userdata is updated
            $this->sess_write_db_data();
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Garbage collection
	 *
	 * This deletes expired session rows from database if the probability percentage is met
     * The probability percentage is now configurable. 100 always, 0 never, 10 default
	 *
	 * @access	public
	 * @return	void
	 */
	function sess_gc()
	{
        $gc_prob = $this->CI->config->item('sess_gc_probability');
        if ($this->gc_probability != $gc_prob)
        {
            $this->gc_probability = $gc_prob;
        }

		srand(time());
		if ((rand() % 100) < $this->gc_probability)
		{
			$expire = $this->now - $this->session_length;
			$this->session_db->where('session_last_activity <'.$expire);
			$this->session_db->delete($this->session_table);

			log_message('debug', 'Session garbage collection performed.');
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Fetch a specific item from  the session array
     * To implement "read once" type items, use an optional "read_once" parameter.
     * If read_once is TRUE, the session item will be deleted.
     *
	 * If the item is prefixed with "session_" drop it into the session_data array.
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function userdata($item, $read_once = FALSE)
	{
        if (substr($item, 0, 8) == 'session_') // This is a session control item
        {
            return ( ! isset($this->session_data[$item])) ? FALSE : $this->session_data[$item];
        }
        
        if ($read_once === FALSE) // This is an ordinary session variable, just return it.
        {
            return ( ! isset($this->userdata[$item])) ? FALSE : $this->userdata[$item];
        }
        else // This is a read-once variable, delete the session item and return the value
        {
            // Save the value to return, and unset the session variable
            if (isset($this->userdata[$item]))
            {
                $user_item = $this->userdata[$item];
                $this->unset_userdata($item);
                return $user_item;                
            }
            else // The item does not exist, return false and do not unset it.
            {
                return FALSE;
            }
        }
	}
	// --------------------------------------------------------------------
	/**
	 * Read Once Alias for userdata(). 
     * Tail Call : Calls userdata() with the read_once parameter = TRUE
     *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
    function ro_userdata($item)
    {
        return $this->userdata($item, TRUE);
    }
	// --------------------------------------------------------------------
	/**
	 * Fetch all userdata from the session array
     *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	function all_userdata()
	{
        return ( ! isset($this->userdata)) ? FALSE : $this->userdata;
	}
	// --------------------------------------------------------------------
	/**
	 * Add or change data in the "userdata" array
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */		
	function set_userdata($newdata = array(), $newval = '')
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}
	
		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$this->userdata[$key] = $val;
			}
		}
	
		$this->sess_write();
	}
	// --------------------------------------------------------------------
	/**
	 * Delete a session variable from the "userdata" array
	 *
	 * @access	array
	 * @return	void
	 */		
	function unset_userdata($newdata = array())
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => '');
		}
	
		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				unset($this->userdata[$key]);
			}
		}
	
		$this->sess_write();
	}
	// --------------------------------------------------------------------
	/**
	 * Return the Session ID string
     *
	 * This is a convenience function (saves typing).
	 * @access	public
	 * @param	string
	 * @return	string
	 */		
	function id()
	{
        return ( ! isset($this->session_data['session_id'])) ? FALSE : $this->session_data['session_id'];
	}
	// --------------------------------------------------------------------
	/**
	 * Strip slashes
	 *
	 * @access	public
	 * @param	mixed
	 * @return	mixed
	 */
	 function strip_slashes($vals)
	 {
	 	if (is_array($vals))
	 	{	
	 		foreach ($vals as $key=>$val)
	 		{
	 			$vals[$key] = $this->strip_slashes($val);
	 		}
	 	}
	 	else
	 	{
	 		$vals = stripslashes($vals);
	 	}
	 	
	 	return $vals;
	}
    // ------------------------------------------------------------------------
    /**
    * Sets "flash" data which will be available only in next request (then it will
    * be deleted from session). You can use it to implement "Save succeeded" messages.
    * OB - amended to mimic set_userdata(), accepts array or string as parameter
    */
    function set_flashdata($newdata = array(), $newval = '')
    {
        if (is_string($newdata))
        {
            $newdata = array($newdata => $newval);
        }
        
        if (count($newdata) > 0)
        {
            foreach ($newdata as $key => $val)
            {
                $flash_key = $this->flash_key.':new:'.$key;
                $this->set_userdata($flash_key, $val);
            }
        }
    } 
    // ------------------------------------------------------------------------
    /**
    * Keeps existing "flash" data available to next request.
    */
    function keep_flashdata($key)
    {
        $old_flash_key = $this->flash_key.':old:'.$key;
        $value = $this->userdata($old_flash_key);

        $new_flash_key = $this->flash_key.':new:'.$key;
        $this->set_userdata($new_flash_key, $value);
    }
    // ------------------------------------------------------------------------
    /**
    * Returns "flash" data for the given key.
    */
    function flashdata($key)
    {
        $flash_key = $this->flash_key.':old:'.$key;
        return $this->userdata($flash_key);
    }
    // ------------------------------------------------------------------------
    /**
    * PRIVATE: Internal method - marks "flash" session attributes as 'old'
    */
    function _flashdata_mark()
    {
	$userdata = $this->all_userdata();
        foreach ($userdata as $name => $value)
        {
            $parts = explode(':new:', $name);
            if (is_array($parts) && count($parts) == 2)
            {
                $new_name = $this->flash_key.':old:'.$parts[1];
                $this->set_userdata($new_name, $value);
                $this->unset_userdata($name);
            }
        }
    }
    // ------------------------------------------------------------------------
    /**
    * PRIVATE: Internal method - removes "flash" session marked as 'old'
    */
    function _flashdata_sweep()
    {
	$userdata = $this->all_userdata();
        foreach ($userdata as $name => $value)
        {
            $parts = explode(':old:', $name);
            if (is_array($parts) && count($parts) == 2 && $parts[0] == $this->flash_key)
            {
                $this->unset_userdata($name);
            }
        }
    }
    // ------------------------------------------------------------------------
	/**
	 * Return the Session IP address
     *
     * Call CI Input Class, returning the IP address.
	 * If config sess_forwarded_ip is TRUE, and a valid HTTP_X_FORWARDED_FOR address exists, 
     * then return the HTTP_X_FORWARDED address, else use the original address.
	 * @access	private
	 * @param	string
	 * @return	string
	 */		
	function _ip_address()
	{
        $use_forwarded = $this->CI->config->item('sess_forwarded_ip');
        $ip = $this->CI->input->ip_address();
        if (! $use_forwarded)
        {
            return $ip;
        }
        // If CI input class returned '0.0.0.0', we're screwed anyway
        if ($ip == '0.0.0.0')
        {
            return $ip;
        }
        // If a valid HTTP_X_FORWARDED address exists, use it, otherwise use first IP
        // I'm duplicating things, because if CI dev changes the Input class to return
        // the forwarded IP as some have asked, I can rip this out easily.
        $x_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // From CI input class, if multiple IP's exist, get the last one
        if (strstr($x_ip, ','))
		{
			$x = explode(',', $x_ip);
			$x_ip = end($x);
		}
        // Is it valid?
		if ( ! $this->CI->input->valid_ip($x_ip))
		{
			return $ip; // The original address returned by CI input class
		}
				
		return $x_ip; // return valid HTTP_X_FORWARDED_FOR
	}
}
// END Session Class
?>