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
class Topic_Controller_Update extends Forum_Controller
{

	public function action($topic_id = NULL)
	{
		$topic = new Forum_Model_Topic(int($topic_id));
		
		if( ! $topic->load())
		{
			return $this->show_404();
		}
		
		// Only admins (or the row creator) can edit
		Swiftlogin_User::check_access(config('admin_role','forum'), $topic->user_id);
		
		// Breadcrumbs
		$this->breadcrumbs = array(
			'Forum Index' => site_url('forum'),
			$topic->forum->name => site_url('forum/view/'. $topic->forum->id),
			$topic->title => site_url('topic/view/'. $topic->id),
		);
		
		$rules = array(
			'title' => 'required|string|max_length[100]',
			'text' => 'required|string|max_length['. config('max_text_length', 'forum')
			. ']|min_length['. config('min_text_length', 'forum'). ']'
		);
		
		$validation = new Validation();
		
		if( ! $validation->run($rules))
		{
			
			// Don't waste time unparsing the text unless you need to!
			$text = isset($_POST['text']) ? post('text') : tuh::unparse($topic->text);
			
			// Create the form
			$fields = array(
				'title' => array('type' => 'text', 'value' => post('title', $topic->title)),
				'text' => array('type' => 'textarea', 'value' => $text), //'attributes' => array('class' => 'large'),
				'submit' => array('type' => 'submit', 'value' => 'Submit')
			);
			$this->content = new Form($validation, array('class' => 'formstyle'));
			$this->content->fields($fields);
			
			return;
		}
		
		// Update Reply
		$topic->set(array(
			'title' => h(post('title')),
			'text' => tuh::parse(post('text'))
		));
		
		$topic->save();
		
		// Send them back to the topic
		redirect('topic/view/'. $topic->id);
		exit();
	}

}
