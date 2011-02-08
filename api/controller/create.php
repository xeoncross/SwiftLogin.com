<?php

class Api_Controller_Create extends SwiftLogin_Controller
{
	public function action()
	{
		// Start the user session
		Session::start();
		
		$this->require_login();
		
		if(post('domain') AND post('api_token') AND session('api_token') == post('api_token'))
		{
			if($domain = $this->valid_domain(post('domain')))
			{
				// http://example.com/swift_login_#########.html
				$url = post('domain').'/swiftlogin'.session('api_token').'.html';
				
				if($this->verify_url($url))
				{
					$this->load_database();
					$domain = $this->get_domain($domain);
					
					// If they don't already have a key for this domain
					if( ! $this->db->column('SELECT COUNT(*) FROM api_key WHERE domain_id = ?', array($domain->id)))
					{
						$key = hash('sha256', token());
						
						$row = array('domain_id' => $domain->id, 'user_id' => session('user_id'), 'key' => $key, 'status' => 1);
						$this->db->insert('api_key', $row);
						
						unset($_SESSION['token'], $_SESSION['api_token']);
						redirect('api');
						Session::save();
						exit();
					}
					message('error', 'You already have an API key for this domain');
					
				}
				else
				{
					message('error', 'Unable to find the verification page. Please make sure it exists at the correct URL.');
				}
			}
			else
			{
				message('error', 'Invalid domain given');
			}
			
		}
		
		if( ! session('api_token'))
		{
			// Create a new token
			$_SESSION['api_token'] = substr(sha1(mt_rand().microtime()),4,12);
		}
		
		Session::save();
		
		
		$this->content = new View('api/create', 'api');
	}
	
	protected function verify_url($url)
	{
		$c = curl_init($url); 
		curl_setopt($c, CURLOPT_TIMEOUT, 2);
		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($c, CURLOPT_HEADER, 1); // get the header 
		curl_setopt($c, CURLOPT_NOBODY, 1); // and *only* get the header 
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		
		if (!curl_exec($c)) { curl_close($c); return FALSE; }
		
		$httpcode = curl_getinfo($c, CURLINFO_HTTP_CODE);
        //print dump(curl_getinfo($c));
        curl_close($c);
        
		return ($httpcode == 200);
		//return ($httpcode>=200 && $httpcode<300);
	}
	
	protected function valid_domain($domain)
	{
		if( ! is_string($domain) OR mb_strlen($domain) > 80) return;
		$regex = '/^https?:\/\/(www\.)?(([a-z0-9\-]{2,60}\.)+(loc|com|net|org|edu|name|jp|uk|de|it|br|fr|es|ca|au|us|eu))$/';
		preg_match($regex, $domain, $matches);
		if( ! empty($matches[2]) AND mb_strlen($matches[2]) <= 60) return $matches[2];
	}
	
}
