<?php
/**
 * Verify a callback request
 */
class Verify_Controller_Index extends SwiftLogin_Controller
{
	/*
	 * Respond
	 */
	public function action()
	{
		// Don't even bother
		if(get('key') AND is_string(get('key')) AND mb_strlen(get('key')) === 32)
		{
			$this->load_database();
			
			$user = $this->db->row('SELECT * FROM "user" WHERE login_key = ?', array(get('key')));
			
			if($user)
			{
				//$domain = $this->db->row('SELECT * FROM "domain" WHERE id = ?', array($user->domain_id));
				
				//if($domain)
				//{
					
					//$this->db->update('user', array('login_key' => ''));
					
					$response = array(
						'email' => $user->email,
						'timezone' => $user->timezone,
						'rating' => 0,
						'timestamp' => time(),
						//'domain_first_seen' => $domain->created()
					);
					
					// Don't allow the same key twice
					//$this->db->query('UPDATE user SET login_key = \'\' WHERE user_id = ?', array($user->id));
					//$this->db->update('user', array('login_key' => ''), array('user_id' => $user->id));
					
					die(json_encode($response));
				//}
			}
		}
		
		// Bad request
		header('HTTP/1.1 500 Internal Server Error');
		die(json_encode(array('error' => 'Invalid Request')));
	}

}
