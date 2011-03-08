<?php
/**
 * Forum Topic
 *
 * Display forum topics and their replies.
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Topic_Controller_Delete extends Forum_Controller
{
	public function action($topic_id = NULL, $return_to = NULL)
	{
		$topic = new Forum_Model_Topic(int($topic_id));
		
		if( ! $topic->load())
		{
			return $this->show_404();
		}
		
		// Only admins (or the row creator) can delete
		Swiftlogin_User::check_access(config('admin_role','forum'), $topic->user_id);

		// Remove
		$topic->delete();

		// Send them back to the topic
		redirect(base64_url_decode($return_to));
		exit();
	}

}
