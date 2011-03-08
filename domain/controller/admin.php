<?php
class Domain_Controller_Admin extends SwiftLogin_Admin
{
	//public $template = 'thin_layout';
	public function action()
	{
		$config = config('admin','domain');

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

			$result->banned = $result->banned ? 'banned' : '';
			$result->ignore = $result->ignore ? 'ignore' : '';
		}
	}
}
