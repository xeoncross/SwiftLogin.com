<?php

class Account_Controller_Index extends SwiftLogin_Controller
{
	public function action()
	{
		Session::start();
		
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
					$user_salt = $this->db->column('SELECT user_salt FROM "user" WHERE id = ?', array(session('user_id')));
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
		
		$this->content = new View('index', 'account');
	}
}
