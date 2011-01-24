<?php


class Controller_Allow extends Swiftlogin_Controller
{
	public $template = 'thin_layout';

	/*
	 * Load a view that shows a welcome message
	 */
	function index()
	{
		// Start the user session
		Session::start(config('session'));
		
		if( ! session('user_id') OR ! session('callback_url') OR ! session('callback_domain')) // If not logged in (should never be here then!)
		{
			//redirect('/');
			
			print dump('Nothing to confirm', $_SESSION);
			exit();
		}
		
		$this->load_database();
		
		$domain = $this->get_domain(session('callback_domain'));
		
		// New callback site they haven't confirmed yet
		if($this->is_new_callback($domain))
		{
			if(post('no'))	// Denied - just send them back to the site
			{
				$url = session('callback_url');
			}
			elseif( ! post('yes'))	// First time - load the form
			{
				// They must confirm this site
				$this->content = new View('allow/form', 'swiftlogin');
				$this->content->domain = $domain->domain;
				return;
			}
			elseif(post('yes'))
			{
				// Link them to this site
				$this->link_user_to_site($domain);
			}
		}
		
		if(empty($url))// Already confirmed this site - or answered "yes"!
		{
			// Create a login key
			$login_key = token();
			$this->db->update('user', array('login_key' => $login_key), array('id' => session('user_id')));
			
			$url = $this->build_callback_url($login_key);
		}
		
		// Send them on their way!
		redirect($url);
				
		// Now that we are done we can remove session data
		unset($_SESSION['callback_url'], $_SESSION['callback_domain']);
			
		// Save user session
		Session::save();
			
		exit();
		
	}

	/**
	 * Check to see if this is a new callback
	 * Enter description here ...
	 */
	protected function is_new_callback($domain)
	{
		$sql = 'SELECT COUNT(*) FROM "linked" WHERE "user_id" = ? AND "domain_id" = ?';
		return ! $this->db->column($sql, array(session('user_id'), $domain->id));
	}
	
}
