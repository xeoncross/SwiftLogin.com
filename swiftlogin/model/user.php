<?php
class Swiftlogin_Model_User extends ORM
{
	public static $t = 'user';
	public static $f = 'user_id';

	public static $h = array(
		'topic' => 'Forum_Model_Topic',
		'replies' => 'Forum_Model_Reply'
	);
	
	public function username()
	{
		$email = explode('@', $this->email);
		$name = explode('.', $email[0],3);
		return ucwords(implode(' ', $name));
	}

	public function website()
	{
		$email = explode('@', $this->email);
		return 'http://'. $email[1];
	}
}