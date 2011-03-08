<?php
/**
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Reply_Controller_Delete extends Forum_Controller
{
	public function action($reply_id = NULL, $return_to = NULL)
	{
		$reply = new Forum_Model_Reply(int($reply_id));
		
		if( ! $reply->load())
		{
			return $this->show_404();
		}
		
		// Only admins (or the row creator) can edit
		Swiftlogin_User::check_access(config('admin_role','forum'), $reply->user_id);

		// Remove
		$reply->delete();

		// Send them back to the topic
		redirect(base64_url_decode($return_to));
		exit();
	}

}
