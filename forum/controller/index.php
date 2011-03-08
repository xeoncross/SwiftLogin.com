<?php
/**
 * Forum
 *
 * Display forums
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Forum_Controller_Index extends Forum_Controller
{

	function action()
	{
		// Load the view
		$this->content = new View('index', 'forum');
		
		// Get all the forum categories
		$this->content->forums = Forum_Model_Forum::fetch();
		
		// If we should fetch the latest topics
		if($number = config('lastest_topics', 'forum'))
		{
			// Load view
			$this->sidebar = new View('latest_topics', 'forum');
			
			// Get recent topics
			$this->sidebar->topics = Forum_Model_Topic::fetch(array('status' => 1), $number);
		}
		
	}

}
