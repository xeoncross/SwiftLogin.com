<?php
/**
 * Reply Model
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Forum_Model_Reply extends ORM
{
	/*
	public static $belongs_to = array(
		'topic' => 'Forum_Model_Topic',
		'forum' => 'Forum_Model_Forum',
		'user' => 'Swiftlogin_Model_User'
	);*/

	public static $b = array(
		'topic' => 'Forum_Model_Topic',
		'forum' => 'Forum_Model_Forum',
		'user' => 'Swiftlogin_Model_User'
	);

	//public static $table = 'forum_reply';
	public static $t = 'forum_reply';
	public static $f = 'forum_reply_id';
	
	
	/**
	 * To keep down spam we will make sure user waits $time before
	 * posting new topics. Returns TRUE
	 * 
	 * @return boolean
	 */
	public function user_must_wait($user_id)
	{
		// Max life of old login records
		$date = sql_date(time() - config('time_to_create_reply', 'forum'));
		
		// Return count
		return (bool) $this->where('"date" > ? AND "user_id" = ?')->count(array($date, $user_id));
	}

	/*
	// Set date
	protected function insert(array $data = NULL)
	{
		$data['created'] = sql_date();
		return parent::insert($data);
	}
	
	// Update the last modified date
	protected function update(array $data = NULL)
	{
		$data['modified'] = sql_date();
		return parent::update($data);
	}
	*/
}
