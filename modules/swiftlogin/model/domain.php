<?php

throw new Exception('Not used');

class Emaillogin_Model_Domain extends Emaillogin_ORM
{
	public static $t = 'domain';
	public static $f = 'domain_id';
	public static $h = array(
		'key' => 'Emaillogin_Model_Key',
		'links' => 'Emaillogin_Model_Link',
		'users' => 'Emaillogin_Model_User'
	);
	
	
	/**
	 * Fetch the domain object for the domain name given (or create one if not found).
	 * 
	 * @param string $domain
	 */
	public static function getByDomain($domain)
	{
		$id = self::$db->column('SELECT "id" FROM "domain" WHERE "domain" = ?', array($domain));
		$object = new Emaillogin_Model_Domain($id);
		
		if( ! $object->load())
		{
			$object->domain = $domain;
			$object->save();
		}
		
		return $object;
	}
}