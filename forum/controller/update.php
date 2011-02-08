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
class Forum_Controller_Update extends Forum_Controller
{

	public function action($forum_id = NULL)
	{
		
		$forum = new Forum_Model_Forum(int($forum_id));
		
		if( ! $forum->load())
		{
			return $this->show_404();
		}
		
		// Breadcrumbs
		$this->breadcrumbs = array('Forum Index' => site_url('forum'));
		
		$rules = array(
			'name' => 'required|string',
			'description' => 'required|string',
			'priority' => 'required|int',
		);
	
		$validation = new Validation();
		
		if( ! $validation->run($rules))
		{
		
			$categories = Forum_Model_Category::fetch();
			
			$ids = array();
			foreach($categories as $category)
			{
				$ids[$category->id] = $category->name;
			}
			
			// Create the form
			$fields = array(
				'name' => array('type' => 'text', 'value' => post('name', $forum->name)),
				'description' => array('type' => 'textarea', 'value' => post('description', $forum->description)),
				'priority' => array(
					'type' => 'select', 
					'options' => array_combine(range(10,-10),range(10,-10)),
					'value' => (int) post('priority', $forum->priority)
				),
				'category' => array('type' => 'select', 'options' => $ids),
				'submit' => array('type' => 'submit', 'value' => 'Submit')
			);
			$this->content = html::form($fields, array('class' => 'formstyle'), $validation);
			return;
		}
		
		
		$forum = new Forum_Model_Forum();
		
		// Create new forum reply
		$forum->set(array(
			'name' => post('name'),
			'description' => post('description'),
			'priority' => int(post('priority')),
			'forum_category_id' => int(post('category')),
		));
		
		$forum->save();
		
		// Send them back to the topic
		redirect('forum');
		
	}
	
	
}
