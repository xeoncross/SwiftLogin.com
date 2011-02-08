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
class Reply_Controller_Update extends Forum_Controller
{
	
	public function action($reply_id = NULL)
	{
		
		$reply = new Forum_Model_Reply(int($reply_id));
		
		if( ! $reply->load())
		{
			return $this->show_404();
		}
		
		// Breadcrumbs
		$this->breadcrumbs = array(
			'Forum Index' => site_url('forum'),
			$reply->topic->forum->name => site_url('forum/view/'. $reply->topic->forum->id),
			$reply->topic->title => site_url('topic/view/'. $reply->topic->id),
		);
		
		$rules = array('text' => 'required|string');
		
		$validation = new Validation();
		//$codestyle = new codestyle;
		
		if( ! $validation->run($rules))
		{
			/*
			// Load the form
			$this->content = new View('reply/crud', 'forum');
			$this->content->validation = $validation;
			*/
			
			// Don't waste time unparsing the text unless you need to!
			$text = isset($_POST['text']) ? post('text') : tuh::unparse($reply->text);
			
			// Create the form
			$fields = array(
				'text' => array('type' => 'textarea', 'value' => $text), //'attributes' => array('class' => 'large'), 
				'submit' => array('type' => 'submit', 'value' => 'Submit')
			);
			$this->content = new form($validation,array('class' => 'formstyle'));
			$this->content->fields($fields);
			
			return;
		}
		
		// Update Reply
		$reply->set(array('text' => tuh::parse(post('text'))));
		
		$reply->save();
		
		// Send them back to the topic
		redirect('topic/view/'. $reply->topic->id);
	}
	
	

	protected function _setup($db = NULL, array $config = NULL)
	{
		// Setup config
		$config = array(
			'model' => 'Forum_Model_Reply',
			'columns' => array('id', 'forum_topic_id', 'text', 'date', 'status',)
		);

		// Call the parent setup
		parent::_setup(registry('db'),$config);
	}
	
	


} // End of Forum Controller
