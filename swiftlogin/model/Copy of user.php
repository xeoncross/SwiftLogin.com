<?php
//throw new Exception('Not used');

class Swiftlogin_Model_User extends ORM
{
	public static $t = 'user';
	public static $f = 'user_id';

	public static $b = array(
		'domain' => 'Swiftlogin_Model_User'
	);
	
	public static $h = array(
		'key' => 'Swiftlogin_Model_Key',
		'links' => 'Swiftlogin_Model_Link',
		'topic' => 'Forum_Model_Topic',
		'replies' => 'Forum_Model_Reply'
	);
	
	public static $hmt = array(
		'sites' => array('Swiftlogin_Model_Link' => 'Swiftlogin_Model_Key')
	);
	
	/**
	 * Remove unactivated accounts
	 */
	public static function remove_unactivated_accounts()
	{
		$time = new Time(time() - (60 * 60 * 24));
		self::$db->delete('DELETE FROM "user" WHERE "created" < ? AND "activation_key" != \'\'', array($time->getSQL()));
	}
	
	/**
	 * Fetch a user object by their email
	 * @param string $email
	 */
	public static function getByEmail($email)
	{
		return new Swiftlogin_Model_User(self::$db->column('SELECT id FROM user WHERE email = ?', array($email)));
	}
	
	/**
	 * Fetch a user object by their email
	 * @param string $email
	 */
	public static function getByActivationKey($key)
	{
		return new Swiftlogin_Model_User(self::$db->column('SELECT id FROM user WHERE activation_key = ?', array($key)));
	}
	
	/**
	 * Fetch a user object by their passwordresetkey
	 * @param string $email
	 */
	public static function getByNewPasswordKey($key)
	{
		return new Swiftlogin_Model_User(self::$db->column('SELECT id FROM user WHERE new_password_key = ?', array($key)));
	}
	
	/**
	 * Check a passwords strength
	 * 
	 * @param string $password
	 * @return int
	 */
	public static function password_strength($password)
	{
		$strength = 0;
		$patterns = array('/[a-z]/','/[A-Z]/','/\d/','/\W/');
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
	 * Hash the given string using SHA256. To make bruteforcing harder 
	 * we will re-hash 100 times.
	 * @param $string
	 * @return string
	 */
	public static function hash_password($string)
	{
		$secret = 'Oi`x+>D-v"dcpbb]\'s2|mKv"L>s?BH9UtAhul=-^=P>z@BMYAR\'mpk9/KfdFC@w)FDhZW9u8?1kll*nhX!:jU&SJj>+aDunwQpSK,6s-S51FrkxM7?!Tt^m%`W+\'=ej\\';
		for($x=0;$x<100;$x++) $string = hash('sha256', $secret.$string); return $string;
	}
	
}