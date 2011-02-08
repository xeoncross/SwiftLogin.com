<?php

class API_Controller_keys extends SwiftLogin_Controller
{
	public function action()
	{
		// Start the user session
		Session::start();
		
		$this->require_login();
		
		$this->load_database();
		
		// Changing an API key?
		if(get('key_id') AND get('token') AND get('token') == session('token'))
		{
			$key = hash('sha256', token());
			$sql = 'UPDATE "api_key" SET "key" = ? WHERE "user_id" = ? AND id = ?';
			$this->db->query($sql, array($key, session('user_id'), get('key_id')));
		}
		
		// Select all this users API keys
		$keys = $this->db->fetch('SELECT * FROM api_key WHERE user_id = ? AND status = 1', array(session('user_id')));
		
		foreach($keys as &$key)
		{
			$key->domain = $this->db->row('SELECT * FROM domain WHERE id = ?', array($key->domain_id));
		}
		
		// Create a new token
		$_SESSION['token'] = token();
		
		Session::save();
		
		$this->content = new View('api/keys', 'api');
		$this->content->keys = $keys;
		
	}

}
