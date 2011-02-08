<?php
/**
 * Forum Model
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Forum_Model_Forum extends ORM
{

	//public static $belongs_to = array('category' => 'Forum_Model_Category');
	public static $b = array('category' => 'Forum_Model_Category');

	/*
	public static $has_many = array(
		'topics' => 'Forum_Model_Topic',
		'replies' => 'Forum_Model_Reply',
	);
	*/

	public static $h = array(
		'topics' => 'Forum_Model_Topic',
		'replies' => 'Forum_Model_Reply',
	);
	
	//public static $table = 'forum';
	public static $t = 'forum';
	public static $f = 'forum_id';

}
