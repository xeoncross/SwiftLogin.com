<?php
/**
 * Admin (Database Management) Class
 *
 * This class allows easy scaffolding of database tables to help with admin
 * tasks such as approving, disabling, reviewing, searching, deleting, and other
 * common table tasks.
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
abstract class Admin_Controller extends Controller
{
	public $template = 'admin_layout';
	
	/**
	 * Administration Area
	 * 
	 * @param array $config settings
	 */
	protected function admin($config = array())
	{
		$this->css[] = '/admin/view/style.css';
		
		// Setup defaults
		$config = $config + config(NULL,'admin');
		
		$model = $config['model'];
		$pp = $config['per_page'];
		
		// URI Structure: /forum/admin/2/topic/desc/title/YQ~~
		$page = int(url(2),1);
		$field = url(3);
		$sort = url(4) == 'asc' ? 'asc' : 'desc';
		$where = array();
		$order_by = array();
		
		// Look in $_POST first, then check the URL
		$column = (string) post('column', url(5));
		$term = (string) post('term', base64_url_decode(url(6)));
		
		// Valid?
		if($column AND in_array($column,$config['columns']))
		{
			$where = array('"'.$column.'" LIKE '.ORM::$db->quote("%$term%"));
		}
		
		// Valid?
		if($field AND in_array($field,$config['columns']))
		{
			$order_by = array($field => $sort);
		}
		
		// Load rows
		$result = $model::fetch($where,$pp,(($page*$pp)-$pp),$order_by);
		$count = $model::count($where);
		
		//If not found
		if( ! $result)
		{
			$this->content = new View('no_rows','admin');
			$this->content->set($config);
			return;
		}
		
		//Make the results into an object
		$result = (object) $result;

		//Allow the controller to process these rows
		$this->pre_admin_display($result);

		//Allow hooks to change the $row data before showing it
		event('administration_'.$model::$t, $result);

		//We must reset the array pointer
		reset($result);
		
		//For each post - place it in a template
		$data = array(
			'rows'		=> $result,
			'columns'	=> $config['columns'],
			'config'	=> $config,
			'page'		=> $page,
			'field'		=> $field,
			'sort'		=> $sort,
			'column'	=> $column,
			'term'		=> $term,
		);
		
		// Pagination URI
		$url = $config['admin_url']. '/[[page]]/'.$field.'/'.$sort.'/'.($column ? $column. '/'. base64_url_encode($term) : '');

		// Create the pagination
		$this->pagination = new Pagination($count, $url, $page, $pp);
		
		//Load the form view (and return it)
		$v = new view('admin','admin');
		$v->set($data);
		
		$this->content = $v;
	}


	/**
	 * Process the given row ID's
	 *
	 * @param array $ids the ids to alter
	 * @param string $action the action name
	 */
	protected function process($config = array())
	{
		// Setup defaults
		$config = $config + config(NULL,'admin');
		
		// If there is no page to return to - then go back to admin
		$return_to = url(2, $config['admin_url']);
		
		// Validate
		if( ! Session::token(post('token')) OR ! post('ids') OR ! is_array(post('ids')) OR ! post('action') OR empty($config['actions'][post('action')]))
		{
			redirect(base64_url_decode($return_to));
			exit();
		}
		
		$process = $config['actions'][post('action')];
		$model = $config['model'];
		
		// Run each actions
		foreach(post('ids') as $id)
		{
			$object = new $model($id);
		
			// Remove?
			if(isset($process['delete']))
			{
				//$object->delete();
				continue;
			}
			
			// We are approving/banning/activating/promoting/etc...
			if(isset($process['columns']))
			{
				foreach($process['columns'] as $column => $value)
				{
					$object->$column = $value;
				}
				$object->save();
			}
		}
		
		// And back we go!
		redirect(base64_url_decode($return_to));
		exit();
	}

	
	/**
	 * This method can be extended by the controller to allowing additional
	 * processing of the rows before display.
	 * 
	 * @param object $results and object containing the result rows
	 */
	protected function pre_admin_display($results) {}
	
}
