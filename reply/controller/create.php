<?php
/**
 * Forum Reply
 *
 * Allow creation/updating of forum replies and create reply admin area.
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
class Reply_Controller_Create extends Forum_Controller
{
	
	public function action($topic_id = NULL)
	{
		
		$topic = new Forum_Model_Topic(int($topic_id));
		
		if( ! $topic->load())
		{
			return $this->show_404();
		}
		
		// Breadcrumbs
		$this->breadcrumbs = array(
			'Forum Index' => site_url('forum'),
			$topic->forum->name => site_url('forum/view/'. $topic->forum->id),
			$topic->title => site_url('topic/view/'. $topic->id),
		);
		
		$validation = new Validation();
		
		if( ! $validation->run(array('text' => 'required|string')))
		{
			/*
			// Load the form
			$this->content = new View('reply/crud', 'forum');
			$this->content->validation = $validation;
			*/
			
			// Create the form
			$fields = array(
				'text' => array('type' => 'textarea'), // 'attributes' => array('class' => 'large')),
				'submit' => array('type' => 'submit', 'value' => 'Submit')
			);
			$this->content = new Form($validation, array('class' => 'formstyle'));
			$this->content->fields($fields);
			
			return;
		}
		
		//$this->content = 'Creating new reply to topic'. $topic->title;
		
		//$codestyle = new codestyle;
		$reply = new Forum_Model_Reply();
		
		// Create new forum reply
		$reply->set(array(
			'text' => tuh::parse(post('text')),
			'forum_id' => $topic->forum_id,
			'forum_topic_id' => $topic->id,
			'user_id' => Swiftlogin_User::id()
		));
		
		$reply->save();
		
		// Update the topic also!
		$topic->last_activity = sql_date();
		$topic->save();
		
		// Send them back to the topic
		redirect('topic/view/'. $topic->id);
		
	}

} // End of Forum Controller
