<?php


class SwiftLogin_Controller extends Controller
{
	
	//public $template = 'thin_layout';
	
	/*
	public function __construct()
	{
		// Ignore localhost
		if(server('REMOTE_ADDR') == '127.0.0.1') return;
		
		// Check the Http:BL
		if(bad_bot(server('REMOTE_ADDR'), 'wckxktpyiwin'))
		{
			log_message('Http:BL: ' . server('REMOTE_ADDR'));
			die('Sorry, your internet address has been blocked because someone has used it to send spam.');
		}
	}
	*/
	
	
	protected function load_database()
	{
		static $run = FALSE;
		
		if($run) return;
		
		// Load config settings
		$config = config('database');
		
		// Load database
		$this->db = new DB($config['default']);
		
		// You can also save a copy of the object in the 
		// registry in case something needs it later...
		//registry('db', $this->db);
		
		$run = TRUE;
	}
	
	/**
	 * Get the current ipaddress and convert to int
	 */
	protected function ip_address()
	{
		//return $this->ip2int(ipaddress::get());
		//return $this->ip2int(server('REMOTE_ADDR'));
		return server('REMOTE_ADDR');
	}
	
	// Convert IP4 to int
	protected function ip2int($ip_address)
	{
		return sprintf("%u", ip2long($ip_address));
	}
	
	/**
	 * Log user in a free up session values.
	 * 
	 * @param object$user
	 */
	protected function log_user_in($user)
	{
		$_SESSION['email'] = $user->email;
		$_SESSION['user_id'] = $user->id;
		$_SESSION['role_id'] = $user->role_id;
		
		unset($_SESSION['token']);
	}
	
	
	protected function require_login($uri = NULL)
	{
		if(session('user_id')) return;
		redirect('login?url='. rawurldecode(DOMAIN.'/'.$uri));
		exit();
	}
	
	/**
	 * Build the callback URL
	 */
	protected function build_callback_url($token = NULL)
	{
		if( ! session('callback_url'))
			return '/';
		
		// Allow the callback_url to use query params
		return session('callback_url') . ((strpos(session('callback_url'), '?') === FALSE) ? '?' : '&'). "key=$token";
	}
	
	
	/**
	 * Create the linked relation in database for current user and site
	 */
	protected function link_user_to_site($domain)
	{
		$this->db->insert('linked', array('user_id' => session('user_id'), 'domain_id' => $domain->id, 'created' =>  date("Y-m-d H:i:s")));
	}
	

	/**
	 * Check if the email is from a banned domain
	 * 
	 * @param string $email
	 */
	protected function banned_email_domain($email)
	{
		$this->load_database();
		
		//return Emaillogin_Model_Domain::count(array('domain' => end(explode('@', $email)), 'banned' => 1));
		$domain = explode('@', $email);
		return $this->db->column('SELECT * FROM "domain" WHERE "domain" = ? AND "banned" = true', array($domain[1]));
	}
	

	/*
	protected function email($email, $subject, $message)
	{
		//file_put_contents('emails/email_'.md5($email). '.txt', $subject."\n".$message);
		
		$headers = 'From: donotreply@swiftlogin.com' . "\r\n" .
			//'Reply-To: webmaster@swiftlogin.com' . "\r\n" .
			'X-Mailer: Swiftlogin-Verify 1.0';
		
		mail($email, $subject, $message, $headers);

	}
	*/
	
	// Sends an HTML formatted email
	protected function email($to, $subject, $msg, $from = 'SwiftLogin Activation <donotreply@swiftlogin.com>', $plaintext = '')
	{
		if(!is_array($to)) $to = array($to);
		if(!$plaintext) $plaintext = strip_tags($msg);

		foreach($to as $address)
		{
			if(DOMAIN == 'http://swiftlogin.loc')
			{
				file_put_contents(SP. 'emails/email_'.preg_replace('/\W/','',$address). '.txt', $subject."\n".$msg);
				continue;
			}
			
			$boundary = uniqid(rand(), true);

			$headers  = "From: $from\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: multipart/alternative; boundary = $boundary\n";
			$headers .= "This is a MIME encoded message.\n\n";
			$headers .= "--$boundary\n" .
						"Content-Type: text/plain; charset=ISO-8859-1\n" .
						"Content-Transfer-Encoding: base64\n\n";
			$headers .= chunk_split(base64_encode($plaintext));
			$headers .= "--$boundary\n" .
						"Content-Type: text/html; charset=ISO-8859-1\n" .
						"Content-Transfer-Encoding: base64\n\n";
			$headers .= chunk_split(base64_encode($msg));
			$headers .= "--$boundary--\n" .

			mail($address, $subject, '', $headers);
		}
	}
	
	
	
