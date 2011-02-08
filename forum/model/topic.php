<?php
/**
 * Topic Model
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Forum_Model_Topic extends ORM {

	/*
	public static $belongs_to = array(
		'forum' => 'Forum_Model_Forum',
		'user' => 'Swiftlogin_Model_User'
	);
	*/
	
	public static $b = array(
		'forum' => 'Forum_Model_Forum',
		'user' => 'Swiftlogin_Model_User'
	);

	//public static $has_many = array('replies' => 'Forum_Model_Reply');
	public static $h = array('replies' => 'Forum_Model_Reply');

	//public static $table = 'forum_topic';
	public static $t = 'forum_topic';
	public static $f = 'forum_topic_id';
	
	public static $o = array('last_activity' => 'desc');
	
	/*
	// Set dates
	protected function insert(array $data = NULL)
	{
		$data['created'] = sql_date();
		$data['last_activity'] = sql_date();
		return parent::insert($data);
	}


	// Update the last modified date
	protected function update(array $data = NULL)
	{
		$data['modified'] = sql_date();
		$data['last_activity'] = sql_date();
		return parent::update($data);
	}
	*/
	
	/**
	 * To keep down spam we will make sure user waits $time before
	 * posting new topics. Returns TRUE
	 * 
	 * @return boolean
	 *
	public static function user_must_wait($user_id)
	{
		// Max life of old login records
		$date = sql_date(time() - config('time_to_create_topic', 'forum'));
		
		return (bool) self::count(array("date > '$date'", 'user_id' => $user_id));
		
		// Return count
		//return (bool) $this->where('"date" > ? AND "user_id" = ?')->count(array($date, $user_id));
	}
	*/
	
}
