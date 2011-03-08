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
class Forum_Controller_View extends Forum_Controller
{

	/**
	 * Show the topics inside a forum
	 * 
	 * @param int $forum_id the forum ID
	 * @param int $page the current page of topics
	 */
	public function action($forum_id = NULL, $page = 1)
	{
		// Clean user variables
		$page = int($page, 1);
		$forum_id = int($forum_id);

		// Load this forum
		$forum = new Forum_Model_Forum($forum_id);

		// If this forum was not found
		if($page < 1 OR ! $forum->load())
		{
			return $this->show_404();
		}
		
		$view = new View('view', 'forum');
		$view->forum = $forum;
		
		// How many do we show per page?
		$per_page = config('reply_pagination', 'forum');
		
		// Calculate the offset
		$offset = ($page * $per_page) - $per_page;

		// Fetch the topics
		$view->topics = $forum->topics(array('status' => 1), $per_page, $offset);

		// Count the total number
		$total = $forum->count_topics(array('status' => 1));

		// Pagination URL
		$url = site_url('forum/view/'. $forum_id. '/[[page]]');

		// Render Pagination
		$this->pagination = new Pagination($total, $url, $page, $per_page);

		// Breadcrumbs
		$this->breadcrumbs = array(
			'Forum Index' => site_url('forum'),
			$forum->name => site_url('forum/view/'. $forum->id),
		);
		
		// Menu
		if(Swiftlogin_User::is_logged_in())
		{
			$this->menu['New Topic'] = site_url('topic/create/'. $forum->id);
		}
		
		// Set the content
		$this->content = $view;
		
	}

}
