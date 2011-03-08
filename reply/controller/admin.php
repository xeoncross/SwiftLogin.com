<?php
class Reply_Controller_Admin extends SwiftLogin_Admin
{
	//public $template = 'thin_layout';
	public function action()
	{
		$config = config('admin','reply');

		// Run
		$this->admin($config);
	}
	
	/**
	 * Format the results to include links to other helpful pages
	 */
	protected function pre_admin_display($results)
	{	
		foreach($results as &$result)
		{
			$result->created = time::show($result->created);
			$result->modified = time::show($result->modified);
			$result->text = wordwrap(mb_substr(h(strip_tags($result->text)), 0, 100). '...');
			
			// Is the forum still here?
			if(isset($result->forum->id))
			{
				$result->forum_id = '<a href="/forum/update/'.$result->forum->id.'">'.$result->forum->name.'</a>';
			}
			
			// Is the topic still here?
			if(isset($result->topic->id))
			{
				$result->forum_topic_id = '<a href="/topic/view/'.$result->topic->id.'">'.$result->topic->title.'</a>';
			}
			
			// Is the topic still here?
			if(isset($result->user->id))
			{
				$result->user_id = '<a href="/user/update/'.$result->user->id.'">'.$result->user->email.'</a>';
			}
			
			$result->status = $result->status ? 'active' : 'disabled';
		}
	}
}
