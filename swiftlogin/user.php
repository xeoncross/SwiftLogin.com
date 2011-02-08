<?php
/**
 * User
 *
 * Global static user class for accessing data about the current logged in user.
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Swiftlogin_User {
	
	// The user object
	//protected static $user = NULL;
	
	/**
	 * Load the current user's row based on the session('user_id')
	 * @return object|bool
	 *
	public static function load()
	{
		// If the user is NOT logged in the make sure to remove the cookie
		if( ! session('user_id'))
		{
			self::logged_in_cookie(FALSE);
			return;
		}
		
		if(self::$user)return self::$user;
	
		// Make sure the cookie exists
		self::logged_in_cookie(TRUE);
		
		// Try to load this user
		return self::$user = new User_Model_User(session('user_id'));
	}
	*/
	
	/*
	 * In addition to the session cookie we will manage another
	 * cookie that tells us wither or not this user has logged
	 * in. The only purpose of this cookie will be to know wheither
	 * we should show cached pages and other un-important tasks
	 * as it is really easy for the user to set/change this value.
	 *
	 * However, since most people won't change this value we are
	 * free to use it to show pre-rendered pages (caches) and
	 * increase site performance.
	 * 
	 * @param bool $create the cookie or destroy it?
	 *
	public static function logged_in_cookie($create = TRUE)
	{
		return; // Not needed
		
		//Create a logged_in cookie that lasts for about a month
		if($create AND ! isset($_COOKIE['logged_in']))
			return setcookie('logged_in', TRUE, time() + 60*60*24*31, '/', NULL, NULL);

		//If this cookie does not exist
		if( ! isset($_COOKIE['logged_in']))
			return;

		// Delete the cookie from globals
		unset($_COOKIE['logged_in']);

		//Delete the cookie on the user_agent
		setcookie('logged_in', '', time() - 43200, '/', NULL, NULL);
	}
	*/
	
	/**
	 * Check if the user has permission to do what they are seeking (exit if not)
	 * if an ID is given, then matching that ID to the current users will also work.
	 * 
	 * @param string|int $role the name or ID of the role to satisfy
	 * @param int $user_id of the user to allow
	 */
	public static function check_access($role = NULL, $user_id = NULL)
	{
		//Must be logged in
		if ( ! self::is_logged_in())
		{
			self::deny_access('login', url());
		}

		//If this user's ID is not the same
		if( ! $user_id OR self::id() != $user_id)
		{
			//Must be an admin or high enough role
			if ( ! self::is_role($role))
			{
				self::deny_access('deny');
			}
		}
	}


	/**
	 * Deny access to a location or simply require the user logs in first. Optionally,
	 * return a user to back to the page when done login in.
	 *
	 * @param string $uri page name (deny, banned, or login)
	 * @param $return_to
	 * @return void
	 */
	public static function deny_access($uri = 'deny', $return_to = NULL)
	{
		redirect('user/'. $uri. '/'. base64_url_encode($return_to));
		exit();
	}

	
	/**
	 * Return the current user ID
	 * @return int
	 */
	public static function id()
	{
		return session('user_id');
	}

	
	/**
	 * Return the current user role ID
	 * @return int
	 */
	public static function role_id() 
	{
		return session('role_id');
	}

	
	/**
	 * Return the current user name
	 * @return string
	 */
	public static function name()
	{
		if($email = session('email'))
		{
			$email = explode('@', $email);
			//return $email[0];
			$name = explode('.', $email[0],3);
			return ucwords(implode(' ', $name));
		}
	}

	
	/**
	 * Return the current user email
	 * @return string
	 */
	public static function email()
	{
		return session('email');
	}

	
	/**
	 * Return the current user email
	 * @return string
	 */
	public static function website()
	{
		if($email = session('email'))
		{
			$email = explode('@', $email);
			return 'http://'. $email[1];
		}
	}

	
	/**
	 * Return TRUE if the user is logged in
	 * @return bool
	 */
	public static function is_logged_in()
	{
		return (bool) session('user_id');
		//return TRUE;
	}
	
	
	/**
	 * Check to see if the user's role is as low (or lower) than the role given.
	 * 
	 * @param string|int $role the name or ID of the role to satisfy
	 * @param int $user_role_id (optional) role_id of the user (defaults to current user's role_id)
	 * @return boolean
	 */
	public static function is_role($role, $user_role_id = NULL)
	{
		// If no role is given, use current users role!
		$user_role_id = (int) $user_role_id ? $user_role_id : self::role_id();

		//Admins are all roles
		if($user_role_id === 1) { return TRUE; }
		
		// Depending on wheither they gave us an ID or role name...
		$roles = is_int($role) ? config('roles', 'user') : array_flip(config('roles', 'account'));
		
		return $user_role_id <= $roles[$role];
	}
	
	
	/**
	 * Return the name of the given role ID
	 * @param int $id of the role
	 * @return string
	 */
	public static function get_role($id)
	{
		$roles = config('roles', 'user');
		return isset($roles[$id]) ? $roles[$id] : NULL;
	}
	
}