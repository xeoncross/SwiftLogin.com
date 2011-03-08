<?php
class Account_Controller_Process extends SwiftLogin_Admin
{
	public function action()
	{
		$config = config('admin','account');

		// Run
		$this->process($config);
	}
}
