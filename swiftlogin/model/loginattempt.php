<?php

throw new Exception('Not used');

class Emaillogin_Model_LoginAttempt extends Emaillogin_ORM
{
	public static $t = 'attempt_login';
	//public static $f = 'login_id';
	
	public static $b = array(
		'domain' => 'Emaillogin_Model_Domain'
	);
}