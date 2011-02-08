<?php
/*
 * Confirm Email
 * User comes back with same browser and session - send to allow to continue
 * User comes back with different browser/old session - show success!
 */

class Account_Controller_Confirm extends SwiftLogin_Controller
{
	/*
	 * Load a view that shows a welcome message
	 */
	function action()
	{
		// Don't even bother
		if( ! get('key') OR ! is_string(get('key')) OR mb_strlen(get('key')) !== 32)
		{
			redirect('');
			exit();
		}
		
		// Start the user session
		Session::start();
		
		if(session('user_id')) // If logged in already
		{
			$this->content = new View('verify/logged_in', 'account');
			return;
		}
		
		$this->load_database();
		
		$user = $this->db->row('SELECT * FROM user WHERE activation_key = ?', array(get('key')));
		
		// Invalid key?
		if( ! $user)
		{
			//$this->db->insert('attempt_verify', array('ip_address' => $this->ip_address(),'created' => date("Y-m-d H:i:s")));
			$this->report_failure('verify', array());
			
			$this->content = new View('verify/not_found', 'account');
			return;
		}
		
		// Log the user in!
		$this->log_user_in($user);
		
		// Remove the activation key
		$this->db->update('user', array('activation_key' => NULL), array('id' => $user->id));
		
		// Continue login process
		if(session('callback_url'))
		{
			$domain = $this->get_domain(session('callback_domain'));
			
			// Link them to this site
			$this->link_user_to_site($domain);
			
			$login_key = token();
			$this->db->update('user', array('login_key' => $login_key), array('id' => session('user_id')));
		
			// Send them on back
			redirect($this->build_callback_url($login_key));
			//print $this->build_callback_url($login_key);
					
			// Now that we are done we can remove session data
			unset($_SESSION['callback_url'], $_SESSION['callback_domain']);
				
			// Save user session
			Session::save();
				
			exit();
		}
		
		Session::save();
		
		// Success
		$this->content = new View('verify/done', 'account');
		
	}

}
