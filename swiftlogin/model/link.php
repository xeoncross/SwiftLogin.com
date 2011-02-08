<?php

throw new Exception('Not used');

class Emaillogin_Model_Link extends Emaillogin_ORM
{
	public static $t = 'link';
	public static $f = 'link_id';
	public static $b = array(
		'domain' => 'Emaillogin_Model_Domain',
		'user' => 'Emaillogin_Model_User',
		'key' => 'Emaillogin_Model_Key'
	);
	
	function islinked($user_id, $key_id)
	{
		return self::count(array('user_id' => $user_id, 'key_id' => $key_id));
	}
	
}