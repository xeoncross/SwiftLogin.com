<?php
class SwiftLogin_Admin extends Admin_Controller
{
	
	public function admin($config = array())
	{
		$this->load();
		parent::admin($config);
	}
	
	public function process($config = array())
	{
		$this->load();
		parent::process($config);
	}
	
	protected function load()
	{
		// Start the Session
		Session::start();
		
		// Only admins allowed here
		Swiftlogin_User::check_access('admin');
		
		// Load config settings
		$config = config('database');
		
		// Load database
		$this->db = new DB($config['default']);
		
		// Set ORM database connection
		ORM::$db = $this->db;
		
		// Now run admin
		//parent::admin($config);
	}
	
	// Save session before exit
	public function render()
	{
		Session::token();
		Session::save();
		parent::render();
	}
}