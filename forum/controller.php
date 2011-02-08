<?php
/**
 * Forum
 *
 * Provide common methods for the Forum controllers
 * 
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2010 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */

// Not used
define('FORUM_DISABLED', 0);
define('FORUM_ACTIVE', 1);
define('FORUM_STICKY', 2);

// Global Permission Object
Class Forum_User { public static $is_admin = FALSE; }

/*
 * Controller for the forum system.
 */
class Forum_Controller extends Controller
{
	//ID of current user if logged in
	public $user_id = NULL;
	
	public $template = 'thin_layout';
	
	public function __construct()
	{
		// Load the Database
		$config = config('database');
		$this->db = new DB($config['default']);
		
		// Set the default global ORM database object
		ORM::$db = $this->db;
		
		// Store the database object
		registry('db', $this->db);
		
		// Start the Session
		Session::start();
		
		// Construct current URL for functions that "return_to"
		//$this->safe_uri = base64_url_encode(url());

		// Is this user an admin?
		if(Swiftlogin_User::is_logged_in())
		{
			Forum_User::$is_admin = Swiftlogin_User::is_role(config('admin_role', 'forum'));
		}

		//Load the forum Headline
		//$this->views['headline'] = load::view('forum/headline', $this->view_data);

		// Load CSS file
		$this->css[] = 'forum/view/forum.css';	
	}


	// Load page inside the forum layout ;)
	public function render()
	{
		// Don't do this on admin pages
		//if(!in_array(url(1), array('admin','update')))
		if(url(1) !=='admin')
		{
			$content = new View('layout', 'forum');
			$content->set($this);
			$this->content = (string) $content;
		}
		
		$this->sidebar = new View('sidebar');
		
		Session::save();
		
		parent::render();
	}
	
	
	// Don't use the forum layout for 404 pages 
	public function show_404()
	{
		unset($this->layout);
		parent::show_404();
	}

	
	/**
	 * To keep down spam and trolls we will make sure user has to wait before posting again
	 * 
	 * @return boolean
	 */
	protected function user_must_wait($model)
	{
		// Doesn't apply to admins
		if(Swiftlogin_User::is_role(config('admin_role', 'forum')))
		{
			return FALSE;
		}
		
		// Max life of old login records
		$date = sql_date(time() - config('wait_time', 'forum'));
		
		// If any new topics/replies in this time
		return (bool) $model::count(array("\"created\" > '$date'", 'user_id' => Swiftlogin_User::id()));
	}
	
} // End of Forum
