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
class Topic_Controller_View extends Forum_Controller
{
	function action($topic_id = NULL, $slug = '', $page = 1)
	{
		// Clean user variables
		$page = int($page, 1);
		$topic_id = int($topic_id);

		// Load this forum
		$topic = new Forum_Model_Topic($topic_id);
		$topic->load();

		// If this topic was not found
		if($page < 1 OR ! $topic->load())
		{
			return $this->show_404();
		}

		// Get the topic slug
		$title_slug = String::sanitize_url($topic->title);
		
		// Make sure they are the same
		if($title_slug != $slug)
		{
			redirect('topic/view/'. $topic->id. '/'. $title_slug, 301);
			exit();
		}
		
		// Get offset
		$per_page = config('topic_pagination', 'forum');
		$offset = ($page * $per_page) - $per_page;

		// Load the view
		$this->content= new View('view', 'topic');
		$this->content->topic = $topic;
		
		// Fetch the forum
		$forum = $topic->forum;

		// Fetch the replies
		$this->content->replies = $topic->replies(array('status' => 1), $per_page, $offset);

		// Count the total number
		$total = $topic->count_replies(array('status' => 1));
		
		// Pagination URL
		$url = site_url('topic/view/'. $topic_id. '/[[page]]');
		
		// Render Pagination
		$this->pagination = new Pagination($total, $url, $page, $per_page);
		
		// Breadcrumbs
		$this->breadcrumbs = array(
			'Forum Index' => site_url('forum'),
			$forum->name => site_url('forum/view/'. $forum->id),
			$topic->title => site_url('topic/view/'. $topic->id),
		);
	
		// Menu
		if(Swiftlogin_User::is_logged_in())
		{
			$this->menu['New Reply'] = site_url('reply/create/'. $topic->id);
		}
	}

}
