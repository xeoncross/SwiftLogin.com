<?php
/**
 * Category Model
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Forum_Model_Category extends ORM
{
	//public static $has_many = array('forums' => 'Forum_Model_Forum');
	public static $h = array('forums' => 'Forum_Model_Forum');
	
	//public static $table = 'forum_category';
	public static $t = 'forum_category';
	public static $f = 'forum_category_id';
}