	/**
	 * Returns the email string  if it is valid - false if it is not
	 *
	 * @see http://en.wikipedia.org/wiki/Email_address
	 * @param string $email
	 * @return string
	 */
	protected function parse_email($email)
	{
		if(is_string($email) AND ($email = trim($email)) AND mb_strlen($email) < 61)
		{
			if(preg_match('/^[A-Za-z0-9._%+\-#|]+@[a-z0-9.-]+\.[a-z]{2,4}$/', $email))
			{
				return $email;
			}
		}
	}
	
	
	/**
	 * Fetch the domain object for the domain name given (or create one if not found).
	 * 
	 * @param string $domain
	 */
	protected function get_domain($domain)
	{
		$row = $this->db->row('SELECT * FROM "domain" WHERE "domain" = ?', array($domain));
		
		if( ! $row)
		{
			$id = $this->db->insert('domain', array('domain' => $domain, 'created' =>  date("Y-m-d H:i:s")));
			
			$row = new stdClass();
			$row->domain = $domain;
			$row->id = $id;
		}
		
		return $row;
	}
	
	
	/**
	 * Hash the given string using SHA256. To make bruteforcing harder 
	 * we will re-hash 100 times.
	 * @param $string
	 * @return string
	 */
	protected function hash_password($string)
	{
		$secret = 'Oi`x+>D-v"dcpbb]\'s2|mKv"L>s?BH9UtAhul=-^=P>z@BMYAR\'mpk9/KfdFC@w)FDhZW9u8?1kll*nhX!:jU&SJj>+aDunwQpSK,6s-S51FrkxM7?!Tt^m%`W+\'=ej\\';
		for($x=0;$x<100;$x++) $string = hash('sha256', $secret.$string); return $string;
	}
	

	/**
	 * Check a passwords strength
	 * 
	 * @param string $password
	 * @return int
	 */
	protected function password_strength($password)
	{
		$strength = 0;
		$patterns = array('/[a-z]/','/[A-Z]/','/\d/','/\W/','/.{12,}/');
		foreach($patterns as $pattern)
		{
			$strength += (int) preg_match($pattern,$password);
		}
		return $strength;
		// 1 - weak
		// 2 - not weak
		// 3 - acceptable
		// 4 - strong
	}
	
	
	/**
	 * Log a failed action for reporting and statistics
	 * 
	 * @param array $row
	 */
	protected function report_failure($action, $row)
	{
		$actions = array(
			'login' => 1,
			'register' => 2,
			'verify_email' => 3,
			'password_reset' => 4,
		);
		
		if(empty($row['domain_id']) AND !empty($row['email']))
		{
			$domain = explode('@',$row['email']);
			$domain = $this->get_domain($domain[1]);
			$row['domain_id'] = $domain->id;
		}
		
		// Log creation date
		$row['created'] = date("Y-m-d H:i:s");
		$row['ip_address'] = $this->ip_address();
		$row['action'] = $actions[$action];
		
		$this->db->insert('failure', $row);
		
	}
	
	/**
	 * Check the recaptcha server
	 * Enter description here ...
	 */
	protected function check_recaptcha()
	{
		if ( ! post('recaptcha_challenge_field') OR ! post('recaptcha_response_field'))
		{
			return 'incorrect-captcha-sol';
		}
	
		// Compile the post fields
		$post = array(
			'privatekey' => config('recaptcha_private_key'),
			'remoteip' => server("REMOTE_ADDR"),
			'challenge' => (string) post('recaptcha_challenge_field'),
			'response' => (string) post('recaptcha_response_field')
		);
		
		$response = curl::post('http://www.google.com/recaptcha/api/verify', $post);
		
		if($result = explode("\n", $response->response, 2))
		{
			return ($result[0] === 'false') ? $result[1] : FALSE;
		}
	}
	
	/**
	 * Link the user to the site, create a login key, and return the callbackurl with that key
	 * 
	 * @param bool $linked weither to create a linked record or not
	 *
	protected function return_to_callback($linked = FALSE)
	{
		$domain = $this->get_domain(session('callback_domain'));
		
		if( ! $linked) $this->link_user_to_site($domain);
		
		$login_key = token();
		$this->db->update('user', array('login_key' => $login_key), array('id' => session('user_id')));
		
		return $this->build_callback_url($login_key);
	}
	*/
	
}