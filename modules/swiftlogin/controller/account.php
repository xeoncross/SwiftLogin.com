<?php

class Controller_Account extends SwiftLogin_Controller
{
	public $template = 'thin_layout';

	public function index()
	{
		Session::start(config('session'));
		
		$this->require_login();
		
		if(post('new_password') AND post('token') AND post('token') == session('token'))
		{
			$this->load_database();
			
			$password = trim(post('new_password'));
			
			if(mb_strlen($password) < 8 OR mb_strlen($password) > 100)
			{
				message('error', 'Your password must be at least 8 characters long.');
			}
			else
			{
				if($this->password_strength($password) >= 3)
				{
					$user_salt = $this->db->column('SELECT user_salt FROM user WHERE id = ?', array(session('user_id')));
					$password = $this->hash_password($user_salt.$password);
				
					$this->db->update('user', array('password' => $password), array('id' => session('user_id')));
					
					message('message', 'Password Updated!');
				}
				else
				{
					message('error', 'Your password is not secure enough. Try mixing upper and '
					.' lower case letters, numbers, or special characters such as the dollar sign '
					.'($) or underscore (_). The more complex your password - the harder it will be for someone to guess!');
				}
			}
		}
		
		$_SESSION['token'] = token();
		
		Session::save();
		
		$this->content = new View('account/index', 'swiftlogin');
	}
	
	
	/*
	 * Load a view that shows a welcome message
	 */
	public function forgot_password()
	{
		// Start the user session
		Session::start(config('session'));
		
		if(session('user_id'))
		{
			redirect();
			exit();
		}
		
		$error = FALSE;
		
		$this->load_database();
		
		if($_POST)
		{
	
			if( ! post('email') OR ! ($email = $this->parse_email(post('email'))))
			{
				$error = 'Please enter a valid email.';
			}
			elseif ( ! post('token') OR session('token') !== post('token'))
			{
				$error = 'Sorry, there was an error - please resubmit the form.';
				$error = 'Invalid Token';
			}
			elseif ($captcha_error = $this->check_recaptcha())
			{
				$error = 'The security code you entered didn\'t match the image. Please try again.';
			}
			elseif($this->banned_email_domain($email))
			{
				$error = 'Sorry, that email is from a domain that has been blocked for spamming. Please use another email.';
			}
			else
			{
				
				// Clear password reset requests that are too old (>1 hour)
				$time = new Time(time() - 3600);
				$sql = 'UPDATE "user" SET "new_password_key" = NULL, "new_password_time" = NULL WHERE "new_password_time" < ?';
				$this->db->query($sql, array($time->getSQL()));
			
				$user = $this->db->row('SELECT * FROM user WHERE email = ?', array($email));
		
				// If no user was found then create one!
				if( ! $user)
				{
					$error = 'That email was not found. Please <a href="/login">click here</a> to register.';
				}
				else
				{
					
					if($user->activation_key)
					{
						$error = 'You haven\'t activated this email yet. Please check your email and click the link we sent you.';
					}
					elseif($user->new_password_key)
					{
						$error = 'A password reset email has already been sent to this address. '
						. ' If you don\'t see it please check your spam folder';
					}
					else
					{
						$key = token();
						$time = new Time();
						
						$row = array('new_password_key' => $key, 'new_password_time' => $time->getSQL());
						
						// Update the user row
						$this->db->update('user', $row, array('id' => $user->id));
						
						// Build the URL
						$url = DOMAIN. '/account/forgot_password?key='. $key;
							
						// Load the email message
						$message = new View('forgot_password/email', 'swiftlogin');
						
						$message->set(array('email' => $email, 'ip_address' => server('REMOTE_ADDR'), 'url' => $url));
						
						// Send them an email!
						$this->email($email, 'Password Reset', $message);
						
						// Show the user a message
						$this->content = new View('forgot_password/email_sent', 'swiftlogin');
						$this->content->email = $email;
						return;
					}
				}
			}
		}
		elseif(get('key'))
		{
			$user = $this->db->row('SELECT * FROM user WHERE new_password_key = ?', array(get('key')));
			
			if( ! $user)
			{
				$error = 'Sorry, we could not find a user with that key. Either you already clicked this'
				.' link or you waited to long to click the link in the email. Please try again.';
			}
			else
			{
				// Fix user row.
				$this->db->query('UPDATE user SET new_password_key = NULL, new_password_time = NULL WHERE id = ?', array($user->id));
				
				//$user->new_password_key = NULL;
				//$user->new_password_time = NULL;
				//$user->save();
				
				$this->log_user_in($user);
				
				Session::save();
				
				$this->content = new View('forgot_password/success', 'swiftlogin');
				return;
			}
		}
		
		// If the reset failed then record it!
		if($error)
		{
			$email = isset($email) ? $email : '';
			
			message('error', $error);
			$this->report_failure('password_reset', array('email' => $email));
		}
		
		
		// Create a new token
		$_SESSION['token'] = token();
		Session::save();
		
		$this->content = new View('forgot_password/form', 'swiftlogin');
		$this->content->recaptcha = new View('recaptcha', 'swiftlogin');
		
	}

}
