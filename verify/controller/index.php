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

			if($user AND $user->login_domain)
			{
				//$domain = $this->db->row('SELECT * FROM "domain" WHERE id = ?', array($user->domain_id));

				//if($domain)
				//{

					//$this->db->update('user', array('login_key' => ''));

					$domain = $this->db->row('SELECT * FROM "domain" WHERE "id" = ?', array($user->login_domain));

					if($domain)
					{
						$response = array(
							'email' => $user->email,
							'timezone' => $user->timezone,
							'rating' => 0,
							'domain' => $domain->domain,
							//'timestamp' => $user->modified, //Last time the account was updated should be the "allow" stage
							//'domain_first_seen' => $domain->created()
						);

						// Don't allow the same key twice
						//$this->db->query('UPDATE user SET login_key = \'\' WHERE user_id = ?', array($user->id));
						$this->db->update('user', array('login_key' => '', 'login_domain' => 0), array('id' => $user->id));

						die(json_encode($response));
					}
					else
					{
						// Bad request
						header('HTTP/1.1 500 Internal Server Error');
						die(json_encode(array('error' => 'Invalid Login Domain')));
					}
				//}
			}
		}

		// Bad request
		header('HTTP/1.1 500 Internal Server Error');
		die(json_encode(array('error' => 'Invalid Request')));
	}

}
