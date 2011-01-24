<?php

throw new Exception('Not used');

class Emaillogin_Model_Key extends Emaillogin_ORM
{
	public static $t = 'key';
	public static $f = 'key_id';
	
	public static $b = array(
		'user' => 'Emaillogin_Model_User',
		'domain' => 'Emaillogin_Model_Domain'
	);
	
	public static $hmt = array(
		'users' => array('Emaillogin_Model_Link' => 'Emaillogin_Model_User')
	);
}