<?php
class Account_Controller_Admin extends SwiftLogin_Admin
{
	//public $template = 'thin_layout';
	public function action()
	{
		$config = config('admin','account');

		// Run
		$this->admin($config);
	}
	
	/**
	 * Format the results to include links to other helpful pages
	 */
	protected function pre_admin_display($results)
	{	
		$roles = config('roles', 'account');

		foreach($results as &$result)
		{
			$result->created = time::show($result->created);
			$result->modified = time::show($result->modified);
			
			//$domain = explode('@',$result->email);
			//$banned = $this->db->column('SELECT banned FROM "domain" WHERE "domain" = ?', array($domain[1]));

			// Is the forum still here?
			if(isset($result->domain->id))
			{
				$result->domain_id = $result->domain->domain . ' ('. $result->domain->id. ($result->domain->banned ? ',banned' : ''). ')';
			}

			$result->banned = $result->banned ? 'banned' : '';
			
			// Get role name
			$result->role_id = $roles[$result->role_id];
			
		}
	}
}
