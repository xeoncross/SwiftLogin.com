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
class Topic_Controller_Create extends Forum_Controller
{
	public function action($forum_id = NULL)
	{
		// Is this user allowed?
		Swiftlogin_User::check_access(config('topic_role','forum'));
		
		// Did they just create something
		if($this->user_must_wait('Forum_Model_Topic'))
		{
			$this->content = new View('wait', 'topic');
			return;
		}
		
		// Try to find forum
		$forum = new Forum_Model_Forum(int($forum_id));
		
		if( ! $forum->load())
		{
			return $this->show_404();
		}
		
		// Breadcrumbs
		$this->breadcrumbs = array(
			'Forum Index' => site_url('forum'),
			$forum->name => site_url('forum/view/'. $forum->id),
		);
		
		$rules = array(
			'title' => 'required|string|max_length[100]',
			'text' => 'required|string|max_length['. config('max_text_length', 'forum'). ']|min_length['. config('min_text_length', 'forum'). ']'
		);
		
		$validation = new Validation();
		
		if( ! $validation->run($rules))
		{
			
			// Create the form
			$fields = array(
				'title' => array('type' => 'text'),
				'text' => array('type' => 'textarea'), // 'attributes' => array('class' => 'large'),
				'submit' => array('type' => 'submit', 'value' => 'Submit')
			);
			$this->content = new Form($validation, array('class' => 'formstyle'));
			$this->content->fields($fields);
			
			return;
		}
		
		$topic = new Forum_Model_Topic();
		
		// Create new forum topic
		$topic->set(array(
			'title' => h(post('title')),
			'text' => tuh::parse(post('text')),
			'forum_id' => $forum->id,
			'user_id' => Swiftlogin_User::id()
		));
		
		$topic->save();
		
		// Send them back to the topic
		redirect('topic/view/'. $topic->id);
		
	}

}
