<?php

class Controller_API extends SwiftLogin_Controller
{
	public $template = 'thin_layout';

	public function index()
	{
		Session::start(config('session'));
		
		//$this->template = 'layout';
		$this->sidebar = new View('sidebar', FALSE);
		$this->content = new View('api/index', 'swiftlogin');
	}
	
	/*
	 * Load a view that shows a welcome message
	 */
	public function keys()
	{
		// Start the user session
		Session::start(config('session'));
		
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
		
		$this->content = new View('api/keys', 'swiftlogin');
		$this->content->keys = $keys;
		
	}

	public function create()
	{
		
		// Start the user session
		Session::start(config('session'));
		
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
		
		
		$this->content = new View('api/create', 'swiftlogin');
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
	
	/*
	// Print the recaptcha HTML widget <http://recaptcha.net>
	protected function recaptcha_html($pubkey, $error = null, $color = 'clean')
	{
		return '<script>var RecaptchaOptions = {theme : \''. $color. '\'};</script>
		<script type="text/javascript" src="http://api.recaptcha.net/challenge?k='
		. $pubkey . ($error ? "&amp;error=$error" : '') . '"></script>
	
		<noscript>
	  		<iframe src="http://api.recaptcha.net/noscript?k=' . $pubkey . ($error ? "&amp;error=$error" : '')
		. '" height="300" width="500" frameborder="0"></iframe><br/>
	  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
	  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
		</noscript>';
	}
	
	
	// Check that the recaptcha answer is correct <http://recaptcha.net>
	protected function recaptcha_check($privkey)
	{
		if ( ! post('recaptcha_challenge_field') OR ! post('recaptcha_response_field'))
		{
			return 'incorrect-captcha-sol';
		}
	
		// Compile the post fields
		$post = array(
			'privatekey' => $privkey,
			'remoteip' => server("REMOTE_ADDR"),
			'challenge' => post('recaptcha_challenge_field'),
			'response' => post('recaptcha_response_field')
		);
		
		$result = curl::post('http://api-verify.recaptcha.net/verify', $post);
	
		if($result->response)
		{
			$result = explode("\n", $result->response);
			return ($result[0] === 'false') ? $result[1] : NULL;
		}
	}
	*/
}
