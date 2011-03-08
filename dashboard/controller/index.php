<?php
class Dashboard_Controller_Index extends Controller
{
	public $template = 'admin_layout';

	public function action()
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

		$this->css[] = '/admin/view/style.css';
		$view = new View('index', 'dashboard');

		// Top failed domains
		$view->failed_domains = $this->db->fetch('SELECT domain.domain, failure.domain_id, COUNT(failure.id) AS count FROM failure LEFT JOIN domain on domain.id = failure.domain_id GROUP BY failure.domain_id, domain.domain ORDER BY count DESC LIMIT 20');

		//Top failed emails
		$view->failed_emails = $this->db->fetch('SELECT email, COUNT(*) AS count FROM failure GROUP BY email ORDER BY count DESC LIMIT 20');

		//Top failed ips
		$view->failed_ips = $this->db->fetch('SELECT ip_address, COUNT(*) AS count FROM failure GROUP BY ip_address ORDER BY count DESC LIMIT 20');

		//Top failed actions
		$view->failed_actions = $this->db->fetch('SELECT action, COUNT(*) AS count FROM failure GROUP BY action ORDER BY count DESC LIMIT 20');

		// Top sites people have logged into
		$view->top_login_domains = $this->db->fetch('SELECT domain.domain, linked.domain_id, COUNT(linked.id) AS count FROM linked LEFT JOIN domain on domain.id = linked.domain_id GROUP BY linked.domain_id, domain.domain ORDER BY count DESC LIMIT 20');

		// Top domains by user email
		$view->top_user_domains = $this->db->fetch('SELECT domain.domain, "user".domain_id, COUNT("user".id) AS count FROM "user" LEFT JOIN domain on domain.id = "user".domain_id GROUP BY "user".domain_id, domain.domain ORDER BY count DESC LIMIT 20');

		// load view
		$this->content = $view;
	}
}
