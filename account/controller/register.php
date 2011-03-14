<?php
/*
 * ?callback_id=13&callback_url=http://full.domain.tld/user/login?from=site
 */
class Account_Controller_Register extends SwiftLogin_Controller
{
	/*
	 * Load a view that shows a welcome message
	 */
	function action()
	{
	
		/*
		A new user will be shown a recaptcha and sent here to validate or try the recaptcha again.
		Then we will send an activation email if they pass!
		*/
		
		//throw new Exception('working...');
		
		
		
		// Start the user session
		Session::start();
		
		// If the user is already logged in we don't need to do anything!
		if(session('user_id'))
		{
			redirect('allow');
			Session::save();
			exit();
		}
		
		// How did they get here then?
		if( ! session('registration_email') OR ! session('registration_password'))
		{
			redirect('login?url=https://swiftlogin.com');
			exit();
		}
		
		
		$error = '';
		
		// If the form was submitted
		if($_POST)
		{
			$this->load_database();
			
			if ($captcha_error = $this->check_recaptcha())
			{
				$error = 'Sorry, the two words you entered did not match what was in the box.';
			}
			elseif ( ! post('token') OR session('token') !== post('token'))
			{
				$error = 'Sorry, there was an error, please resubmit the form.';
			}
			else
			{
				/* 
				 * @todo Note, is is posible for a hacker to do a reply attack by disregarding our 
				 * cookie change and sending another request with a (new) valid recaptcha
				 * However, our database will just reject the row (same email) causing an exception and exit().
				 * If anyone is that high-tech they deserve to make our error log so we can keep an eye on them.
				 */
				
				// First we need to remove bad accounts (users have one day to verify their account!)
				$time = date("Y-m-d H:i:s", time() - (60 * 60 * 24));
				$this->db->delete('DELETE FROM "user" WHERE "created" < ? AND "activation_key" != \'\'', array($time));
				
				// Create a new user
				$email = session('registration_email');
				$password = session('registration_password');
				$user_salt = token();
				$activation_key = token();
				$domain = explode('@',$email);
				$domain = $this->get_domain($domain[1]);
				
				// JavaScript Timezone detection
				$timezone = int(post('timezone'),-12,12) * -1;
				
				$user = array(
					'email' => $email,
					'domain_id' => $domain->id,
					'role_id' => config('default_role', 'account'),
					'timezone' => $timezone,
					'password' => $this->hash_password($user_salt. $password),
					'user_salt' => $user_salt,
					'activation_key' => $activation_key,
					'created' => date("Y-m-d H:i:s")
				);
				
				$this->db->insert('user', $user);
				
				// Build the URL
				$url = DOMAIN. '/account/confirm?key='. $activation_key;
				
				// Load the email message
				$message = new View('register/email', 'account');
				$message->set(array('email' => $email, 'ip_address' => server('REMOTE_ADDR'), 'url' => $url));
				
				// Send them an email!
				//send_email($email, $message);
				$subject = 'Registration Verification - SwiftLogin';
				$this->email($email, $subject, $message);
				
				// Remove now
				unset($_SESSION['registration_email'], $_SESSION['registration_password']);
				Session::save();
				
				// Show the user a message
				$this->content = new View('register/email_sent', 'account');
				$this->content->email = $email;
				return;
			}
		
			// If the recaptcha failed - then record it!
			if($error)
			{
				message('error', $error);
				$this->report_failure('register', array('email' => session('registration_email')));
			}
		}
		
		
		$_SESSION['token'] = token();
		
		$this->content = new View('register/form', 'account');
		$this->content->recaptcha = new View('recaptcha');
		
		Session::save();
		
	}
	
}
